<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class AdminSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_seeder_creates_user_from_config(): void
    {
        config([
            'admin.name'     => 'Test Admin',
            'admin.email'    => 'testadmin@example.com',
            'admin.password' => 'SecurePass!99',
        ]);

        $this->seed(AdminSeeder::class);

        $user = User::where('email', 'testadmin@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->is_admin);
        $this->assertEquals('Test Admin', $user->name);
    }

    public function test_admin_seeder_throws_when_credentials_missing(): void
    {
        config(['admin.name' => null, 'admin.email' => null, 'admin.password' => null]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/ADMIN_NAME/');

        $this->seed(AdminSeeder::class);
    }

    public function test_admin_seeder_throws_when_only_password_missing(): void
    {
        config([
            'admin.name'     => 'Test Admin',
            'admin.email'    => 'admin@example.com',
            'admin.password' => null,
        ]);

        $this->expectException(RuntimeException::class);
        $this->seed(AdminSeeder::class);
    }

    public function test_admin_seeder_is_idempotent(): void
    {
        config([
            'admin.name'     => 'Admin User',
            'admin.email'    => 'admin@example.com',
            'admin.password' => 'Pass!1234',
        ]);

        $this->seed(AdminSeeder::class);
        $this->seed(AdminSeeder::class); // run twice

        $this->assertEquals(1, User::where('email', 'admin@example.com')->count());
    }
}

