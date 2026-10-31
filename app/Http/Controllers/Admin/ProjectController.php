<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Models\Project;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function __construct(private ImageUploadService $imageService) {}

    public function index(): View
    {
        $projects = Project::orderBy('sort_order')->orderByDesc('created_at')->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('admin.projects.create');
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_featured']  = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            $data['image'] = $this->imageService->store($request->file('image'), 'projects');
        }

        Project::create($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Proyek berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(StoreProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->validated();
        $data['is_featured']  = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            $data['image'] = $this->imageService->replace($project->image, $request->file('image'), 'projects');
        } else {
            unset($data['image']);
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->imageService->delete($project->image);
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Proyek berhasil dihapus.');
    }
}
