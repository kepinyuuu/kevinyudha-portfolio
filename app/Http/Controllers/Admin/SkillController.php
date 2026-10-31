<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSkillRequest;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(): View
    {
        $skills = Skill::orderBy('sort_order')->orderBy('name')->paginate(15);
        return view('admin.skills.index', compact('skills'));
    }

    public function create(): View
    {
        return view('admin.skills.create');
    }

    public function store(StoreSkillRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');

        Skill::create($data);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill berhasil ditambahkan.');
    }

    public function edit(Skill $skill): View
    {
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(StoreSkillRequest $request, Skill $skill): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');

        $skill->update($data);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill berhasil diperbarui.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill berhasil dihapus.');
    }
}
