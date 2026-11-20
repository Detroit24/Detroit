<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\TemplateCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminTemplateController extends Controller
{
    public function index()
    {
        $templates = Template::with('category')->latest()->paginate(15);
        $categories = TemplateCategory::all();

        return view('admin.templates.index', compact('templates', 'categories'));
    }

    public function create()
    {
        $categories = TemplateCategory::all();
        return view('admin.templates.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:template_categories,id',
            'name' => 'required|string|max:255',
            'price_override' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(4);
        $validated['is_active'] = $request->has('is_active');

        Template::create($validated);

        return redirect()->route('admin.templates.index')->with('success', 'Template baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $template = Template::findOrFail($id);
        $categories = TemplateCategory::all();

        return view('admin.templates.edit', compact('template', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $template = Template::findOrFail($id);
        
        $validated = $request->validate([
            'category_id' => 'required|exists:template_categories,id',
            'name' => 'required|string|max:255',
            'price_override' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $template->update($validated);

        return redirect()->route('admin.templates.index')->with('success', 'Template berhasil diperbarui.');
    }

    public function toggleActive($id)
    {
        $template = Template::findOrFail($id);
        $template->is_active = !$template->is_active;
        $template->save();

        return redirect()->back()->with('success', 'Status template ' . $template->name . ' diperbarui.');
    }

    public function destroy($id)
    {
        $template = Template::findOrFail($id);
        $template->delete();

        return redirect()->route('admin.templates.index')->with('success', 'Template berhasil dihapus.');
    }
}
