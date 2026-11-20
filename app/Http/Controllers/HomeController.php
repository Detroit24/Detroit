<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\TemplateCategory;
use App\Models\Package;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = TemplateCategory::where('is_active', true)->withCount('templates')->get();
        $activeCategoryId = $request->get('category');

        $templatesQuery = Template::where('is_active', true)->with('category');
        if ($activeCategoryId) {
            $templatesQuery->where('category_id', $activeCategoryId);
        }
        $templates = $templatesQuery->orderBy('id', 'asc')->get();

        $packages = Package::where('is_active', true)->orderBy('price', 'asc')->get();
        $storeSettings = StoreSetting::all()->pluck('value', 'key');

        return view('home', compact('categories', 'templates', 'packages', 'storeSettings', 'activeCategoryId'));
    }

    public function templateDetail($slug)
    {
        $template = Template::where('slug', $slug)->where('is_active', true)->with('category', 'packages')->firstOrFail();
        return response()->json($template);
    }
}
