{{-- Admin Layout Wrapper --}}
<x-layouts.admin :title="$title ?? 'Admin'">
<div class="min-h-screen flex" x-data="{ sidebarOpen: false }">

    {{-- Sidebar --}}
    <aside class="hidden md:flex flex-col w-64 bg-gray-900 text-white min-h-screen sticky top-0">
        <div class="px-6 py-6 border-b border-gray-800">
            <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold">Kevin<span class="text-amber-500">.</span>admin</a>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">
            @php $current = request()->routeIs('admin.dashboard') ? 'dashboard' : (request()->routeIs('admin.projects*') ? 'projects' : (request()->routeIs('admin.skills*') ? 'skills' : (request()->routeIs('admin.design-works*') ? 'design-works' : (request()->routeIs('admin.messages*') ? 'messages' : (request()->routeIs('admin.profile*') ? 'profile' : ''))))); @endphp

            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ $current === 'dashboard' ? 'nav-item-active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="14" width="7" height="7" rx="1" stroke-width="2"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.projects.index') }}" class="nav-item {{ $current === 'projects' ? 'nav-item-active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                Proyek
            </a>
            <a href="{{ route('admin.skills.index') }}" class="nav-item {{ $current === 'skills' ? 'nav-item-active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Skills
            </a>
            <a href="{{ route('admin.design-works.index') }}" class="nav-item {{ $current === 'design-works' ? 'nav-item-active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Karya Desain
            </a>
            <a href="{{ route('admin.messages.index') }}" class="nav-item {{ $current === 'messages' ? 'nav-item-active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Pesan
                @php $unread = \App\Models\ContactMessage::unread()->count(); @endphp
                @if($unread > 0)
                <span class="ml-auto bg-amber-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unread }}</span>
                @endif
            </a>
            <a href="{{ route('admin.profile.edit') }}" class="nav-item {{ $current === 'profile' ? 'nav-item-active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Edit Profil
            </a>
        </nav>

        <div class="px-4 py-4 border-t border-gray-800 space-y-2">
            <a href="{{ route('home') }}" target="_blank" class="nav-item text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Lihat Portfolio
            </a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="nav-item w-full text-left text-gray-400 hover:text-red-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col min-w-0">
        {{-- Top bar --}}
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-800">{{ $pageTitle ?? 'Dashboard' }}</h1>
            <span class="text-sm text-gray-500">{{ auth()->user()->name }}</span>
        </header>

        {{-- Flash Messages --}}
        <div class="px-6 pt-4">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-green-800 text-sm mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-red-800 text-sm mb-4">{{ session('error') }}</div>
            @endif
        </div>

        <main class="flex-1 px-6 py-6">
            {{ $slot }}
        </main>
    </div>
</div>

<style>
.nav-item { display:flex; align-items:center; gap:0.75rem; padding:0.625rem 0.875rem; border-radius:0.625rem; font-size:0.9375rem; color:#9ca3af; transition:background 0.15s,color 0.15s; text-decoration:none; }
.nav-item:hover { background:rgba(255,255,255,0.07); color:#f9fafb; }
.nav-item-active { background:rgba(245,240,232,0.12); color:#f9fafb; }
</style>
</x-layouts.admin>
