<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Models\Profile;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(private ImageUploadService $imageService) {}

    public function edit(): View
    {
        $profile = Profile::firstOrNew(['id' => 1]);
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $profile = Profile::firstOrNew(['id' => 1]);
        $data    = $request->validated();

        // Handle photo upload: delete old, store new
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->imageService->replace(
                $profile->photo,
                $request->file('photo'),
                'profile'
            );
        } else {
            unset($data['photo']); // keep existing
        }

        // Blank optional URL fields should be stored as null
        foreach (['github_url', 'linkedin_url', 'instagram_url', 'other_social_url'] as $urlField) {
            if (isset($data[$urlField]) && blank($data[$urlField])) {
                $data[$urlField] = null;
            }
        }

        $profile->fill($data);
        $profile->save();

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}

