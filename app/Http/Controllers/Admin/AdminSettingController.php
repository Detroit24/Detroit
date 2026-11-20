<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = StoreSetting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except('_token');

        foreach ($inputs as $key => $value) {
            StoreSetting::set($key, $value ?? '');
        }

        return redirect()->back()->with('success', 'Pengaturan toko berhasil disimpan.');
    }
}
