<x-layouts.app :title="($profile->name ?? 'Kevin Yudha Pratama') . ' — ' . ($profile->title ?? 'Web Development & Designer')" :meta-description="$profile->hero_description ?? 'Portfolio Kevin Yudha Pratama — Web Development & Designer'">

    @php
        $shortName = config('portfolio.profile.short_name', 'Kevin Yudha P.');
        $location = config('portfolio.profile.location', 'Bangsri, Jepara, Jawa Tengah');
        $showPhone = (bool) config('portfolio.profile.show_phone', false);
        $phone = config('portfolio.profile.phone');
        $whatsappUrl = config('portfolio.profile.whatsapp_url');
        $hasDesignWorks = isset($designWorks) && $designWorks->isNotEmpty();
    @endphp

    {{-- ═══ SVG FILTER UNTUK TINGKAT 2 (PROGRESSIVE ENHANCEMENT) ═══════════════ --}}
    <svg class="sr-only" aria-hidden="true" style="position: absolute; width: 0; height: 0; pointer-events: none;">
        <defs>
            <filter id="liquid-glass" x="-10%" y="-10%" width="120%" height="120%" color-interpolation-filters="sRGB">
                <feTurbulence type="fractalNoise" baseFrequency="0.02" numOctaves="2" result="noise" />
                <feDisplacementMap in="SourceGraphic" in2="noise" scale="4" xChannelSelector="R" yChannelSelector="G" />
            </filter>
        </defs>
    </svg>

    {{-- ═══ ENLARGED FLOATING LIQUID GLASS NAVBAR ════════════════════════════════ --}}
    <header x-data="{ mobileOpen: false }" class="fixed top-3 sm:top-5 left-0 right-0 z-50 flex flex-col items-center pointer-events-none px-3 sm:px-4">
        {{-- Floating Pill Bar (Tinggi 64-72px di desktop, 56px di mobile) --}}
        <div id="floating-navbar" class="liquid-glass-pill pointer-events-auto flex items-center justify-between gap-2 sm:gap-4 px-3 sm:px-6 h-14 sm:h-[68px] md:h-[70px] w-fit max-w-[calc(100vw-1.5rem)] shadow-2xl transition-all duration-300">
            
            {{-- Logo / Nama Singkat (Kevin Yudha P.) --}}
            <a href="#home" class="flex items-center gap-2 px-2.5 py-1.5 min-h-[44px] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--foreground)] rounded-full shrink-0 group" aria-label="Beranda Kevin Yudha P.">
                <span class="font-bold text-sm sm:text-[15px] md:text-base tracking-tight text-[var(--glass-text-hover)] transition-colors">
                    {{ $shortName }}
                </span>
            </a>

            {{-- Divider --}}
            <div class="h-6 w-px bg-[var(--glass-border)] mx-0.5 shrink-0 hidden md:block" aria-hidden="true"></div>

            {{-- Desktop Navigation Links with Sliding Glass Bubble (Teks 15-16px, Touch Target min 44px) --}}
            <nav class="hidden md:flex items-center relative nav-links-track" aria-label="Navigasi Utama">
                {{-- Gelembung Kaca yang bergeser halus mengikuti item aktif --}}
                <div id="nav-bubble" class="nav-bubble" aria-hidden="true"></div>

                <a href="#about" class="glass-nav-link active" data-section="about" aria-current="true">Tentang</a>
                <a href="#skills" class="glass-nav-link" data-section="skills">Keahlian</a>
                <a href="#proyek" class="glass-nav-link" data-section="proyek">Proyek</a>
                @if($hasDesignWorks)
                <a href="#design" class="glass-nav-link" data-section="design">Desain</a>
                @endif
                <a href="#contact" class="glass-nav-link" data-section="contact">Kontak</a>
            </nav>

            {{-- Divider --}}
            <div class="h-6 w-px bg-[var(--glass-border)] mx-0.5 shrink-0" aria-hidden="true"></div>

            {{-- Right Actions: Theme Toggle & Email Action Button --}}
            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                {{-- Theme Toggle Glass Button (Ikon 20px, Target 44px) --}}
                <button
                    id="theme-toggle"
                    type="button"
                    class="glass-btn p-2 sm:p-2.5 min-h-[44px] min-w-[44px]"
                    aria-label="Ganti mode terang atau gelap"
                    title="Ganti tema">
                    <!-- Sun icon (mode gelap aktif) -->
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/></svg>
                    <!-- Moon icon (mode terang aktif) -->
                    <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"/></svg>
                </button>

                {{-- Action Button: "Email" (Aksi navbar beda label dari hero untuk hindari duplikasi) --}}
                <a href="mailto:{{ $profile->email }}" class="glass-btn text-xs sm:text-sm font-semibold px-3.5 sm:px-5 min-h-[44px]" aria-label="Kirim Email ke {{ $profile->name ?? 'Kevin' }}">
                    <svg class="w-4 h-4 sm:w-[18px] sm:h-[18px] mr-1.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                    <span>Email</span>
                </a>

                {{-- Mobile Hamburger Glass Button (Hanya muncul di bawah breakpoint tablet) --}}
                <button
                    type="button"
                    @click="mobileOpen = !mobileOpen"
                    class="glass-btn p-2 min-h-[44px] min-w-[44px] md:hidden"
                    aria-label="Buka navigasi mobile"
                    :aria-expanded="mobileOpen.toString()">
                    <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Glass Dropdown Panel (Hanya muncul di mobile jika dibuka) --}}
        <div
            x-show="mobileOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
            class="pointer-events-auto mt-2 w-full max-w-xs liquid-glass-pill p-3 shadow-2xl md:hidden">
            <nav class="flex flex-col space-y-1 text-center" aria-label="Navigasi Mobile">
                <a href="#about" @click="mobileOpen = false" class="glass-nav-link justify-center py-2.5 min-h-[44px]">Tentang</a>
                <a href="#skills" @click="mobileOpen = false" class="glass-nav-link justify-center py-2.5 min-h-[44px]">Keahlian</a>
                <a href="#proyek" @click="mobileOpen = false" class="glass-nav-link justify-center py-2.5 min-h-[44px]">Proyek</a>
                @if($hasDesignWorks)
                <a href="#design" @click="mobileOpen = false" class="glass-nav-link justify-center py-2.5 min-h-[44px]">Desain</a>
                @endif
                <a href="#contact" @click="mobileOpen = false" class="glass-nav-link justify-center py-2.5 min-h-[44px]">Kontak</a>
            </nav>
        </div>
    </header>

    {{-- ═══ HERO SECTION (Dengan Grid Halus, Kartu Profil 3D Tilt, dan Kedalaman Efek) ═══ --}}
    <section id="home" class="relative overflow-hidden pt-28 sm:pt-36 md:pt-40 pb-20 sm:pb-28 border-b border-[var(--border)]">
        {{-- Garis Grid Sangat Tipis dengan Mask Radial Memudar ke Tepi --}}
        <div class="absolute inset-0 hero-grid-pattern pointer-events-none" aria-hidden="true"></div>

        <div class="editorial-container relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

                {{-- Left Column: Editorial Text & CTAs --}}
                <div class="lg:col-span-7 flex flex-col items-start text-left scroll-reveal">
                    {{-- Eyebrow / Peran dengan Border Halus & Titik Berdenyut Pelan --}}
                    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full border border-[var(--surface-border)] bg-[var(--surface-tint)] backdrop-blur-md shadow-sm mb-6">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 pulse-slow"></span>
                        <span class="text-xs sm:text-[13px] font-semibold tracking-wider uppercase text-[var(--foreground)]">
                            {{ $profile->title ?? 'Web Development & Designer' }}
                        </span>
                    </div>

                    {{-- Main Hero Heading (Teks Lebih Besar & Rapat dengan Gradien Lembut) --}}
                    <h1 class="hero-title hero-title-gradient mb-6">
                        {{ $profile->name ?? 'Kevin Yudha Pratama' }}
                    </h1>

                    {{-- Headline & Deskripsi Hero --}}
                    <p class="text-xl sm:text-2xl font-bold text-[var(--foreground)] tracking-tight mb-3">
                        {{ $profile->hero_headline ?? 'Merancang dan membangun website yang nyaman digunakan.' }}
                    </p>
                    <p class="body-lead max-w-xl text-[var(--muted)] mb-8">
                        {{ $profile->hero_description ?? 'Siswa SMK Negeri 1 Bangsri jurusan PPLG yang berfokus pada pengembangan website dan perancangan antarmuka UI/UX dengan Figma.' }}
                    </p>

                    {{-- Dual CTAs: Tombol Utama Kaca Terang dengan Sheen Melintas + Tombol Sekunder Outline Kaca --}}
                    <div class="flex flex-wrap items-center gap-4 w-full sm:w-auto">
                        <a href="#proyek" class="btn-glass-primary group w-full sm:w-auto text-center">
                            <span>Lihat Proyek</span>
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                            </svg>
                        </a>
                        <a href="#contact" class="btn-glass-outline w-full sm:w-auto text-center">
                            <span>Hubungi Saya</span>
                        </a>
                    </div>

                    {{-- Info Lokasi di Bawah Tombol --}}
                    @if(filled($location))
                    <div class="mt-10 pt-6 border-t border-[var(--border)] w-full flex items-center gap-2.5 text-xs sm:text-sm text-[var(--muted)]">
                        <svg class="w-4 h-4 text-[var(--foreground)] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        <span>{{ $location }}</span>
                    </div>
                    @endif
                </div>

                {{-- Right Column: Profile Card dengan Kedalaman Kaca, Spotlight, 3D Tilt & Floating Chip --}}
                <div class="lg:col-span-5 flex justify-center lg:justify-end scroll-reveal" style="transition-delay: 80ms">
                    <div class="tilt-card-container w-full max-w-[340px] sm:max-w-[380px]">
                        @php
                            $photoPath = $profile->photo ?? 'images/kevin.jpg';
                            $hasPhotoFile = file_exists(public_path($photoPath));
                        @endphp

                        <div class="tilt-card depth-card p-4 sm:p-5 shadow-2xl relative group">
                            {{-- Bingkai Foto Membulat dengan Cincin Halus & Kilau --}}
                            <div class="aspect-[4/5] rounded-2xl overflow-hidden border border-white/15 bg-[var(--secondary)]/60 relative shadow-inner">
                                @if($hasPhotoFile)
                                    <img
                                        src="{{ asset($photoPath) }}"
                                        alt="Foto {{ $profile->name ?? 'Kevin Yudha Pratama' }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        style="object-position: center 30%">
                                @else
                                    {{-- Neutral Monogram Frame KYP --}}
                                    <div class="w-full h-full flex flex-col items-center justify-center p-8 bg-[var(--card)]/80 text-center">
                                        <div class="w-24 h-24 rounded-full bg-[var(--secondary)] flex items-center justify-center text-[var(--foreground)] font-bold text-3xl mb-4 border border-white/20 shadow-md">
                                            KYP
                                        </div>
                                        <p class="font-bold text-base text-[var(--foreground)]">{{ $profile->name ?? 'Kevin Yudha Pratama' }}</p>
                                        <p class="text-xs text-[var(--muted)] mt-1">{{ $profile->title ?? 'Web Development & Designer' }}</p>
                                    </div>
                                @endif

                                {{-- Soft Sheen Overlay (gradient gelap di bawah untuk keterbacaan chip) --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-white/10 pointer-events-none"></div>

                                {{-- Chip "Bangsri, Jepara" di dalam area foto (bottom-left, inset 14px) --}}
                                @if(filled($location))
                                <div class="absolute bottom-3.5 left-3.5 z-20 animate-float">
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-white/20 bg-[var(--chip-bg)] text-[var(--chip-text)] text-[11px] font-medium backdrop-blur-md shadow-lg leading-none">
                                        <svg class="w-3 h-3 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        <span class="whitespace-nowrap">{{ $location }}</span>
                                    </div>
                                </div>
                                @endif

                                {{-- Badge "SMK N 1 Bangsri" di sudut kanan atas foto --}}
                                <div class="absolute top-3.5 right-3.5 z-20">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-[var(--chip-bg)] text-[var(--chip-text)] backdrop-blur-md border border-white/15 shadow-sm whitespace-nowrap">
                                        SMK N 1 Bangsri
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══ ABOUT SECTION (Profil & Pendidikan dari CV) ═════════════════════════ --}}
    <section id="about" class="editorial-section border-b border-[var(--border)] bg-[var(--background)]">
        <div class="editorial-container">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">

                {{-- Left: Bio Singkat & Pendidikan --}}
                <div class="lg:col-span-7 space-y-6 scroll-reveal">
                    <div>
                        <p class="text-xs font-semibold tracking-wider uppercase text-[var(--muted)] mb-2">Profil</p>
                        <h2 class="section-title mb-6">
                            Tentang Saya
                        </h2>
                    </div>

                    <p class="body-lead text-[var(--foreground)]/90 font-normal leading-relaxed">
                        {{ $profile->bio }}
                    </p>

                    {{-- Pendidikan (Dari CV) --}}
                    @if($profile->education)
                    <div class="pt-6 border-t border-[var(--border)] space-y-4">
                        <div class="depth-card p-5 sm:p-6 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-[var(--icon-bg)] border border-[var(--icon-border)] flex items-center justify-center shrink-0 text-[var(--foreground)] shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider font-semibold text-[var(--muted)]">Pendidikan</p>
                                <p class="font-bold text-base text-[var(--foreground)] mt-0.5">{{ $profile->education }}</p>
                                @if($profile->education_year)
                                <p class="text-xs text-[var(--muted)] mt-0.5">{{ $profile->education_year }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Right: Minat & Bahasa --}}
                <div class="lg:col-span-5 space-y-6">
                    {{-- Minat --}}
                    @if($profile->interests)
                    <div class="depth-card p-6 md:p-8 scroll-reveal" style="transition-delay: 80ms">
                        <p class="text-xs font-semibold uppercase tracking-wider text-[var(--muted)] mb-3">Minat</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(array_map('trim', explode(',', $profile->interests)) as $interest)
                            <span class="tag-clean">{{ $interest }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Bahasa --}}
                    @if(!empty($languages))
                    <div class="depth-card p-6 md:p-8 scroll-reveal" style="transition-delay: 160ms">
                        <p class="text-xs font-semibold uppercase tracking-wider text-[var(--muted)] mb-3">Bahasa</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($languages as $lang)
                            <span class="skill-badge text-xs">{{ $lang }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    {{-- ═══ SKILLS SECTION (Jujur sesuai CV) ═════════════════════════════════════ --}}
    <section id="skills" class="editorial-section border-b border-[var(--border)] bg-[var(--background)]">
        <div class="editorial-container">
            <div class="mb-12 scroll-reveal">
                <p class="text-xs font-semibold tracking-wider uppercase text-[var(--muted)] mb-2">Kompetensi</p>
                <h2 class="section-title">Keahlian</h2>
            </div>

            @php
                $skillCategories = [
                    'general' => 'Web Development',
                    'design'  => 'Desain',
                    'other'   => 'Lainnya',
                    'soft'    => 'Soft Skills',
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($skillCategories as $catKey => $catLabel)
                    @if(isset($skills[$catKey]) && $skills[$catKey]->count())
                    <div class="depth-card p-7 md:p-8 scroll-reveal" style="transition-delay: {{ $loop->index * 80 }}ms">
                        <h3 class="text-xs font-semibold uppercase tracking-wider text-[var(--muted)] flex items-center gap-2 mb-5">
                            <span class="w-1.5 h-1.5 rounded-full bg-[var(--foreground)]"></span>
                            {{ $catLabel }}
                        </h3>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach($skills[$catKey] as $skill)
                            <div class="skill-badge">
                                <span>{{ $skill->name }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══ SELECTED PROJECTS SECTION (Kartu Gambar Sampul + Modal Dialog Detail & Galeri) ═══ --}}
    @php
        $projectsData = collect($projects)->map(function ($project) {
            $title = is_array($project) ? ($project['title'] ?? '') : $project->title;
            $slug = \Illuminate\Support\Str::slug($title);
            $role = is_array($project) ? ($project['role'] ?? 'UI/UX Designer') : ($project->role ?? 'UI/UX Designer');
            $summary = is_array($project) ? ($project['summary'] ?? $project['description'] ?? '') : ($project->summary ?? $project->description ?? '');
            
            $tagsRaw = is_array($project) ? ($project['tags'] ?? []) : ($project->tags ?? $project->technologies_array ?? []);
            if (!is_array($tagsRaw)) {
                $tags = array_values(array_filter(array_map('trim', explode(',', (string) $tagsRaw))));
            } else {
                $tags = array_values(array_filter($tagsRaw));
            }

            $cover = is_array($project) ? ($project['cover'] ?? $project['image'] ?? null) : ($project->cover ?? $project->image ?? null);
            $hasCover = filled($cover) && file_exists(public_path($cover));

            $galleryRaw = is_array($project) ? ($project['gallery'] ?? []) : ($project->gallery ?? []);
            if (isset($galleryRaw['src'])) {
                $galleryRaw = [$galleryRaw];
            }
            $gallery = collect($galleryRaw)->map(function ($g) {
                $src = $g['src'] ?? '';
                $hasSrc = filled($src) && file_exists(public_path($src));
                return [
                    'src'     => $hasSrc ? asset($src) : null,
                    'alt'     => $g['alt'] ?? 'Gambar dokumentasi proyek',
                    'caption' => $g['caption'] ?? null,
                ];
            })->filter(fn ($g) => filled($g['src']))->values()->all();

            $points = is_array($project) ? ($project['points'] ?? $project['items'] ?? []) : ($project->points ?? []);
            $demoUrl = is_array($project) ? ($project['demo_url'] ?? null) : ($project->demo_url ?? null);
            $githubUrl = is_array($project) ? ($project['github_url'] ?? null) : ($project->github_url ?? null);

            return [
                'slug'       => $slug,
                'title'      => $title,
                'role'       => $role,
                'summary'    => $summary,
                'tags'       => $tags,
                'cover'      => $cover,
                'has_cover'  => $hasCover,
                'cover_url'  => $hasCover ? asset($cover) : null,
                'points'     => $points,
                'gallery'    => $gallery,
                'demo_url'   => filled($demoUrl) ? $demoUrl : null,
                'github_url' => filled($githubUrl) ? $githubUrl : null,
            ];
        })->values()->all();
    @endphp

    <section id="proyek"
        x-data="projectModal({{ Js::from($projectsData) }})"
        @keydown.window="handleKeyDown($event)"
        class="editorial-section border-b border-[var(--border)] bg-[var(--background)]">
        <div class="editorial-container">
            <div class="mb-12 scroll-reveal">
                <p class="text-xs font-semibold tracking-wider uppercase text-[var(--muted)] mb-2">Portofolio</p>
                <h2 class="section-title">Proyek Pilihan</h2>
            </div>

            @if(empty($projectsData))
            <div class="text-center py-20 depth-card scroll-reveal">
                <p class="text-base text-[var(--muted)]">Belum ada proyek yang ditampilkan.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
                @foreach($projectsData as $project)
                <div class="h-full scroll-reveal" style="transition-delay: {{ $loop->index * 90 }}ms">
                    <button
                        type="button"
                        @click="openProject('{{ $project['slug'] }}', $el)"
                        id="project-card-{{ $project['slug'] }}"
                        class="depth-card p-6 sm:p-7 flex flex-col justify-between text-left w-full h-full group cursor-pointer focus-visible:outline-2 focus-visible:outline-[var(--foreground)]"
                        aria-haspopup="dialog"
                        aria-expanded="false">
                        
                        <div class="w-full">
                            {{-- Gambar sampul (aspect 16/10) atau Fallback bertema bersih --}}
                            <div class="aspect-[16/10] w-full rounded-xl overflow-hidden mb-5 relative bg-[var(--secondary)] border border-[var(--border)]">
                                @if($project['has_cover'])
                                    <img
                                        src="{{ asset($project['cover']) }}"
                                        alt="Sampul {{ $project['title'] }}"
                                        loading="lazy"
                                        decoding="async"
                                        class="w-full h-full object-cover transition-transform duration-300 ease-out group-hover:scale-[1.03]">
                                @else
                                    {{-- Themed plain block: permukaan kaca dengan ikon sederhana, bukan gambar palsu --}}
                                    <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center bg-gradient-to-br from-[var(--surface-tint)] to-[var(--secondary)] relative">
                                        <div class="w-12 h-12 rounded-xl bg-[var(--surface-tint)] border border-[var(--surface-border)] flex items-center justify-center text-[var(--foreground)] mb-2.5 shadow-xs group-hover:scale-105 transition-transform duration-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/>
                                            </svg>
                                        </div>
                                        <span class="text-xs font-semibold tracking-wider uppercase text-[var(--muted)]">{{ $project['role'] }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Role Label --}}
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[var(--foreground)]"></span>
                                <span class="text-xs font-semibold uppercase tracking-wider text-[var(--muted)]">{{ $project['role'] }}</span>
                            </div>

                            {{-- Title --}}
                            <h3 class="text-lg sm:text-xl font-bold text-[var(--foreground)] group-hover:opacity-80 transition-opacity mb-2">
                                {{ $project['title'] }}
                            </h3>

                            {{-- Summary --}}
                            @if(filled($project['summary']))
                            <p class="text-sm text-[var(--muted)] leading-relaxed mb-4 line-clamp-3">
                                {{ $project['summary'] }}
                            </p>
                            @endif

                            {{-- Tags --}}
                            @if(!empty($project['tags']))
                            <div class="flex flex-wrap gap-1.5 mb-2">
                                @foreach($project['tags'] as $tag)
                                <span class="tag-clean">{{ $tag }}</span>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        {{-- Petunjuk "Lihat detail" dengan panah kecil --}}
                        <div class="pt-4 border-t border-[var(--border)] mt-4 w-full flex items-center justify-between text-xs sm:text-sm font-semibold text-[var(--foreground)]">
                            <span>Lihat detail</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </div>

                        {{-- No-JS Fallback: Poin tetap dapat dibaca jika JavaScript gagal dimuat --}}
                        <noscript>
                            <div class="mt-4 pt-4 border-t border-[var(--border)] text-left w-full">
                                <p class="text-xs font-semibold uppercase tracking-wider text-[var(--muted)] mb-2">Detail Proyek:</p>
                                <ul class="space-y-2 text-sm text-[var(--muted)]">
                                    @foreach($project['points'] as $point)
                                    <li class="flex items-start gap-2">
                                        <span class="text-[var(--foreground)] mt-1 text-xs">•</span>
                                        <span class="leading-relaxed">{{ $point }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </noscript>
                    </button>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- ═══ MODAL DETAIL / DIALOG PROYEK ═══ --}}
        <div
            x-show="isOpen"
            x-cloak
            class="fixed inset-0 z-[70] flex items-center justify-center p-3 sm:p-6 overflow-y-auto"
            role="dialog"
            aria-modal="true"
            aria-labelledby="proj-dialog-title"
            tabindex="-1">

            {{-- Backdrop --}}
            <div
                x-show="isOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="close()"
                class="fixed inset-0 bg-black/65 dark:bg-black/80 backdrop-blur-md"
                aria-hidden="true"></div>

            {{-- Dialog Panel --}}
            <div
                x-show="isOpen"
                x-transition:enter="transition ease-out duration-250"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                x-ref="dialogContent"
                class="relative w-full max-w-2xl lg:max-w-3xl max-h-[90vh] flex flex-col bg-[var(--card)] border border-[var(--border)] rounded-2xl shadow-2xl overflow-hidden z-10"
                @click.outside="close()">

                {{-- TAMPILAN 1: DETAIL PROYEK --}}
                <div x-show="activeGalleryIndex === null" class="flex flex-col h-full overflow-hidden">
                    {{-- Header / Close Button Bar --}}
                    <div class="flex items-center justify-between px-6 py-4 border-b border-[var(--border)] bg-[var(--card)] shrink-0">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span class="text-xs font-semibold uppercase tracking-wider text-[var(--muted)]" x-text="activeProject?.role"></span>
                        </div>
                        <button
                            type="button"
                            x-ref="modalCloseBtn"
                            @click="close()"
                            class="glass-btn p-2 min-h-[44px] min-w-[44px] text-[var(--foreground)]"
                            aria-label="Tutup dialog">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Scrollable Content Body --}}
                    <div class="overflow-y-auto p-6 sm:p-8 space-y-6 flex-grow">
                        {{-- Cover Image or Themed Header --}}
                        <template x-if="activeProject?.has_cover">
                            <div class="aspect-[16/10] w-full rounded-xl overflow-hidden bg-[var(--secondary)] border border-[var(--border)]">
                                <img :src="activeProject?.cover_url" :alt="'Sampul ' + (activeProject?.title || '')" alt="Sampul Proyek" class="w-full h-full object-cover">
                            </div>
                        </template>

                        <div>
                            <h3 id="proj-dialog-title" class="text-xl sm:text-2xl md:text-3xl font-bold text-[var(--foreground)] leading-tight" x-text="activeProject?.title"></h3>
                            <template x-if="activeProject?.summary">
                                <p class="text-sm sm:text-base text-[var(--muted)] leading-relaxed mt-2" x-text="activeProject?.summary"></p>
                            </template>
                        </div>

                        {{-- Tags / Technologies --}}
                        <template x-if="activeProject?.tags && activeProject.tags.length > 0">
                            <div class="flex flex-wrap gap-1.5">
                                <template x-for="(tag, tIdx) in activeProject.tags" :key="tIdx">
                                    <span class="tag-clean" x-text="tag"></span>
                                </template>
                            </div>
                        </template>

                        {{-- Action Buttons: Demo & GitHub bila URL ada --}}
                        <div x-show="activeProject?.demo_url || activeProject?.github_url" class="flex flex-wrap items-center gap-3 pt-2">
                            <template x-if="activeProject?.demo_url">
                                <a
                                    :href="activeProject.demo_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn-glass-primary text-xs sm:text-sm font-semibold">
                                    <span>Kunjungi Demo</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                    </svg>
                                </a>
                            </template>
                            <template x-if="activeProject?.github_url">
                                <a
                                    :href="activeProject.github_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn-glass-outline text-xs sm:text-sm font-semibold">
                                    <span>Repository GitHub</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/>
                                    </svg>
                                </a>
                            </template>
                        </div>

                        {{-- Daftar Poin Lengkap --}}
                        <template x-if="activeProject?.points && activeProject.points.length > 0">
                            <div class="space-y-3 pt-4 border-t border-[var(--border)]">
                                <p class="text-xs font-semibold uppercase tracking-wider text-[var(--muted)]">Poin Capaian &amp; Aktivitas</p>
                                <ul class="space-y-3 text-sm sm:text-base text-[var(--foreground)]/90">
                                    <template x-for="(point, idx) in activeProject.points" :key="idx">
                                        <li class="flex items-start gap-3">
                                            <span class="text-[var(--foreground)] mt-1.5 text-xs select-none">•</span>
                                            <span class="leading-relaxed" x-text="point"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>

                        {{-- Galeri Thumbnail (Bila ada data galeri) --}}
                        <template x-if="activeProject?.gallery && activeProject.gallery.length > 0">
                            <div class="pt-6 border-t border-[var(--border)]">
                                <p class="text-xs font-semibold uppercase tracking-wider text-[var(--muted)] mb-3">Dokumentasi &amp; Galeri</p>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    <template x-for="(img, gIdx) in activeProject.gallery" :key="gIdx">
                                        <button
                                            type="button"
                                            @click="openGallery(gIdx)"
                                            class="aspect-[4/3] rounded-lg overflow-hidden border border-[var(--border)] group relative cursor-pointer focus-visible:outline-2 focus-visible:outline-[var(--foreground)] min-h-[44px]">
                                            <img :src="img.src" :alt="img.alt" alt="Dokumentasi Galeri" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                            <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6"/>
                                                </svg>
                                            </div>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- TAMPILAN 2: VIEWER GAMBAR BESAR GALERI --}}
                <div x-show="activeGalleryIndex !== null" class="flex flex-col h-full overflow-hidden p-4 sm:p-6 space-y-4">
                    {{-- Navigasi Atas Galeri --}}
                    <div class="flex items-center justify-between gap-3">
                        <button
                            type="button"
                            x-ref="galleryBackBtn"
                            @click="backToDetail()"
                            class="glass-btn px-3 py-1.5 text-xs font-semibold min-h-[44px] flex items-center gap-1.5"
                            aria-label="Kembali ke detail proyek">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                            </svg>
                            <span>Kembali ke detail</span>
                        </button>

                        {{-- Penghitung "2 / 5" --}}
                        <span
                            class="text-xs sm:text-sm font-semibold text-[var(--foreground)] px-3 py-1.5 rounded-full bg-[var(--surface-tint)] border border-[var(--surface-border)]"
                            x-text="activeProject?.gallery ? ((activeGalleryIndex + 1) + ' / ' + activeProject.gallery.length) : ''">
                        </span>

                        <button
                            type="button"
                            @click="close()"
                            class="glass-btn p-2 min-h-[44px] min-w-[44px]"
                            aria-label="Tutup dialog">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Kontainer Gambar Besar dengan Touch Swipe --}}
                    <div
                        @touchstart="handleTouchStart($event)"
                        @touchend="handleTouchEnd($event)"
                        class="relative flex-grow flex flex-col items-center justify-center min-h-[260px] sm:min-h-[360px] bg-black/40 rounded-xl overflow-hidden p-2 select-none">
                        
                        <template x-if="activeProject?.gallery && activeProject.gallery[activeGalleryIndex]">
                            <img
                                :src="activeProject.gallery[activeGalleryIndex].src"
                                :alt="activeProject.gallery[activeGalleryIndex].alt"
                                alt="Gambar Galeri Proyek"
                                class="max-h-[50vh] sm:max-h-[55vh] w-auto max-w-full object-contain rounded-lg shadow-lg">
                        </template>

                        {{-- Tombol Sebelumnya --}}
                        <button
                            type="button"
                            @click="prevGallery()"
                            class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 glass-btn p-2 sm:p-2.5 min-h-[44px] min-w-[44px] shadow-lg"
                            aria-label="Gambar sebelumnya">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                            </svg>
                        </button>

                        {{-- Tombol Berikutnya --}}
                        <button
                            type="button"
                            @click="nextGallery()"
                            class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 glass-btn p-2 sm:p-2.5 min-h-[44px] min-w-[44px] shadow-lg"
                            aria-label="Gambar berikutnya">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Caption Gambar --}}
                    <template x-if="activeProject?.gallery && activeProject.gallery[activeGalleryIndex]?.caption">
                        <p class="text-xs sm:text-sm text-center text-[var(--muted)] leading-relaxed px-4" x-text="activeProject.gallery[activeGalleryIndex].caption"></p>
                    </template>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══ DESIGN SHOWCASE (Sembunyikan jika tidak ada data) ═══════════════════ --}}
    @if($hasDesignWorks)
    <section id="design" class="editorial-section border-b border-[var(--border)] bg-[var(--background)]">
        <div class="editorial-container">
            <div class="mb-10 scroll-reveal">
                <p class="text-xs font-semibold tracking-wider uppercase text-[var(--muted)] mb-2">Eksplorasi</p>
                <h2 class="section-title">Karya Desain</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="design-grid">
                @foreach($designWorks as $work)
                <div class="design-item scroll-reveal">
                    <div class="depth-card p-4 overflow-hidden">
                        <p class="font-semibold text-sm text-[var(--foreground)]">{{ $work->title }}</p>
                        <p class="text-xs text-[var(--muted)] mt-1">{{ $work->category }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ CONTACT SECTION (Form & Informasi dengan Kartu Depth) ═══════════════ --}}
    <section id="contact" class="editorial-section border-b border-[var(--border)] bg-[var(--background)]">
        <div class="editorial-container">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">

                {{-- Left: Informasi Kontak --}}
                <div class="lg:col-span-5 space-y-6 scroll-reveal">
                    <div>
                        <p class="text-xs font-semibold tracking-wider uppercase text-[var(--muted)] mb-2">Kontak</p>
                        <h2 class="section-title mb-4">
                            Mari Berkolaborasi.
                        </h2>
                        <p class="body-lead text-[var(--muted)]">
                            Tertarik untuk berdiskusi seputar proyek website atau desain antarmuka? Silakan kirimkan pesan melalui formulir atau kontak di bawah ini.
                        </p>
                    </div>

                    {{-- Direct Contacts Card --}}
                    <div class="depth-card p-6 sm:p-7 space-y-5">
                        {{-- Email --}}
                        @if($profile->email)
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--muted)]">Email</p>
                            <a href="mailto:{{ $profile->email }}" class="font-medium text-base text-[var(--foreground)] hover:opacity-70 transition-opacity mt-0.5 inline-block">                                {{ $profile->email }}
                            </a>
                        </div>
                        @endif

                        {{-- WhatsApp (Hanya jika show_phone bernilai true) --}}
                        @if($showPhone && filled($whatsappUrl))
                        <div class="pt-4 border-t border-[var(--border)]">
                            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--muted)]">WhatsApp</p>
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="font-medium text-base text-[var(--foreground)] hover:opacity-70 transition-opacity mt-0.5 inline-block">
                                {{ $phone ?? 'WhatsApp' }}
                            </a>
                        </div>
                        @endif

                        {{-- GitHub (LinkedIn & Figma disembunyikan karena tidak ada URL) --}}
                        @if(filled($profile->github_url))
                        <div class="pt-4 border-t border-[var(--border)]">
                            <p class="text-xs font-semibold uppercase tracking-wider text-[var(--muted)] mb-2.5">Tautan Sosial</p>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer" class="skill-badge text-xs">
                                    GitHub
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Right: Contact Form --}}
                <div class="lg:col-span-7 depth-card p-8 md:p-10 shadow-2xl scroll-reveal" style="transition-delay: 80ms">
                    @if(session('contact_success'))
                    <div class="bg-[var(--secondary)] border border-[var(--border)] rounded-xl p-5 mb-6 text-center">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/15 text-emerald-400 flex items-center justify-center mx-auto mb-2.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                            </svg>
                        </div>
                        <p class="font-semibold text-sm text-[var(--foreground)]">Pesan terkirim dengan baik!</p>
                        <p class="text-xs text-[var(--muted)] mt-1">Terima kasih telah menghubungi. Saya akan membalas secepatnya.</p>
                    </div>
                    @endif

                    <form action="{{ route('contact') }}" method="POST" class="space-y-5" id="contact-form">
                        @csrf
                        {{-- Honeypot Spam Defense --}}
                        <div class="hidden" aria-hidden="true">
                            <input type="text" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-[var(--muted)] mb-1.5">
                                    Nama Lengkap <span class="text-[var(--foreground)]">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="editorial-input @error('name') border-red-500 @enderror"
                                    placeholder="Nama Anda"
                                    required>
                                @error('name')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-[var(--muted)] mb-1.5">
                                    Alamat Email <span class="text-[var(--foreground)]">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="editorial-input @error('email') border-red-500 @enderror"
                                    placeholder="nama@email.com"
                                    required>
                                @error('email')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-xs font-semibold uppercase tracking-wider text-[var(--muted)] mb-1.5">
                                Subjek Pesan <span class="text-[var(--foreground)]">*</span>
                            </label>
                            <input
                                type="text"
                                id="subject"
                                name="subject"
                                value="{{ old('subject') }}"
                                class="editorial-input @error('subject') border-red-500 @enderror"
                                placeholder="Subjek pesan atau topik proyek"
                                required>
                            @error('subject')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-xs font-semibold uppercase tracking-wider text-[var(--muted)] mb-1.5">
                                Pesan <span class="text-[var(--foreground)]">*</span>
                            </label>
                            <textarea
                                id="message"
                                name="message"
                                rows="5"
                                class="editorial-input resize-none @error('message') border-red-500 @enderror"
                                placeholder="Tuliskan pesan Anda..."
                                required>{{ old('message') }}</textarea>
                            @error('message')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end pt-2">
                            <button
                                type="submit"
                                class="btn-glass-primary w-full sm:w-auto"
                                id="contact-submit">
                                <span>Kirim Pesan</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══ MINIMALIST EDITORIAL FOOTER ══════════════════════════════════════════ --}}
    <footer class="py-10 bg-[var(--background)]">
        <div class="editorial-container flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-[var(--muted)]">
            <p>© {{ date('Y') }} {{ $profile->name ?? 'Kevin Yudha Pratama' }}. All rights reserved.</p>

            <nav class="flex items-center gap-6" aria-label="Navigasi Footer">
                <a href="#home" class="hover:text-[var(--foreground)] transition-colors">Beranda</a>
                <a href="#about" class="hover:text-[var(--foreground)] transition-colors">Tentang</a>
                <a href="#skills" class="hover:text-[var(--foreground)] transition-colors">Keahlian</a>
                <a href="#proyek" class="hover:text-[var(--foreground)] transition-colors">Proyek</a>
                <a href="#contact" class="hover:text-[var(--foreground)] transition-colors">Kontak</a>
            </nav>
        </div>
    </footer>

</x-layouts.app>
