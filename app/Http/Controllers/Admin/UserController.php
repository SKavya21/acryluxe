<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function updateAdmin(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'is_admin' => ['required', 'boolean'],
        ]);

        if ((int) $request->user()->id === (int) $user->id && ! (bool) $validated['is_admin']) {
            return back()->with('error', 'You cannot remove your own admin access.');
        }

        $user->update([
            'is_admin' => (bool) $validated['is_admin'],
        ]);

        return back()->with('success', 'User role updated successfully.');
    }
}
