<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDesignWorkRequest;
use App\Models\DesignWork;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DesignWorkController extends Controller
{
    public function __construct(private ImageUploadService $imageService) {}

    public function index(): View
    {
        $designWorks = DesignWork::orderBy('sort_order')->orderByDesc('created_at')->paginate(12);
        return view('admin.design-works.index', compact('designWorks'));
    }

    public function create(): View
    {
        return view('admin.design-works.create');
    }

    public function store(StoreDesignWorkRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $data['image']        = $this->imageService->store($request->file('image'), 'design-works');

        DesignWork::create($data);

        return redirect()->route('admin.design-works.index')
            ->with('success', 'Karya desain berhasil ditambahkan.');
    }

    public function edit(DesignWork $designWork): View
    {
        return view('admin.design-works.edit', compact('designWork'));
    }

    public function update(StoreDesignWorkRequest $request, DesignWork $designWork): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            $data['image'] = $this->imageService->replace($designWork->image, $request->file('image'), 'design-works');
        } else {
            unset($data['image']);
        }

        $designWork->update($data);

        return redirect()->route('admin.design-works.index')
            ->with('success', 'Karya desain berhasil diperbarui.');
    }

    public function destroy(DesignWork $designWork): RedirectResponse
    {
        $this->imageService->delete($designWork->image);
        $designWork->delete();

        return redirect()->route('admin.design-works.index')
            ->with('success', 'Karya desain berhasil dihapus.');
    }
}
