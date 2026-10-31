<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_portfolio_page_can_be_rendered(): void
    {
        Profile::create([
            'id' => 1,
            'name' => 'Kevin Yudha Pratama',
            'title' => 'UI/UX Designer & Developer',
            'bio' => 'Saya adalah seorang UI/UX Designer & Developer.',
            'education' => 'Universitas',
            'email' => 'kevin@example.com',
            'hero_headline' => "Designing Experiences,\nBuilding the Web.",
            'hero_description' => 'Test description',
        ]);

        Skill::create([
            'name' => 'Laravel',
            'category' => 'general',
            'level' => 85,
            'is_published' => true,
            'sort_order' => 1,
        ]);

        Project::create([
            'title' => 'Sample Project',
            'description' => 'Project description',
            'technologies' => 'Laravel, Tailwind',
            'is_published' => true,
            'sort_order' => 1,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Kevin Yudha Pratama');
        $response->assertSee('Laravel');
        $response->assertSee('Sample Project');
    }

    public function test_contact_form_submits_successfully(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Kolaborasi Project',
            'message' => 'Halo Kevin, saya tertarik untuk mengajak kolaborasi.',
        ]);

        $response->assertSessionHas('contact_success', true);
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Kolaborasi Project',
        ]);
    }

    public function test_contact_form_honeypot_discards_spam_silently(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Spammer Bot',
            'email' => 'spammer@bot.com',
            'subject' => 'Spam Title',
            'message' => 'Buy cheap shoes here',
            'website' => 'http://spamurl.com', // Honeypot filled
        ]);

        $response->assertSessionHas('contact_success', true);
        $this->assertDatabaseMissing('contact_messages', [
            'name' => 'Spammer Bot',
        ]);
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->post('/contact', [
            'name' => '',
            'email' => 'invalid-email',
            'subject' => '',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }

    public function test_admin_login_and_access_control(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('secret123'),
            'is_admin' => true,
        ]);

        $regularUser = User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('secret123'),
            'is_admin' => false,
        ]);

        // Guest accessing admin dashboard gets redirected
        $guestResponse = $this->get('/admin');
        $guestResponse->assertRedirect('/admin/login');

        // Non-admin attempting login
        $nonAdminLogin = $this->post('/admin/login', [
            'email' => 'user@test.com',
            'password' => 'secret123',
        ]);
        $nonAdminLogin->assertSessionHasErrors('email');
        $this->assertGuest();

        // Admin login succeeds
        $adminLogin = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'secret123',
        ]);
        $adminLogin->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);

        // Authenticated admin can access dashboard
        $dashboardResponse = $this->actingAs($admin)->get('/admin');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Dashboard');
    }
}
