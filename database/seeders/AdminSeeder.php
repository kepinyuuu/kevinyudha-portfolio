<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $name     = config('admin.name');
        $email    = config('admin.email');
        $password = config('admin.password');

        if (blank($name) || blank($email) || blank($password)) {
            throw new RuntimeException(
                "Seeder gagal: ADMIN_NAME, ADMIN_EMAIL, dan ADMIN_PASSWORD harus diisi di .env. " .
                "Tidak ada nilai default untuk mencegah penggunaan credential lemah di production."
            );
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name'     => $name,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]
        );

        $this->command->info("Admin user '{$email}' siap.");
    }
}

