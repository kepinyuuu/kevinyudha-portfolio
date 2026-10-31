<x-layouts.app :title="'Kevin Yudha Pratama — UI/UX Designer & Developer'" :meta-description="$profile->hero_description ?? 'Portfolio Kevin Yudha Pratama'">

    {{-- ═══ NAVBAR ═══════════════════════════════════════════════════════════ --}}
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" x-data="{ open: false, scrolled: false }" x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 40 })">
        <div :class="scrolled ? 'bg-cream/95 backdrop-blur-md shadow-sm border-b border-sand' : 'bg-transparent'" class="transition-all duration-300">
            <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="#home" class="font-serif text-xl font-semibold tracking-tight hover:text-brown transition-colors">
                    Kevin<span class="text-brown">.</span>
                </a>

                {{-- Desktop Nav --}}
                <ul class="hidden md:flex items-center gap-8 text-sm font-medium tracking-wide">
                    @foreach([['#about','About'],['#skills','Skills'],['#projects','Projects'],['#design','Design'],['#contact','Contact']] as [$href,$label])
                    <li>
                        <a href="{{ $href }}" class="text-charcoal/70 hover:text-charcoal transition-colors relative group">
                            {{ $label }}
                            <span class="absolute -bottom-1 left-0 w-0 h-px bg-brown group-hover:w-full transition-all duration-300"></span>
                        </a>
                    </li>
                    @endforeach
                </ul>

                {{-- Mobile Hamburger --}}
                <button @click="open = !open" class="md:hidden w-8 h-8 flex flex-col justify-center gap-1.5 group" id="mobile-menu-btn" aria-label="Toggle menu">
                    <span :class="open ? 'rotate-45 translate-y-2' : ''" class="block h-px w-full bg-charcoal transition-transform duration-300 origin-center"></span>
                    <span :class="open ? 'opacity-0' : ''" class="block h-px w-full bg-charcoal transition-opacity duration-300"></span>
                    <span :class="open ? '-rotate-45 -translate-y-2' : ''" class="block h-px w-full bg-charcoal transition-transform duration-300 origin-center"></span>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden bg-cream border-t border-sand">
                <ul class="max-w-6xl mx-auto px-6 py-4 flex flex-col gap-4">
                    @foreach([['#about','About'],['#skills','Skills'],['#projects','Projects'],['#design','Design'],['#contact','Contact']] as [$href,$label])
                    <li>
                        <a href="{{ $href }}" @click="open = false" class="text-charcoal/80 hover:text-brown font-medium transition-colors block py-1">{{ $label }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

    {{-- ═══ HERO ══════════════════════════════════════════════════════════════ --}}
    <section id="home" class="min-h-screen flex items-center pt-20">
        <div class="max-w-6xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-16 items-center">
            {{-- Text --}}
            <div class="order-2 md:order-1 animate-fade-up">
                <p class="text-sm font-medium tracking-[0.2em] text-brown uppercase mb-6">UI/UX Designer & Developer</p>
                <h1 class="font-serif text-5xl md:text-6xl lg:text-7xl font-bold leading-tight text-charcoal mb-6">
                    {!! nl2br(e($profile->hero_headline ?? "Designing\nExperiences,\nBuilding the Web.")) !!}
                </h1>
                <p class="text-charcoal/60 text-lg leading-relaxed max-w-md mb-10">
                    {{ $profile->hero_description ?? 'UI/UX Designer & Developer yang memadukan kreativitas visual dengan kemampuan teknis.' }}
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#projects" class="btn-primary" id="hero-view-projects">View Projects</a>
                    <a href="#contact" class="btn-outline" id="hero-contact">Contact Me</a>
                </div>

                {{-- Social Links --}}
                @if($profile->github_url || $profile->linkedin_url || $profile->instagram_url)
                <div class="flex items-center gap-5 mt-10">
                    <span class="text-xs text-charcoal/40 tracking-widest uppercase">Find me</span>
                    <div class="h-px w-8 bg-sand"></div>
                    <div class="flex gap-4">
                        @if($profile->github_url)
                        <a href="{{ $profile->github_url }}" target="_blank" rel="noopener" class="text-charcoal/50 hover:text-brown transition-colors" aria-label="GitHub">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                        </a>
                        @endif
                        @if($profile->linkedin_url)
                        <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener" class="text-charcoal/50 hover:text-brown transition-colors" aria-label="LinkedIn">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        @endif
                        @if($profile->instagram_url)
                        <a href="{{ $profile->instagram_url }}" target="_blank" rel="noopener" class="text-charcoal/50 hover:text-brown transition-colors" aria-label="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            {{-- Photo --}}
            <div class="order-1 md:order-2 flex justify-center md:justify-end animate-fade-up" style="animation-delay:0.2s">
                <div class="relative">
                    <div class="w-72 h-72 md:w-80 md:h-80 rounded-3xl overflow-hidden bg-sand border border-beige">
                        @if($profile->photo)
                            <img src="{{ Storage::disk(config('filesystems.default'))->url($profile->photo) }}" alt="Foto {{ $profile->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-sand">
                                <svg class="w-32 h-32 text-brown/30" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                            </div>
                        @endif
                    </div>
                    {{-- Decorative elements --}}
                    <div class="absolute -top-4 -right-4 w-24 h-24 rounded-2xl bg-beige border border-sand -z-10"></div>
                    <div class="absolute -bottom-4 -left-4 w-16 h-16 rounded-xl bg-brown/10 -z-10"></div>
                </div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-bounce-slow">
            <span class="text-xs text-charcoal/30 tracking-widest uppercase">Scroll</span>
            <div class="w-px h-12 bg-gradient-to-b from-brown/50 to-transparent"></div>
        </div>
    </section>

    {{-- ═══ ABOUT ══════════════════════════════════════════════════════════════ --}}
    <section id="about" class="py-24 md:py-32">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-16 items-start">
                <div class="scroll-reveal">
                    <p class="section-label">About Me</p>
                    <h2 class="font-serif text-4xl md:text-5xl font-bold text-charcoal mb-8 leading-tight">
                        Seorang kreator<br><em class="text-brown not-italic">digital</em> yang curious.
                    </h2>
                    <p class="text-charcoal/70 text-lg leading-relaxed mb-6">
                        {{ $profile->bio }}
                    </p>
                    @if($profile->about_extra)
                    <p class="text-charcoal/70 leading-relaxed">{{ $profile->about_extra }}</p>
                    @endif
                </div>

                <div class="space-y-8 scroll-reveal" style="animation-delay:0.15s">
                    {{-- Education --}}
                    <div class="card-cream">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-brown/10 flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-5 h-5 text-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-charcoal mb-1">Pendidikan</h3>
                                <p class="text-charcoal/70">{{ $profile->education }}</p>
                                @if($profile->education_year)
                                <p class="text-sm text-brown mt-1">{{ $profile->education_year }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Interests --}}
                    @if($profile->interests)
                    <div class="card-cream">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-brown/10 flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-5 h-5 text-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-charcoal mb-3">Minat</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(array_map('trim', explode(',', $profile->interests)) as $interest)
                                    <span class="tag">{{ $interest }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Experience --}}
                    @if($profile->experience)
                    <div class="card-cream">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-brown/10 flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-5 h-5 text-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-charcoal mb-2">Pengalaman</h3>
                                <p class="text-charcoal/70 whitespace-pre-line">{{ $profile->experience }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ SKILLS ═════════════════════════════════════════════════════════════ --}}
    <section id="skills" class="py-24 md:py-32 bg-charcoal text-cream">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16 scroll-reveal">
                <p class="section-label-light">What I Do</p>
                <h2 class="font-serif text-4xl md:text-5xl font-bold mb-4">Skills & Expertise</h2>
                <p class="text-cream/50 max-w-md mx-auto">Keahlian yang saya kembangkan untuk membangun dan mendesain produk digital.</p>
            </div>

            @foreach(['general' => 'Development', 'design' => 'Design', 'tools' => 'Tools'] as $cat => $label)
                @if(isset($skills[$cat]) && $skills[$cat]->count())
                <div class="mb-14 scroll-reveal">
                    <h3 class="text-xs font-semibold tracking-[0.2em] uppercase text-brown mb-8">{{ $label }}</h3>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($skills[$cat] as $skill)
                        <div class="skill-card group">
                            <div class="flex justify-between items-center mb-3">
                                <span class="font-medium text-cream/90">{{ $skill->name }}</span>
                                <span class="text-sm text-brown font-semibold">{{ $skill->level }}%</span>
                            </div>
                            <div class="h-1.5 bg-cream/10 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-brown to-beige rounded-full skill-bar transition-all duration-1000" data-width="{{ $skill->level }}" style="width: 0%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </section>

    {{-- ═══ PROJECTS ═══════════════════════════════════════════════════════════ --}}
    <section id="projects" class="py-24 md:py-32">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-16 scroll-reveal">
                <p class="section-label">My Work</p>
                <h2 class="font-serif text-4xl md:text-5xl font-bold text-charcoal leading-tight">Selected <em class="text-brown not-italic">Projects</em></h2>
            </div>

            @if($projects->isEmpty())
            <div class="text-center py-20 text-charcoal/40">
                <p class="text-lg">Belum ada proyek yang dipublikasikan.</p>
                <p class="text-sm mt-2">Tambahkan proyek melalui dashboard admin.</p>
            </div>
            @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $project)
                <article class="project-card scroll-reveal group">
                    {{-- Image --}}
                    <div class="aspect-video bg-sand rounded-2xl overflow-hidden mb-5">
                        @if($project->image_url)
                            <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-charcoal/20">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" stroke-width="1.5"/><path d="M3 9l4-4 4 4 4-4 4 4" stroke-width="1.5"/><circle cx="8.5" cy="13.5" r="1.5" stroke-width="1.5"/></svg>
                            </div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="px-1">
                        @if($project->is_featured)
                        <span class="tag text-brown border-brown/30 mb-2 inline-block">Featured</span>
                        @endif
                        <h3 class="font-serif text-xl font-semibold text-charcoal mb-2 group-hover:text-brown transition-colors">{{ $project->title }}</h3>
                        <p class="text-charcoal/60 text-sm leading-relaxed mb-4 line-clamp-3">{{ $project->description }}</p>

                        {{-- Tech stack --}}
                        <div class="flex flex-wrap gap-1.5 mb-5">
                            @foreach($project->technologies_array as $tech)
                            <span class="tag">{{ $tech }}</span>
                            @endforeach
                        </div>

                        {{-- Links --}}
                        <div class="flex gap-3">
                            @if($project->demo_url)
                            <a href="{{ $project->demo_url }}" target="_blank" rel="noopener" class="btn-primary btn-sm" id="project-demo-{{ $project->id }}">Live Demo</a>
                            @endif
                            @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="btn-outline btn-sm" id="project-github-{{ $project->id }}">GitHub</a>
                            @endif
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    {{-- ═══ DESIGN SHOWCASE ════════════════════════════════════════════════════ --}}
    <section id="design" class="py-24 md:py-32 bg-sand/30">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-12 scroll-reveal">
                <p class="section-label">Design Work</p>
                <h2 class="font-serif text-4xl md:text-5xl font-bold text-charcoal leading-tight mb-8">Design <em class="text-brown not-italic">Showcase</em></h2>

                {{-- Category Filter --}}
                @if($categories->count() > 0)
                <div class="flex flex-wrap gap-3" id="design-filters">
                    <button class="filter-btn active" data-filter="all" id="filter-all">All</button>
                    @foreach($categories as $cat)
                    <button class="filter-btn" data-filter="{{ Str::slug($cat) }}" id="filter-{{ Str::slug($cat) }}">{{ $cat }}</button>
                    @endforeach
                </div>
                @endif
            </div>

            @if($designWorks->isEmpty())
            <div class="text-center py-20 text-charcoal/40">
                <p class="text-lg">Belum ada karya desain yang dipublikasikan.</p>
                <p class="text-sm mt-2">Tambahkan karya melalui dashboard admin.</p>
            </div>
            @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" id="design-grid">
                @foreach($designWorks as $work)
                <div class="design-item scroll-reveal" data-category="{{ Str::slug($work->category) }}" data-title="{{ $work->title }}">
                    <div class="design-card group cursor-pointer" onclick="openLightbox('{{ $work->image_url }}', '{{ addslashes($work->title) }}', '{{ addslashes($work->category) }}')" id="design-work-{{ $work->id }}">
                        <div class="aspect-square bg-sand rounded-2xl overflow-hidden">
                            <img src="{{ $work->image_url }}" alt="{{ $work->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                        </div>
                        <div class="absolute inset-0 rounded-2xl bg-charcoal/0 group-hover:bg-charcoal/40 transition-all duration-300 flex items-end p-5 opacity-0 group-hover:opacity-100">
                            <div>
                                <p class="text-cream font-semibold">{{ $work->title }}</p>
                                <p class="text-cream/70 text-sm">{{ $work->category }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    {{-- ═══ CONTACT ═════════════════════════════════════════════════════════════ --}}
    <section id="contact" class="py-24 md:py-32">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-14 scroll-reveal">
                <p class="section-label">Get In Touch</p>
                <h2 class="font-serif text-4xl md:text-5xl font-bold text-charcoal mb-4">Let's <em class="text-brown not-italic">work</em> together.</h2>
                <p class="text-charcoal/60 max-w-md mx-auto">Punya proyek atau sekadar ingin ngobrol? Kirim pesan, saya akan membalas secepatnya.</p>
            </div>

            @if(session('contact_success'))
            <div class="bg-green-50 border border-green-200 rounded-2xl p-6 mb-8 text-center animate-fade-up">
                <svg class="w-10 h-10 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="font-semibold text-green-800">Pesan terkirim! Terima kasih.</p>
                <p class="text-green-600 text-sm mt-1">Saya akan membalas secepatnya.</p>
            </div>
            @endif

            <form action="{{ route('contact') }}" method="POST" class="card-cream space-y-6 scroll-reveal" id="contact-form">
                @csrf
                {{-- Honeypot --}}
                <div class="hidden" aria-hidden="true">
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label" for="name">Nama <span class="text-brown">*</span></label>
                        <input type="text" id="name" name="name" class="form-input @error('name') border-red-400 @enderror" value="{{ old('name') }}" placeholder="Kevin Yudha" required>
                        @error('name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label" for="email">Email <span class="text-brown">*</span></label>
                        <input type="email" id="email" name="email" class="form-input @error('email') border-red-400 @enderror" value="{{ old('email') }}" placeholder="kevin@email.com" required>
                        @error('email')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="form-label" for="subject">Subjek <span class="text-brown">*</span></label>
                    <input type="text" id="subject" name="subject" class="form-input @error('subject') border-red-400 @enderror" value="{{ old('subject') }}" placeholder="Kolaborasi proyek" required>
                    @error('subject')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label" for="message">Pesan <span class="text-brown">*</span></label>
                    <textarea id="message" name="message" rows="5" class="form-input resize-none @error('message') border-red-400 @enderror" placeholder="Ceritakan proyek atau pertanyaan Anda..." required>{{ old('message') }}</textarea>
                    @error('message')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn-primary" id="contact-submit">Kirim Pesan</button>
                </div>
            </form>
        </div>
    </section>

    {{-- ═══ FOOTER ══════════════════════════════════════════════════════════════ --}}
    <footer class="border-t border-sand py-10">
        <div class="max-w-6xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-charcoal/50">
            <p>© {{ date('Y') }} Kevin Yudha Pratama. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#home" class="hover:text-brown transition-colors">Home</a>
                <a href="#projects" class="hover:text-brown transition-colors">Projects</a>
                <a href="#contact" class="hover:text-brown transition-colors">Contact</a>
            </div>
        </div>
    </footer>

    {{-- ═══ LIGHTBOX ════════════════════════════════════════════════════════════ --}}
    <div id="lightbox" class="fixed inset-0 z-[100] bg-charcoal/90 backdrop-blur-sm hidden items-center justify-center p-4" onclick="closeLightbox(event)" role="dialog" aria-modal="true" aria-label="Image viewer">
        <div class="relative max-w-4xl w-full">
            <button onclick="closeLightboxBtn()" class="absolute -top-12 right-0 text-cream/70 hover:text-cream transition-colors" id="lightbox-close" aria-label="Close lightbox">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <img id="lightbox-img" src="" alt="" class="w-full max-h-[80vh] object-contain rounded-2xl">
            <div class="text-center mt-4">
                <p id="lightbox-title" class="text-cream font-semibold"></p>
                <p id="lightbox-cat" class="text-cream/50 text-sm"></p>
            </div>
        </div>
    </div>

</x-layouts.app>
