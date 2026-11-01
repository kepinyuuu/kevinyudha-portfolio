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

    public function test_cv_data_is_displayed_accurately_on_portfolio(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // Identitas & Bio CV
        $response->assertSee('Kevin Yudha Pratama');
        $response->assertSee('Kevin Yudha P.');
        $response->assertSee('Web Development &amp; Designer', false);
        $response->assertSee('SMK Negeri 1 Bangsri');
        $response->assertSee('Pengembangan Perangkat Lunak dan Gim (PPLG)');
        $response->assertSee('Bangsri, Jepara, Jawa Tengah');

        // Kontak valid
        $response->assertSee('kepinyud67@gmail.com');
        $response->assertSee('https://github.com/kepinyuuu');

        // Skills & Tingkat kemampuan jujur
        $response->assertSee('HTML &amp; CSS', false);
        $response->assertSee('JavaScript (Dasar)');
        $response->assertSee('PHP (Dasar)');
        $response->assertSee('Laravel (Dasar)');
        $response->assertSee('UI/UX Design (Figma)');
        $response->assertSee('Microsoft Excel (Dasar)');
        $response->assertSee('Komunikasi yang Baik');

        // Pengalaman & Selected Projects
        $response->assertSee('Website UMKM Omah Vektor');
        $response->assertSee('Perancangan Antarmuka Website');
    }

    public function test_empty_cv_fields_and_inactive_sections_are_hidden(): void
    {
        $response = $this->get('/');
        $content = $response->getContent();

        // LinkedIn dan Figma tidak memiliki URL di CV -> harus disembunyikan
        $this->assertStringNotContainsString('linkedin.com', $content);
        $this->assertStringNotContainsString('figma.com', $content);

        // Telepon/WA disembunyikan secara default (show_phone = false)
        $this->assertStringNotContainsString('+62 838 3152 0933', $content);
        $this->assertStringNotContainsString('wa.me/6283831520933', $content);

        // Tidak ada sisa dummy lama
        $this->assertStringNotContainsString('kevin@example.com', $content);
        $this->assertStringNotContainsString('John Doe', $content);
        $this->assertStringNotContainsString('Sample Project', $content);

        // Design Showcase / Experiments kosong -> disembunyikan
        $this->assertStringNotContainsString('Karya Desain', $content);
        $this->assertStringNotContainsString('id="design"', $content);

        // Tidak boleh ada tautan kosong atau href="#" kosong
        $this->assertStringNotContainsString('href="#"', $content);
        $this->assertStringNotContainsString('href=""', $content);
    }

    public function test_whatsapp_button_appears_only_when_show_phone_is_true(): void
    {
        config(['portfolio.profile.show_phone' => true]);

        $response = $this->get('/');
        $response->assertSee('wa.me/6283831520933');
    }

    public function test_contact_form_submits_successfully(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Budi Santoso',
            'email' => 'budi@mail.com',
            'subject' => 'Diskusi Proyek Web',
            'message' => 'Halo Kevin, saya tertarik mendiskusikan pembuatan website.',
        ]);

        $response->assertSessionHas('contact_success', true);
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Budi Santoso',
            'email' => 'budi@mail.com',
            'subject' => 'Diskusi Proyek Web',
        ]);
    }

    public function test_contact_form_honeypot_discards_spam_silently(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Spammer Bot',
            'email' => 'spammer@bot.com',
            'subject' => 'Spam Title',
            'message' => 'Buy cheap shoes here',
            'website' => 'http://spamurl.com', // Honeypot terisi
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

    public function test_no_experience_section_or_links_exist(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $content = $response->getContent();

        // Tidak boleh ada id section atau tautan yang mengarah ke pengalaman
        $this->assertStringNotContainsString('href="#experience"', $content);
        $this->assertStringNotContainsString('href="#pengalaman"', $content);
        $this->assertStringNotContainsString('id="experience"', $content);
        $this->assertStringNotContainsString('id="pengalaman"', $content);
        $this->assertStringNotContainsString('data-section="experience"', $content);
        $this->assertStringNotContainsString('data-section="pengalaman"', $content);
        $this->assertStringNotContainsString('#pengalaman-', $content);

        // Tidak boleh ada sisa tautan section lama
        $this->assertStringNotContainsString('href="#proyek"', $content);
        $this->assertStringNotContainsString('id="proyek"', $content);
        $this->assertStringNotContainsString('data-section="proyek"', $content);

        // Menu navbar baru menggunakan #projects
        $this->assertStringContainsString('href="#projects"', $content);
        $this->assertStringContainsString('id="projects"', $content);
    }

    public function test_english_navigation_labels_and_accessibility(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $content = $response->getContent();

        // 1. Menu navbar desktop, mobile, & footer memuat 5 label bahasa Inggris
        $expectedLabels = ['Home', 'About', 'Skills', 'Projects', 'Contact'];
        foreach ($expectedLabels as $label) {
            $this->assertStringContainsString($label, $content);
        }

        // 2. Tidak ada label navigasi lama Bahasa Indonesia di navbar & footer
        $this->assertStringNotContainsString('>Tentang<', $content);
        $this->assertStringNotContainsString('>Keahlian<', $content);
        $this->assertStringNotContainsString('>Proyek<', $content);
        $this->assertStringNotContainsString('>Kontak<', $content);
        $this->assertStringNotContainsString('>Beranda<', $content);

        // 3. Tombol aksi
        $this->assertStringContainsString('View Projects', $content);
        $this->assertStringContainsString('Contact Me', $content);
        $this->assertStringContainsString('Email', $content);
        $this->assertStringNotContainsString('Lihat Proyek', $content);
        $this->assertStringNotContainsString('Hubungi Saya', $content);

        // 4. Aksesibilitas & UI labels
        $this->assertStringContainsString('Skip to content', $content);
        $this->assertStringContainsString('Open menu', $content);
        $this->assertStringContainsString('Close menu', $content);
        $this->assertStringContainsString('Switch to light mode', $content);
        $this->assertStringContainsString('Go to About section', $content);

        // 5. Seluruh anchor link mengarah ke id yang benar-benar ada di halaman
        $anchors = ['#main-content', '#home', '#about', '#skills', '#projects', '#contact'];
        foreach ($anchors as $anchor) {
            $id = ltrim($anchor, '#');
            $this->assertStringContainsString("href=\"{$anchor}\"", $content);
            $this->assertStringContainsString("id=\"{$id}\"", $content);
        }

        // 6. html tag mempertahankan lang="id"
        $this->assertStringContainsString('<html lang="id"', $content);
    }

    public function test_project_cards_display_omah_vektor_once(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $content = $response->getContent();

        // Kartu Omah Vektor tampil sekali saja
        $cardOccurrences = substr_count($content, 'id="project-card-website-umkm-omah-vektor"');
        $this->assertSame(1, $cardOccurrences, 'Kartu proyek Website UMKM Omah Vektor harus tampil tepat satu kali.');

        // Kartu Perancangan Antarmuka Website juga tampil satu kali
        $secondCardOccurrences = substr_count($content, 'id="project-card-perancangan-antarmuka-website"');
        $this->assertSame(1, $secondCardOccurrences, 'Kartu proyek Perancangan Antarmuka Website harus tampil tepat satu kali.');

        // Kartu Portfolio Pribadi tampil satu kali
        $thirdCardOccurrences = substr_count($content, 'id="project-card-website-portfolio-pribadi"');
        $this->assertSame(1, $thirdCardOccurrences, 'Kartu proyek Website Portfolio Pribadi harus tampil tepat satu kali.');
    }

    public function test_three_project_cards_are_present(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        $response->assertSee('Website UMKM Omah Vektor');
        $response->assertSee('Perancangan Antarmuka Website');
        $response->assertSee('Website Portfolio Pribadi');

        // Verifikasi proyek ketiga memiliki poin yang benar
        $response->assertSee('Merancang tata letak, tipografi, dan palet warna untuk mode gelap dan terang.');
        $response->assertSee('Membangun halaman responsif untuk desktop, tablet, dan HP.');
        $response->assertSee('Menyajikan konten profil, keahlian, dan proyek dari satu file konfigurasi.');
    }

    public function test_demo_github_buttons_hidden_when_urls_empty(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $content = $response->getContent();

        // Semua proyek memiliki demo_url dan github_url null —
        // tidak boleh ada link tombol Demo atau GitHub aktif di kartu
        // (tombol hanya muncul di modal via x-show Alpine, tidak dirender di HTML statik)
        // Verifikasi tidak ada href ke null atau href="#" pada link Demo/GitHub
        $this->assertStringNotContainsString('href="null"', $content);
        $this->assertStringNotContainsString(':href="null"', $content);
    }

    public function test_experience_points_appear_in_project_details(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        $projects = config('portfolio.projects', []);
        $this->assertNotEmpty($projects);

        foreach ($projects as $project) {
            foreach ($project['points'] as $point) {
                $response->assertSee($point);
            }
        }
    }

    public function test_project_cards_display_cover_and_fallback(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        // Omah Vektor memiliki sampul yang valid
        $response->assertSee('Sampul Website UMKM Omah Vektor');
        $response->assertSee('Perancangan Antarmuka Website');

        // Jika cover bernilai null, fallback bertema ditampilkan tanpa tag img palsu
        config([
            'portfolio.projects.1.cover' => null,
        ]);

        $responseFallback = $this->get('/');
        $responseFallback->assertOk();
        $responseFallback->assertDontSee('Sampul Perancangan Antarmuka Website');
        $responseFallback->assertSee('Perancangan Antarmuka Website');
    }

    public function test_no_img_tags_with_empty_src_or_alt(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $content = $response->getContent();

        // Cari semua tag <img> dan verifikasi src & alt tidak kosong
        preg_match_all('/<img[^>]+>/i', $content, $matches);
        $this->assertNotEmpty($matches[0], 'Halaman harus memuat setidaknya satu tag img yang valid.');

        foreach ($matches[0] as $imgTag) {
            // src tidak boleh kosong ("" atau '') atau '#'
            $this->assertDoesNotMatch($imgTag, '/(?<!:)src=(["\'])\s*\1/i', "Tag img tidak boleh memiliki src kosong: {$imgTag}");
            $this->assertDoesNotMatch($imgTag, '/(?<!:)src=(["\'])#\1/i', "Tag img tidak boleh memiliki src='#': {$imgTag}");

            // alt tidak boleh kosong ("" atau '')
            $this->assertDoesNotMatch($imgTag, '/(?<!:)alt=(["\'])\s*\1/i', "Tag img tidak boleh memiliki alt kosong: {$imgTag}");
        }
    }

    private function assertDoesNotMatch(string $haystack, string $pattern, string $message = ''): void
    {
        $this->assertFalse((bool) preg_match($pattern, $haystack), $message);
    }
}
