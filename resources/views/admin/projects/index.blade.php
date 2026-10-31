<x-admin-shell :page-title="'Kelola Proyek'">
<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-gray-500">{{ $projects->total() }} proyek</p>
    <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-amber-700 transition-colors" id="btn-create-project">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Proyek
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
    @if($projects->isEmpty())
    <div class="text-center py-16 text-gray-400">
        <p>Belum ada proyek.</p>
    </div>
    @else
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Proyek</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600 hidden md:table-cell">Teknologi</th>
                <th class="px-5 py-3 text-center font-semibold text-gray-600">Status</th>
                <th class="px-5 py-3 text-right font-semibold text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($projects as $project)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        @if($project->image_url)
                        <img src="{{ $project->image_url }}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0" alt="">
                        @else
                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex-shrink-0"></div>
                        @endif
                        <div>
                            <p class="font-medium text-gray-800">{{ $project->title }}</p>
                            @if($project->is_featured)<span class="text-xs text-amber-600 font-medium">Featured</span>@endif
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 hidden md:table-cell">
                    <p class="text-gray-500 truncate max-w-[200px]">{{ $project->technologies }}</p>
                </td>
                <td class="px-5 py-4 text-center">
                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $project->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $project->is_published ? 'Publik' : 'Draft' }}
                    </span>
                </td>
                <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.projects.edit', $project) }}" class="text-amber-700 hover:underline text-xs font-medium" id="edit-project-{{ $project->id }}">Edit</a>
                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline text-xs font-medium" data-confirm="Hapus proyek '{{ addslashes($project->title) }}'?" id="delete-project-{{ $project->id }}">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($projects->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $projects->links() }}</div>
    @endif
    @endif
</div>
</x-admin-shell>
