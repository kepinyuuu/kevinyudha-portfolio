<x-admin-shell :page-title="'Kelola Karya Desain'">
<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-gray-500">{{ $designWorks->total() }} karya</p>
    <a href="{{ route('admin.design-works.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-amber-700 transition-colors" id="btn-create-design-work">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Karya
    </a>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
    @forelse($designWorks as $work)
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden group">
        <div class="aspect-square overflow-hidden">
            <img src="{{ $work->image_url }}" alt="{{ $work->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        </div>
        <div class="p-4">
            <p class="font-medium text-gray-800 truncate">{{ $work->title }}</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $work->category }}</p>
            <div class="flex items-center justify-between mt-3">
                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $work->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $work->is_published ? 'Publik' : 'Draft' }}
                </span>
                <div class="flex gap-3">
                    <a href="{{ route('admin.design-works.edit', $work) }}" class="text-amber-700 hover:underline text-xs font-medium" id="edit-design-work-{{ $work->id }}">Edit</a>
                    <form method="POST" action="{{ route('admin.design-works.destroy', $work) }}" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline text-xs font-medium" data-confirm="Hapus karya '{{ addslashes($work->title) }}'?" id="delete-design-work-{{ $work->id }}">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-16 text-gray-400"><p>Belum ada karya desain.</p></div>
    @endforelse
</div>

@if($designWorks->hasPages())
<div class="mt-6">{{ $designWorks->links() }}</div>
@endif
</x-admin-shell>
