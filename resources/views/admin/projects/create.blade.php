{{-- Shared form partial for create/edit project --}}
<x-admin-shell :page-title="isset($project) ? 'Edit Proyek' : 'Tambah Proyek'">
<div class="max-w-2xl">
    <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>

    <div class="bg-white rounded-2xl border border-gray-200 p-7">
        <form method="POST"
              action="{{ isset($project) ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
              enctype="multipart/form-data" id="project-form">
            @csrf
            @if(isset($project)) @method('PUT') @endif

            <div class="space-y-5">
                <div>
                    <label class="admin-label" for="proj-title">Judul *</label>
                    <input type="text" id="proj-title" name="title" class="admin-input @error('title') border-red-400 @enderror" value="{{ old('title', $project->title ?? '') }}" required>
                    @error('title')<p class="admin-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="admin-label" for="proj-desc">Deskripsi *</label>
                    <textarea id="proj-desc" name="description" rows="4" class="admin-input resize-none @error('description') border-red-400 @enderror">{{ old('description', $project->description ?? '') }}</textarea>
                    @error('description')<p class="admin-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="admin-label" for="proj-tech">Teknologi * <span class="text-gray-400 font-normal">(pisahkan dengan koma)</span></label>
                    <input type="text" id="proj-tech" name="technologies" class="admin-input @error('technologies') border-red-400 @enderror" value="{{ old('technologies', $project->technologies ?? '') }}" placeholder="Laravel, Livewire, Tailwind CSS">
                    @error('technologies')<p class="admin-error">{{ $message }}</p>@enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="admin-label" for="proj-demo">URL Demo</label>
                        <input type="url" id="proj-demo" name="demo_url" class="admin-input" value="{{ old('demo_url', $project->demo_url ?? '') }}" placeholder="https://">
                    </div>
                    <div>
                        <label class="admin-label" for="proj-github">URL GitHub</label>
                        <input type="url" id="proj-github" name="github_url" class="admin-input" value="{{ old('github_url', $project->github_url ?? '') }}" placeholder="https://github.com/">
                    </div>
                </div>

                <div>
                    <label class="admin-label" for="proj-image">Gambar <span class="text-gray-400 font-normal">(jpg/png/webp, maks 2MB)</span></label>
                    @if(isset($project) && $project->image)
                    <img id="proj-preview" src="{{ $project->image_url }}" class="w-32 h-20 object-cover rounded-xl mb-3 border border-gray-200" alt="Preview saat ini">
                    @else
                    <img id="proj-preview" src="" class="w-32 h-20 object-cover rounded-xl mb-3 border border-gray-200 hidden" alt="Preview">
                    @endif
                    <input type="file" id="proj-image" name="image" class="admin-input" accept="image/jpg,image/jpeg,image/png,image/webp" data-preview="proj-preview">
                    @error('image')<p class="admin-error">{{ $message }}</p>@enderror
                </div>

                <div class="grid sm:grid-cols-3 gap-5">
                    <div>
                        <label class="admin-label" for="proj-sort">Urutan</label>
                        <input type="number" id="proj-sort" name="sort_order" class="admin-input" value="{{ old('sort_order', $project->sort_order ?? 0) }}" min="0">
                    </div>
                    <div class="flex items-center gap-2 mt-6">
                        <input type="checkbox" id="proj-featured" name="is_featured" value="1" class="rounded" {{ old('is_featured', $project->is_featured ?? false) ? 'checked' : '' }}>
                        <label for="proj-featured" class="text-sm text-gray-700">Featured</label>
                    </div>
                    <div class="flex items-center gap-2 mt-6">
                        <input type="checkbox" id="proj-published" name="is_published" value="1" class="rounded" {{ old('is_published', $project->is_published ?? true) ? 'checked' : '' }}>
                        <label for="proj-published" class="text-sm text-gray-700">Publik</label>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-7 pt-6 border-t border-gray-100">
                <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white font-medium rounded-xl hover:bg-amber-700 transition-colors" id="project-submit">
                    {{ isset($project) ? 'Simpan Perubahan' : 'Tambah Proyek' }}
                </button>
                <a href="{{ route('admin.projects.index') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 font-medium rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
</x-admin-shell>
