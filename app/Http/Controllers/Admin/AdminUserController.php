<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->withCount('orders', 'invitations')->latest()->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = ($user->status === 'active') ? 'inactive' : 'active';
        $user->save();

        return redirect()->back()->with('success', 'Status pengguna berhasil diperbarui.');
    }
}
