<x-admin-shell :page-title="'Detail Pesan'">
<div class="max-w-2xl">
    <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Semua Pesan
    </a>

    <div class="bg-white rounded-2xl border border-gray-200 p-7">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">{{ $message->subject }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $message->created_at->format('d F Y, H:i') }}</p>
            </div>
            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $message->read_at ? 'bg-gray-100 text-gray-500' : 'bg-amber-100 text-amber-700' }}">
                {{ $message->read_at ? 'Dibaca' : 'Baru' }}
            </span>
        </div>

        <div class="border-t border-gray-100 pt-5 mb-5">
            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Dari</p>
                    <p class="font-medium text-gray-800">{{ $message->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Email</p>
                    <a href="mailto:{{ $message->email }}" class="text-amber-700 hover:underline">{{ $message->email }}</a>
                </div>
            </div>

            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Pesan</p>
                <div class="bg-gray-50 rounded-xl p-4 text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $message->message }}</div>
            </div>
        </div>

        <div class="flex gap-3 pt-5 border-t border-gray-100">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}" class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-amber-700 transition-colors" id="reply-message-{{ $message->id }}">
                Balas via Email
            </a>
            <form method="POST" action="{{ route('admin.messages.toggle-read', $message) }}" class="inline">
                @csrf @method('PATCH')
                <button type="submit" class="px-4 py-2 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors" id="toggle-read-message-{{ $message->id }}">
                    {{ $message->read_at ? 'Tandai Belum Dibaca' : 'Tandai Dibaca' }}
                </button>
            </form>
            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="inline ml-auto">
                @csrf @method('DELETE')
                <button type="submit" class="px-4 py-2 text-red-500 border border-red-200 text-sm font-medium rounded-xl hover:bg-red-50 transition-colors" data-confirm="Hapus pesan ini?" id="delete-msg-{{ $message->id }}">Hapus</button>
            </form>
        </div>
    </div>
</div>
</x-admin-shell>
