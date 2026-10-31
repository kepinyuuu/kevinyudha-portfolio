<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\DesignWork;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email'    => 'admin@kevinportfolio.com',
            'is_admin' => true,
        ]);
    }

    public function test_admin_can_view_dashboard_and_resource_indexes(): void
    {
        $this->actingAs($this->admin)->get(route('admin.dashboard'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.projects.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.skills.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.design-works.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.messages.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.profile.edit'))->assertStatus(200);
    }

    public function test_admin_can_create_and_delete_project(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.projects.store'), [
            'title'        => 'E-Commerce App',
            'description'  => 'A modern e-commerce web application.',
            'technologies' => 'Laravel, Tailwind, MySQL',
            'demo_url'     => 'https://example.com/demo',
            'is_featured'  => '1',
            'is_published' => '1',
            'sort_order'   => 1,
        ]);

        $response->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('projects', ['title' => 'E-Commerce App']);

        $project = Project::where('title', 'E-Commerce App')->firstOrFail();

        $this->actingAs($this->admin)
            ->delete(route('admin.projects.destroy', $project))
            ->assertRedirect(route('admin.projects.index'));

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_admin_can_create_and_delete_skill(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.skills.store'), [
            'name'         => 'Docker',
            'category'     => 'tools',
            'level'        => 80,
            'is_published' => '1',
            'sort_order'   => 5,
        ]);

        $response->assertRedirect(route('admin.skills.index'));
        $this->assertDatabaseHas('skills', ['name' => 'Docker']);

        $skill = Skill::where('name', 'Docker')->firstOrFail();

        $this->actingAs($this->admin)
            ->delete(route('admin.skills.destroy', $skill))
            ->assertRedirect(route('admin.skills.index'));

        $this->assertDatabaseMissing('skills', ['id' => $skill->id]);
    }

    public function test_admin_can_create_and_delete_design_work(): void
    {
        // Fake the configured default disk (s3 in production, whatever is set in .env.testing)
        $disk = config('filesystems.default');
        Storage::fake($disk);

        $file = UploadedFile::fake()->image('design.jpg');

        $response = $this->actingAs($this->admin)->post(route('admin.design-works.store'), [
            'title'        => 'Mobile Banking UI',
            'category'     => 'Mobile App',
            'image'        => $file,
            'description'  => 'Clean fintech mobile application mockup',
            'is_published' => '1',
            'sort_order'   => 1,
        ]);

        $response->assertRedirect(route('admin.design-works.index'));
        $this->assertDatabaseHas('design_works', ['title' => 'Mobile Banking UI']);

        $work = DesignWork::where('title', 'Mobile Banking UI')->firstOrFail();

        $this->actingAs($this->admin)
            ->delete(route('admin.design-works.destroy', $work))
            ->assertRedirect(route('admin.design-works.index'));

        $this->assertDatabaseMissing('design_works', ['id' => $work->id]);
    }

    public function test_admin_can_toggle_read_and_delete_message(): void
    {
        // Use only columns that exist in the migration (read_at, not is_read)
        $message = ContactMessage::create([
            'name'    => 'Jane Smith',
            'email'   => 'jane@example.com',
            'subject' => 'Project Inquiry',
            'message' => 'Hello, I would like to discuss a project with you.',
            // read_at left null = unread
        ]);

        $this->assertNull($message->read_at);
        $this->assertFalse($message->is_read); // virtual accessor

        // Viewing detail marks as read
        $this->actingAs($this->admin)
            ->get(route('admin.messages.show', $message))
            ->assertStatus(200);

        $this->assertNotNull($message->fresh()->read_at);
        $this->assertTrue($message->fresh()->is_read);

        // Toggle back to unread
        $this->actingAs($this->admin)
            ->patch(route('admin.messages.toggle-read', $message));

        $this->assertNull($message->fresh()->read_at);
        $this->assertFalse($message->fresh()->is_read);

        // Delete
        $this->actingAs($this->admin)
            ->delete(route('admin.messages.destroy', $message));

        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    public function test_admin_can_edit_profile(): void
    {
        // Page loads with empty profile
        $this->actingAs($this->admin)
            ->get(route('admin.profile.edit'))
            ->assertStatus(200);

        // Submit profile update
        $response = $this->actingAs($this->admin)->put(route('admin.profile.update'), [
            'name'             => 'Kevin Test',
            'title'            => 'UI/UX Designer',
            'hero_headline'    => "Hello World,\nTest Headline.",
            'hero_description' => 'Test description.',
            'bio'              => 'Test bio.',
            'education'        => 'Test University',
            'education_year'   => '2020 – 2024',
            'interests'        => 'Design, Code',
            'email'            => 'kevin@test.com',
            'github_url'       => 'https://github.com/kevin-test',
        ]);

        $response->assertRedirect(route('admin.profile.edit'));
        $response->assertSessionHas('success');

        $profile = Profile::find(1);
        $this->assertNotNull($profile);
        $this->assertEquals('Kevin Test', $profile->name);
        $this->assertEquals('UI/UX Designer', $profile->title);
        $this->assertEquals('kevin@test.com', $profile->email);
        $this->assertEquals('https://github.com/kevin-test', $profile->github_url);
    }

    public function test_admin_profile_update_clears_blank_social_urls(): void
    {
        Profile::create(['id' => 1, 'name' => 'Kevin', 'title' => 'Dev',
            'bio' => '', 'education' => '', 'email' => 'k@k.com',
            'github_url' => 'https://github.com/old']);

        $this->actingAs($this->admin)->put(route('admin.profile.update'), [
            'name'       => 'Kevin',
            'title'      => 'Dev',
            'email'      => 'k@k.com',
            'github_url' => '', // cleared
        ])->assertRedirect(route('admin.profile.edit'));

        $this->assertNull(Profile::find(1)->github_url);
    }

    public function test_admin_profile_photo_upload(): void
    {
        $disk = config('filesystems.default');
        Storage::fake($disk);

        $photo = UploadedFile::fake()->image('avatar.jpg', 200, 200);

        $this->actingAs($this->admin)->put(route('admin.profile.update'), [
            'name'  => 'Kevin',
            'title' => 'Designer',
            'photo' => $photo,
        ])->assertRedirect(route('admin.profile.edit'));

        $profile = Profile::find(1);
        $this->assertNotNull($profile->photo);
        Storage::disk($disk)->assertExists($profile->photo);
    }

    public function test_admin_profile_edit_renders_with_null_profile(): void
    {
        $view = $this->actingAs($this->admin)->view('admin.profile.edit', [
            'profile' => null,
            'errors'  => new \Illuminate\Support\ViewErrorBag(),
        ]);
        $view->assertSee('Edit Profil');
    }
}
