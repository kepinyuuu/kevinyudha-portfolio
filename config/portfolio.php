<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Identitas & Profil (Sesuai CV Kevin Yudha Pratama)
    |--------------------------------------------------------------------------
    */
    'profile' => [
        'name'              => 'Kevin Yudha Pratama',
        'short_name'        => 'Kevin Yudha P.',
        'title'             => 'Web Development & Designer',
        'location'          => 'Bangsri, Jepara, Jawa Tengah',
        'hero_headline'     => 'Merancang dan membangun website yang nyaman digunakan.',
        'hero_description'  => 'Siswa SMK Negeri 1 Bangsri jurusan PPLG yang berfokus pada pengembangan website dan perancangan antarmuka UI/UX dengan Figma.',
        'bio'               => 'Siswa SMK Negeri 1 Bangsri jurusan Pengembangan Perangkat Lunak dan Gim (PPLG) yang memiliki minat dalam pengembangan website dan desain UI/UX. Memahami dasar HTML, CSS, PHP, dan MySQL serta memiliki pengalaman merancang antarmuka website menggunakan Figma. Disiplin, bertanggung jawab, dan mampu bekerja sama dalam tim.',
        'education'         => 'SMK Negeri 1 Bangsri — Pengembangan Perangkat Lunak dan Gim (PPLG)',
        'education_year'    => '2024 – Sekarang',
        'interests'         => 'Pengembangan Website, Desain UI/UX',
        'experience'        => null,
        'email'             => 'kepinyud67@gmail.com',
        'phone'             => '+62 838 3152 0933',
        'whatsapp_url'      => 'https://wa.me/6283831520933',
        'show_phone'        => true, // Default false: nomor telepon/WA hanya tampil jika bernilai true
        'github_url'        => 'https://github.com/kepinyuuu',
        'linkedin_url'      => null, // CV hanya menulis nama tanpa URL -> sembunyikan
        'instagram_url'     => null, // Tidak ada di CV -> sembunyikan
        'other_social_name' => null,
        'other_social_url'  => null,
        'photo'             => 'images/kevin.jpg', // File asli disediakan pemilik, fallback ke placeholder netral
        'about_extra'       => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Keahlian (Skills)
    | Sesuai CV: label level hanya jika ada ("Dasar" tetap "Dasar", tanpa istilah berlebihan)
    |--------------------------------------------------------------------------
    */
    'skills' => [
        // Web Development
        ['name' => 'HTML & CSS',             'category' => 'general', 'level_label' => null,     'sort_order' => 1],
        ['name' => 'JavaScript (Dasar)',    'category' => 'general', 'level_label' => 'Dasar',  'sort_order' => 2],
        ['name' => 'PHP (Dasar)',           'category' => 'general', 'level_label' => 'Dasar',  'sort_order' => 3],
        ['name' => 'Laravel (Dasar)',       'category' => 'general', 'level_label' => 'Dasar',  'sort_order' => 4],
        ['name' => 'MySQL',                 'category' => 'general', 'level_label' => null,     'sort_order' => 5],

        // Desain (Hanya Figma sesuai aturan ketat CV)
        ['name' => 'UI/UX Design (Figma)',  'category' => 'design',  'level_label' => null,     'sort_order' => 1],

        // Lainnya
        ['name' => 'Microsoft Excel (Dasar)', 'category' => 'other', 'level_label' => 'Dasar',  'sort_order' => 1],

        // Soft Skills
        ['name' => 'Komunikasi yang Baik',          'category' => 'soft',  'level_label' => null, 'sort_order' => 1],
        ['name' => 'Mampu Bekerja dalam Tim',       'category' => 'soft',  'level_label' => null, 'sort_order' => 2],
        ['name' => 'Teliti dan Bertanggung Jawab',  'category' => 'soft',  'level_label' => null, 'sort_order' => 3],
    ],

    /*
    |--------------------------------------------------------------------------
    | Bahasa
    |--------------------------------------------------------------------------
    */
    'languages' => [
        'Bahasa Indonesia',
        'English (Basic)',
    ],

    /*
    |--------------------------------------------------------------------------
    | Proyek (Projects) — Portofolio Proyek & Desain
    |--------------------------------------------------------------------------
    | Struktur data per proyek:
    | - title: Judul proyek
    | - role: Peran/tanggung jawab (misal UI/UX Designer)
    | - summary: Ringkasan singkat proyek
    | - tags: Array tag teknologi/kompetensi (hanya yang ada di data)
    | - cover: Path gambar sampul relatif dari public/ (opsional, null untuk fallback bertema)
    | - gallery: Array gambar dokumentasi (src, alt, caption)
    | - points: Poin lengkap aktivitas/capaian detail
    | - demo_url: URL demo publik (opsional, null untuk disembunyikan)
    | - github_url: URL repository GitHub (opsional, null untuk disembunyikan)
    |--------------------------------------------------------------------------
    */
    'projects' => [
        [
            'title'      => 'Website UMKM Omah Vektor',
            'role'       => 'UI/UX Designer',
            'summary'    => 'Menganalisis kebutuhan pengguna, merancang wireframe, mockup, dan prototype antarmuka website UMKM yang modern, responsif, dan mudah digunakan menggunakan Figma.',
            'tags'       => ['UI/UX', 'Figma', 'Wireframe', 'Mockup', 'Prototype'],
            'cover'      => 'images/experience/omah-vektor/omahvector.jpg',
            'gallery'    => [
                [
                    'src'     => 'images/experience/omah-vektor/omahvector.jpg',
                    'alt'     => 'Desain website UMKM Omah Vektor',
                    'caption' => 'Desain website UMKM Omah Vektor',
                ],
            ],
            'points'     => [
                'Menganalisis kebutuhan pengguna sebagai dasar perancangan antarmuka website.',
                'Merancang wireframe, mockup, dan prototype menggunakan Figma.',
                'Mendesain tampilan halaman website yang modern, responsif, dan mudah digunakan.',
                'Menyusun tata letak serta elemen UI untuk mendukung kenyamanan pengguna.',
                'Mengevaluasi dan menyempurnakan desain agar sesuai dengan kebutuhan website UMKM.',
            ],
            'demo_url'   => null,
            'github_url' => null,
            'is_featured' => true,
            'sort_order'  => 1,
        ],
        [
            'title'      => 'Perancangan Antarmuka Website',
            'role'       => 'UI/UX Designer',
            'summary'    => 'Perancangan antarmuka website yang nyaman digunakan melalui proses analisis kebutuhan pengguna, wireframe, mockup, prototype, dan evaluasi berkala.',
            'tags'       => ['UI/UX', 'Figma', 'Wireframe', 'Mockup', 'Prototype'],
            'cover'      => null,
            'gallery'    => [],
            'points'     => [
                'Menganalisis kebutuhan pengguna sebagai dasar perancangan antarmuka website.',
                'Membuat wireframe, mockup, dan prototype menggunakan Figma.',
                'Menyusun tata letak, pemilihan warna, dan elemen visual untuk meningkatkan kenyamanan pengguna.',
                'Mengevaluasi dan memperbaiki desain berdasarkan kebutuhan proyek.',
            ],
            'demo_url'   => null,
            'github_url' => null,
            'is_featured' => true,
            'sort_order'  => 2,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Karya Desain Visual / Experiments (Kosong sesuai data CV -> Sembunyikan)
    |--------------------------------------------------------------------------
    */
    'design_works' => [],

];
