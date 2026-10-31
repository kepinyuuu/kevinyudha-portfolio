<x-admin-shell :page-title="'Edit Profil'">
@php
    $photoUrl = ($profile?->photo) ? \Illuminate\Support\Facades\Storage::disk(config('filesystems.default'))->url($profile->photo) : '';
@endphp
<div class="max-w-3xl">

    <div class="bg-white rounded-2xl border border-gray-200 p-7">
        <form method="POST" action="{{ route('admin.profile.update') }}"
              enctype="multipart/form-data" id="profile-form">
            @csrf
            @method('PUT')

            {{-- ── Foto Profil ──────────────────────────────────────────── --}}
            <div class="mb-8 pb-7 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-5">Foto Profil</h2>
                <div class="flex items-start gap-6" x-data="{ preview: '{{ $photoUrl }}' }">
                    <div class="w-24 h-24 rounded-2xl border border-gray-200 overflow-hidden bg-gray-50 flex-shrink-0">
                        <template x-if="preview">
                            <img :src="preview" class="w-full h-full object-cover" alt="Preview foto">
                        </template>
                        <template x-if="!preview">
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                            </div>
                        </template>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="photo" id="photo-input" accept="image/jpg,image/jpeg,image/png,image/webp"
                               class="admin-input"
                               @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : preview">
                        <p class="text-xs text-gray-400 mt-1.5">JPG, JPEG, PNG, atau WEBP · Maks 2 MB</p>
                        @error('photo')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ── Identitas ────────────────────────────────────────────── --}}
            <div class="mb-8 pb-7 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-5">Identitas</h2>
                <div class="space-y-5">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="admin-label" for="p-name">Nama Lengkap *</label>
                            <input type="text" id="p-name" name="name"
                                   class="admin-input @error('name') border-red-400 @enderror"
                                   value="{{ old('name', $profile?->name) }}" required>
                            @error('name')<p class="admin-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="admin-label" for="p-title">Jabatan / Peran *</label>
                            <input type="text" id="p-title" name="title"
                                   class="admin-input @error('title') border-red-400 @enderror"
                                   value="{{ old('title', $profile?->title) }}" required
                                   placeholder="UI/UX Designer &amp; Developer">
                            @error('title')<p class="admin-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="admin-label" for="p-email">Email Kontak Publik</label>
                        <input type="email" id="p-email" name="email"
                               class="admin-input @error('email') border-red-400 @enderror"
                               value="{{ old('email', $profile?->email) }}" placeholder="kamu@domain.com">
                        @error('email')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ── Hero Section ─────────────────────────────────────────── --}}
            <div class="mb-8 pb-7 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-5">Hero Section</h2>
                <div class="space-y-5">
                    <div>
                        <label class="admin-label" for="p-headline">Headline <span class="text-gray-400 font-normal">(gunakan \n untuk baris baru)</span></label>
                        <input type="text" id="p-headline" name="hero_headline"
                               class="admin-input @error('hero_headline') border-red-400 @enderror"
                               value="{{ old('hero_headline', $profile?->hero_headline) }}"
                               placeholder="Designing Experiences,\nBuilding the Web.">
                        @error('hero_headline')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="admin-label" for="p-herodesc">Deskripsi Hero</label>
                        <textarea id="p-herodesc" name="hero_description" rows="2"
                                  class="admin-input resize-none @error('hero_description') border-red-400 @enderror"
                                  placeholder="Kalimat singkat yang mendeskripsikan diri kamu…">{{ old('hero_description', $profile?->hero_description) }}</textarea>
                        @error('hero_description')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ── About ────────────────────────────────────────────────── --}}
            <div class="mb-8 pb-7 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-5">About</h2>
                <div class="space-y-5">
                    <div>
                        <label class="admin-label" for="p-bio">Bio</label>
                        <textarea id="p-bio" name="bio" rows="4"
                                  class="admin-input resize-none @error('bio') border-red-400 @enderror">{{ old('bio', $profile?->bio) }}</textarea>
                        @error('bio')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="admin-label" for="p-edu">Pendidikan</label>
                            <input type="text" id="p-edu" name="education"
                                   class="admin-input @error('education') border-red-400 @enderror"
                                   value="{{ old('education', $profile?->education) }}"
                                   placeholder="Universitas — Jurusan">
                            @error('education')<p class="admin-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="admin-label" for="p-eduyear">Tahun Pendidikan</label>
                            <input type="text" id="p-eduyear" name="education_year"
                                   class="admin-input @error('education_year') border-red-400 @enderror"
                                   value="{{ old('education_year', $profile?->education_year) }}"
                                   placeholder="2021 – Sekarang">
                            @error('education_year')<p class="admin-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="admin-label" for="p-interests">Minat <span class="text-gray-400 font-normal">(pisahkan koma)</span></label>
                        <input type="text" id="p-interests" name="interests"
                               class="admin-input @error('interests') border-red-400 @enderror"
                               value="{{ old('interests', $profile?->interests) }}"
                               placeholder="UI/UX Design, Web Development, Photography">
                        @error('interests')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="admin-label" for="p-exp">Pengalaman Kerja <span class="text-gray-400 font-normal">(kosongkan jika belum ada)</span></label>
                        <textarea id="p-exp" name="experience" rows="3"
                                  class="admin-input resize-none @error('experience') border-red-400 @enderror"
                                  placeholder="Nama Perusahaan — Posisi (Tahun)">{{ old('experience', $profile?->experience) }}</textarea>
                        @error('experience')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="admin-label" for="p-extra">Catatan Tambahan About <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <textarea id="p-extra" name="about_extra" rows="2"
                                  class="admin-input resize-none @error('about_extra') border-red-400 @enderror">{{ old('about_extra', $profile?->about_extra) }}</textarea>
                        @error('about_extra')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ── Tautan Sosial ────────────────────────────────────────── --}}
            <div class="mb-8">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-5">Tautan Sosial</h2>
                <div class="space-y-4">
                    <div>
                        <label class="admin-label" for="p-github">GitHub URL</label>
                        <input type="url" id="p-github" name="github_url"
                               class="admin-input @error('github_url') border-red-400 @enderror"
                               value="{{ old('github_url', $profile?->github_url) }}"
                               placeholder="https://github.com/username">
                        @error('github_url')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="admin-label" for="p-linkedin">LinkedIn URL</label>
                        <input type="url" id="p-linkedin" name="linkedin_url"
                               class="admin-input @error('linkedin_url') border-red-400 @enderror"
                               value="{{ old('linkedin_url', $profile?->linkedin_url) }}"
                               placeholder="https://linkedin.com/in/username">
                        @error('linkedin_url')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="admin-label" for="p-ig">Instagram URL</label>
                        <input type="url" id="p-ig" name="instagram_url"
                               class="admin-input @error('instagram_url') border-red-400 @enderror"
                               value="{{ old('instagram_url', $profile?->instagram_url) }}"
                               placeholder="https://instagram.com/username">
                        @error('instagram_url')<p class="admin-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="admin-label" for="p-othername">Nama Platform Lain</label>
                            <input type="text" id="p-othername" name="other_social_name"
                                   class="admin-input @error('other_social_name') border-red-400 @enderror"
                                   value="{{ old('other_social_name', $profile?->other_social_name) }}"
                                   placeholder="Behance, Dribbble, dll.">
                            @error('other_social_name')<p class="admin-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="admin-label" for="p-otherurl">URL Platform Lain</label>
                            <input type="url" id="p-otherurl" name="other_social_url"
                                   class="admin-input @error('other_social_url') border-red-400 @enderror"
                                   value="{{ old('other_social_url', $profile?->other_social_url) }}"
                                   placeholder="https://behance.net/username">
                            @error('other_social_url')<p class="admin-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-6 border-t border-gray-100">
                <button type="submit"
                        class="px-6 py-2.5 bg-gray-900 text-white font-medium rounded-xl hover:bg-amber-700 transition-colors">
                    Simpan Profil
                </button>
                <a href="{{ route('admin.dashboard') }}"
                   class="px-6 py-2.5 border border-gray-200 text-gray-600 font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
</x-admin-shell>
