<x-admin-shell :page-title="'Kelola Skills'">
<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-gray-500">{{ $skills->total() }} skills</p>
    <a href="{{ route('admin.skills.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-amber-700 transition-colors" id="btn-create-skill">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Skill
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
    @if($skills->isEmpty())
    <div class="text-center py-16 text-gray-400"><p>Belum ada skill.</p></div>
    @else
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Skill</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Kategori</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Level</th>
                <th class="px-5 py-3 text-center font-semibold text-gray-600">Status</th>
                <th class="px-5 py-3 text-right font-semibold text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($skills as $skill)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-3 font-medium text-gray-800">{{ $skill->name }}</td>
                <td class="px-5 py-3 text-gray-500 capitalize">{{ $skill->category }}</td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2">
                        <div class="w-20 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full" style="width:{{ $skill->level }}%"></div>
                        </div>
                        <span class="text-xs text-gray-500">{{ $skill->level }}%</span>
                    </div>
                </td>
                <td class="px-5 py-3 text-center">
                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $skill->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $skill->is_published ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-5 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.skills.edit', $skill) }}" class="text-amber-700 hover:underline text-xs font-medium" id="edit-skill-{{ $skill->id }}">Edit</a>
                        <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline text-xs font-medium" data-confirm="Hapus skill '{{ addslashes($skill->name) }}'?" id="delete-skill-{{ $skill->id }}">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($skills->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $skills->links() }}</div>
    @endif
    @endif
</div>
</x-admin-shell>
