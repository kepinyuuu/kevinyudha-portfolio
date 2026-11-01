<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDescription ?? 'Portfolio Kevin Yudha Pratama — Web Development & Designer' }}">
    <meta property="og:title" content="{{ $title ?? 'Kevin Yudha Pratama — Web Development & Designer' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Portfolio Kevin Yudha Pratama — Web Development & Designer' }}">
    <meta property="og:type" content="website">
    <title>{{ $title ?? 'Kevin Yudha Pratama — Web Development & Designer' }}</title>

    {{-- Anti-flash: terapkan tema sesegera mungkin dari localStorage / OS preference --}}
    <script>
        (function () {
            var saved = localStorage.getItem('theme');
            var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            var isDark = saved ? saved === 'dark' : prefersDark;
            var html = document.documentElement;
            if (isDark) {
                html.classList.add('dark');
                html.classList.remove('light');
            } else {
                html.classList.remove('dark');
                html.classList.add('light');
            }
        })();
    </script>

    {{-- Typography: Manrope (400, 500, 600, 700, 800) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[var(--background)] text-[var(--foreground)] font-sans antialiased overflow-x-hidden relative min-h-screen">

    {{-- ═══ SCROLL PROGRESS BAR (Atas layar) ════════════════════════════════════ --}}
    <div id="scroll-progress-bar" class="fixed top-0 left-0 right-0 h-[2px] z-[60] bg-transparent pointer-events-none" aria-hidden="true">
        <div id="scroll-progress-fill" class="h-full w-0 bg-gradient-to-r from-neutral-400 via-white to-neutral-200 transition-[width] duration-75"></div>
    </div>

    {{-- ═══ ATMOSPHERIC BACKGROUND (Fixed di belakang seluruh konten) ════════════ --}}
    <div class="fixed inset-0 pointer-events-none -z-20 overflow-hidden bg-[var(--background)] transition-colors duration-300" aria-hidden="true">
        {{-- Floating Radial Blobs bergerak perlahan (transform saja) --}}
        <div class="atmospheric-blobs absolute inset-0">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
            <div class="blob blob-4"></div>
        </div>

        {{-- Noise/Grain Halus (Opacity ~3.5%) --}}
        <div class="absolute inset-0 bg-noise opacity-[0.035]"></div>
    </div>

    {{ $slot }}
    @stack('scripts')
</body>
</html>
