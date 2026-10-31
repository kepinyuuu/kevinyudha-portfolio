<?php

namespace Database\Seeders;

use App\Models\DesignWork;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

/**
 * Mengisi data contoh (bertanda "[CONTOH]") hanya untuk APP_ENV=local.
 * Tidak pernah dijalankan di production.
 */
class LocalDevSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            $this->command->warn('LocalDevSeeder dilewati — tidak dijalankan di production.');
            return;
        }

        // ── Profile ───────────────────────────────────────────────────────────
        Profile::updateOrCreate(['id' => 1], [
            'name'             => 'Kevin Yudha Pratama',
            'title'            => 'UI/UX Designer & Developer',
            'bio'              => '[CONTOH] Saya adalah seorang UI/UX Designer & Developer yang passionate dalam menciptakan pengalaman digital yang indah dan fungsional. Menggabungkan estetika desain dengan keahlian teknis untuk membangun produk yang tidak hanya terlihat bagus, tetapi juga bekerja dengan sempurna.',
            'education'        => '[CONTOH] Universitas — Teknik Informatika',
            'education_year'   => '2021 – Sekarang',
            'interests'        => 'UI/UX Design, Web Development, Typography, Branding, Photography',
            'experience'       => null,
            'email'            => 'kevin@example.com',
            'github_url'       => 'https://github.com/kevindev-example',
            'linkedin_url'     => 'https://linkedin.com/in/kevindev-example',
            'instagram_url'    => null,
            'other_social_name'=> null,
            'other_social_url' => null,
            'photo'            => null,
            'hero_headline'    => "Designing Experiences,\nBuilding the Web.",
            'hero_description' => '[CONTOH] UI/UX Designer & Developer yang memadukan kreativitas visual dengan kemampuan teknis untuk menciptakan produk digital yang berkesan.',
            'about_extra'      => null,
        ]);

        // ── Skills ────────────────────────────────────────────────────────────
        $skills = [
            ['name' => 'HTML',         'category' => 'general', 'level' => 90, 'sort_order' => 1],
            ['name' => 'CSS',          'category' => 'general', 'level' => 85, 'sort_order' => 2],
            ['name' => 'JavaScript',   'category' => 'general', 'level' => 75, 'sort_order' => 3],
            ['name' => 'PHP',          'category' => 'general', 'level' => 80, 'sort_order' => 4],
            ['name' => 'Laravel',      'category' => 'general', 'level' => 78, 'sort_order' => 5],
            ['name' => 'MySQL',        'category' => 'general', 'level' => 72, 'sort_order' => 6],
            ['name' => 'UI/UX Design', 'category' => 'design',  'level' => 85, 'sort_order' => 1],
            ['name' => 'Figma',        'category' => 'design',  'level' => 88, 'sort_order' => 2],
            ['name' => 'Adobe XD',     'category' => 'design',  'level' => 75, 'sort_order' => 3],
            ['name' => 'Git',          'category' => 'tools',   'level' => 70, 'sort_order' => 1],
            ['name' => 'Tailwind CSS', 'category' => 'tools',   'level' => 82, 'sort_order' => 2],
            ['name' => 'VS Code',      'category' => 'tools',   'level' => 90, 'sort_order' => 3],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                array_merge($skill, ['is_published' => true])
            );
        }

        // ── Projects ─────────────────────────────────────────────────────────
        $projects = [
            [
                'title'        => '[CONTOH] Portfolio Website',
                'description'  => 'Personal portfolio website dibangun dengan Laravel, Tailwind CSS, dan Alpine.js. Menampilkan proyek, skills, dan karya desain secara dinamis dari database.',
                'technologies' => 'Laravel, Tailwind CSS, Alpine.js, MySQL',
                'demo_url'     => 'https://example.com',
                'github_url'   => 'https://github.com/example/portfolio',
                'is_featured'  => true,
                'is_published' => true,
                'sort_order'   => 1,
            ],
            [
                'title'        => '[CONTOH] E-Commerce Dashboard UI',
                'description'  => 'Desain antarmuka dashboard manajemen toko online dengan tampilan modern, chart interaktif, dan manajemen produk lengkap.',
                'technologies' => 'Figma, UI/UX Design, Prototyping',
                'demo_url'     => null,
                'github_url'   => null,
                'is_featured'  => false,
                'is_published' => true,
                'sort_order'   => 2,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(['title' => $project['title']], $project);
        }

        $this->command->info('LocalDevSeeder: data contoh berhasil diisi.');
    }
}

