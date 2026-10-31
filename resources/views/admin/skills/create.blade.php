<x-admin-shell :page-title="isset($skill) ? 'Edit Skill' : 'Tambah Skill'">
<div class="max-w-lg">
    <a href="{{ route('admin.skills.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>

    <div class="bg-white rounded-2xl border border-gray-200 p-7">
        <form method="POST"
              action="{{ isset($skill) ? route('admin.skills.update', $skill) : route('admin.skills.store') }}"
              id="skill-form">
            @csrf
            @if(isset($skill)) @method('PUT') @endif

            <div class="space-y-5">
                <div>
                    <label class="admin-label" for="skill-name">Nama Skill *</label>
                    <input type="text" id="skill-name" name="name" class="admin-input @error('name') border-red-400 @enderror" value="{{ old('name', $skill->name ?? '') }}" required>
                    @error('name')<p class="admin-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="admin-label" for="skill-cat">Kategori *</label>
                    <select id="skill-cat" name="category" class="admin-input @error('category') border-red-400 @enderror">
                        <option value="general" {{ old('category', $skill->category ?? '') === 'general' ? 'selected' : '' }}>Development</option>
                        <option value="design" {{ old('category', $skill->category ?? '') === 'design' ? 'selected' : '' }}>Design</option>
                        <option value="tools" {{ old('category', $skill->category ?? '') === 'tools' ? 'selected' : '' }}>Tools</option>
                    </select>
                    @error('category')<p class="admin-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="admin-label" for="skill-level">Level (1-100): <span id="level-display" class="text-amber-700 font-bold">{{ old('level', $skill->level ?? 80) }}%</span></label>
                    <input type="range" id="skill-level" name="level" min="1" max="100" class="w-full accent-amber-700" value="{{ old('level', $skill->level ?? 80) }}" oninput="document.getElementById('level-display').textContent=this.value+'%'">
                    @error('level')<p class="admin-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="admin-label" for="skill-sort">Urutan</label>
                    <input type="number" id="skill-sort" name="sort_order" class="admin-input" value="{{ old('sort_order', $skill->sort_order ?? 0) }}" min="0">
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="skill-published" name="is_published" value="1" class="rounded" {{ old('is_published', $skill->is_published ?? true) ? 'checked' : '' }}>
                    <label for="skill-published" class="text-sm text-gray-700">Tampilkan di portfolio</label>
                </div>
            </div>

            <div class="flex gap-3 mt-7 pt-6 border-t border-gray-100">
                <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white font-medium rounded-xl hover:bg-amber-700 transition-colors" id="skill-submit">
                    {{ isset($skill) ? 'Simpan Perubahan' : 'Tambah Skill' }}
                </button>
                <a href="{{ route('admin.skills.index') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 font-medium rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
</x-admin-shell>
