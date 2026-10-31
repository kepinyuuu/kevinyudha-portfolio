<x-admin-shell :page-title="isset($designWork) ? 'Edit Karya Desain' : 'Tambah Karya Desain'">
<div class="max-w-lg">
    <a href="{{ route('admin.design-works.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>

    <div class="bg-white rounded-2xl border border-gray-200 p-7">
        <form method="POST"
              action="{{ isset($designWork) ? route('admin.design-works.update', $designWork) : route('admin.design-works.store') }}"
              enctype="multipart/form-data" id="design-work-form">
            @csrf
            @if(isset($designWork)) @method('PUT') @endif

            <div class="space-y-5">
                <div>
                    <label class="admin-label" for="dw-title">Judul *</label>
                    <input type="text" id="dw-title" name="title" class="admin-input @error('title') border-red-400 @enderror" value="{{ old('title', $designWork->title ?? '') }}" required>
                    @error('title')<p class="admin-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="admin-label" for="dw-category">Kategori *</label>
                    <input type="text" id="dw-category" name="category" class="admin-input @error('category') border-red-400 @enderror" value="{{ old('category', $designWork->category ?? '') }}" placeholder="UI/UX, Branding, Illustration..." required>
                    @error('category')<p class="admin-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="admin-label" for="dw-desc">Deskripsi</label>
                    <textarea id="dw-desc" name="description" rows="3" class="admin-input resize-none">{{ old('description', $designWork->description ?? '') }}</textarea>
                </div>

                <div>
                    <label class="admin-label" for="dw-image">Gambar {{ !isset($designWork) ? '*' : '' }} <span class="text-gray-400 font-normal">(jpg/png/webp, maks 2MB)</span></label>
                    @if(isset($designWork) && $designWork->image)
                    <img id="dw-preview" src="{{ $designWork->image_url }}" class="w-32 h-32 object-cover rounded-xl mb-3 border border-gray-200" alt="Preview">
                    @else
                    <img id="dw-preview" src="" class="w-32 h-32 object-cover rounded-xl mb-3 border border-gray-200 hidden" alt="Preview">
                    @endif
                    <input type="file" id="dw-image" name="image" class="admin-input" accept="image/jpg,image/jpeg,image/png,image/webp" {{ !isset($designWork) ? 'required' : '' }} data-preview="dw-preview">
                    @error('image')<p class="admin-error">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="admin-label" for="dw-sort">Urutan</label>
                        <input type="number" id="dw-sort" name="sort_order" class="admin-input" value="{{ old('sort_order', $designWork->sort_order ?? 0) }}" min="0">
                    </div>
                    <div class="flex items-center gap-2 mt-6">
                        <input type="checkbox" id="dw-published" name="is_published" value="1" class="rounded" {{ old('is_published', $designWork->is_published ?? true) ? 'checked' : '' }}>
                        <label for="dw-published" class="text-sm text-gray-700">Publik</label>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-7 pt-6 border-t border-gray-100">
                <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white font-medium rounded-xl hover:bg-amber-700 transition-colors" id="design-work-submit">
                    {{ isset($designWork) ? 'Simpan Perubahan' : 'Tambah Karya' }}
                </button>
                <a href="{{ route('admin.design-works.index') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 font-medium rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
</x-admin-shell>
