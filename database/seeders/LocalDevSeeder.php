<?php

namespace Database\Seeders;

use App\Models\DesignWork;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

/**
 * Seeder pengembang: membaca dari config/portfolio.php jika diisi (bukan 'ISI'),
 * tanpa data dummy tiruan hardcoded.
 */
class LocalDevSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            $this->command->warn('LocalDevSeeder dilewati — tidak dijalankan di environment production.');
            return;
        }

        // ── 1. Profile dari config/portfolio.php ─────────────────────────────
        $cfgProfile = config('portfolio.profile', []);
        $profileData = [];

        foreach ($cfgProfile as $key => $val) {
            if ($val !== 'ISI' && filled($val)) {
                $profileData[$key] = $val;
            }
        }

        if (! empty($profileData)) {
            Profile::updateOrCreate(['id' => 1], $profileData);
            $this->command->info('LocalDevSeeder: Profil berhasil diselaraskan dari config/portfolio.php.');
        }

        // ── 2. Skills dari config/portfolio.php ──────────────────────────────
        $cfgSkills = config('portfolio.skills', []);
        $seededSkillsCount = 0;

        foreach ($cfgSkills as $skill) {
            if (! empty($skill['name']) && $skill['name'] !== 'ISI') {
                Skill::updateOrCreate(
                    ['name' => $skill['name']],
                    [
                        'category'     => ($skill['category'] !== 'ISI' && filled($skill['category'])) ? $skill['category'] : 'general',
                        'level'        => is_numeric($skill['level'] ?? null) ? (int)$skill['level'] : 80,
                        'sort_order'   => is_numeric($skill['sort_order'] ?? null) ? (int)$skill['sort_order'] : 1,
                        'is_published' => true,
                    ]
                );
                $seededSkillsCount++;
            }
        }

        if ($seededSkillsCount > 0) {
            $this->command->info("LocalDevSeeder: {$seededSkillsCount} skill berhasil di-seed dari config.");
        }

        // ── 3. Projects dari config/portfolio.php ────────────────────────────
        $cfgProjects = config('portfolio.projects', []);
        $seededProjectsCount = 0;

        foreach ($cfgProjects as $project) {
            if (! empty($project['title']) && $project['title'] !== 'ISI') {
                Project::updateOrCreate(
                    ['title' => $project['title']],
                    [
                        'description'  => $project['summary'] ?? $project['description'] ?? '',
                        'technologies' => is_array($project['tags'] ?? null) ? implode(', ', $project['tags']) : ($project['technologies'] ?? ''),
                        'image'        => $project['cover'] ?? $project['image'] ?? null,
                        'demo_url'     => ($project['demo_url'] ?? null) !== 'ISI' ? ($project['demo_url'] ?? null) : null,
                        'github_url'   => ($project['github_url'] ?? null) !== 'ISI' ? ($project['github_url'] ?? null) : null,
                        'is_featured'  => filter_var($project['is_featured'] ?? false, FILTER_VALIDATE_BOOLEAN),
                        'is_published' => true,
                        'sort_order'   => is_numeric($project['sort_order'] ?? null) ? (int)$project['sort_order'] : 1,
                    ]
                );
                $seededProjectsCount++;
            }
        }

        if ($seededProjectsCount > 0) {
            $this->command->info("LocalDevSeeder: {$seededProjectsCount} proyek berhasil di-seed dari config.");
        }

        // ── 4. Design Works dari config/portfolio.php ────────────────────────
        $cfgWorks = config('portfolio.design_works', []);
        $seededWorksCount = 0;

        foreach ($cfgWorks as $work) {
            if (! empty($work['title']) && $work['title'] !== 'ISI') {
                DesignWork::updateOrCreate(
                    ['title' => $work['title']],
                    [
                        'category'     => ($work['category'] !== 'ISI') ? ($work['category'] ?? 'Design') : 'Design',
                        'image'        => ($work['image'] !== 'ISI') ? ($work['image'] ?? '') : '',
                        'description'  => ($work['description'] !== 'ISI') ? ($work['description'] ?? null) : null,
                        'is_published' => true,
                        'sort_order'   => is_numeric($work['sort_order'] ?? null) ? (int)$work['sort_order'] : 1,
                    ]
                );
                $seededWorksCount++;
            }
        }

        if ($seededWorksCount > 0) {
            $this->command->info("LocalDevSeeder: {$seededWorksCount} karya desain berhasil di-seed dari config.");
        }

        if (empty($profileData) && $seededSkillsCount === 0 && $seededProjectsCount === 0 && $seededWorksCount === 0) {
            $this->command->info('LocalDevSeeder: Data dummy lama telah dibersihkan. Isi config/portfolio.php untuk mengimpor data awal.');
        }
    }
}
