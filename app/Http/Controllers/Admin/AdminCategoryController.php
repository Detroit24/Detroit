<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemplateCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = TemplateCategory::withCount('templates')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = true;

        TemplateCategory::create($validated);

        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $category = TemplateCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = TemplateCategory::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}
