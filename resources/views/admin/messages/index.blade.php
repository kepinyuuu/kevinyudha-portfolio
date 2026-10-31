<x-admin-shell :page-title="'Pesan Masuk'">
<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
    @if($messages->isEmpty())
    <div class="text-center py-16 text-gray-400"><p>Belum ada pesan masuk.</p></div>
    @else
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Pengirim</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600 hidden md:table-cell">Subjek</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600 hidden lg:table-cell">Tanggal</th>
                <th class="px-5 py-3 text-center font-semibold text-gray-600">Status</th>
                <th class="px-5 py-3 text-right font-semibold text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($messages as $message)
            <tr class="hover:bg-gray-50 transition-colors {{ !$message->read_at ? 'font-semibold' : '' }}">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-2">
                        @if(!$message->read_at)<span class="w-2 h-2 bg-amber-500 rounded-full flex-shrink-0"></span>@endif
                        <div>
                            <p class="text-gray-800">{{ $message->name }}</p>
                            <p class="text-xs text-gray-400 font-normal">{{ $message->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 text-gray-600 hidden md:table-cell font-normal">{{ Str::limit($message->subject, 40) }}</td>
                <td class="px-5 py-4 text-gray-400 text-xs font-normal hidden lg:table-cell">{{ $message->created_at->format('d M Y, H:i') }}</td>
                <td class="px-5 py-4 text-center">
                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $message->read_at ? 'bg-gray-100 text-gray-500' : 'bg-amber-100 text-amber-700' }}">
                        {{ $message->read_at ? 'Dibaca' : 'Baru' }}
                    </span>
                </td>
                <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.messages.show', $message) }}" class="text-amber-700 hover:underline text-xs font-medium" id="view-message-{{ $message->id }}">Buka</a>
                        <form method="POST" action="{{ route('admin.messages.toggle-read', $message) }}" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-gray-500 hover:underline text-xs font-medium" id="toggle-message-{{ $message->id }}">
                                {{ $message->read_at ? 'Tandai baru' : 'Tandai dibaca' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline text-xs font-medium" data-confirm="Hapus pesan dari {{ addslashes($message->name) }}?" id="delete-message-{{ $message->id }}">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($messages->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $messages->links() }}</div>
    @endif
    @endif
</div>
</x-admin-shell>
