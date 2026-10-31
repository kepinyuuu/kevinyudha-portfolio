<x-layouts.app :title="'404 — Halaman Tidak Ditemukan | Kevin Yudha Pratama'">
    <div class="min-h-screen flex items-center justify-center px-6 py-20 bg-cream">
        <div class="max-w-md w-full text-center">
            <span class="inline-block text-sm font-semibold tracking-widest text-brown uppercase mb-3">Error 404</span>
            <h1 class="font-serif text-6xl md:text-7xl font-bold text-charcoal mb-4">404</h1>
            <h2 class="font-serif text-2xl md:text-3xl font-semibold text-charcoal mb-4">Halaman Tidak Ditemukan</h2>
            <p class="text-charcoal/70 mb-8 leading-relaxed">
                Halaman yang Anda tuju tidak ditemukan atau telah dipindahkan.
            </p>
            <div class="flex items-center justify-center gap-4">
                <a href="{{ route('home') }}" class="btn-primary">
                    <svg class="w-4 h-4 mr-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
