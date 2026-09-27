<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function create(): View
    {
        return view('admin.auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $adminUsername = (string) config('auth.admin_username');
        $adminEmail = (string) config('auth.admin_email');
        $adminPassword = (string) config('auth.admin_password');

        if ($validated['identifier'] !== $adminUsername && $validated['identifier'] !== $adminEmail) {
            throw ValidationException::withMessages([
                'identifier' => 'Use the administrator username.',
            ]);
        }

        if (! hash_equals($adminPassword, $validated['password'])) {
            throw ValidationException::withMessages([
                'password' => 'The administrator credentials are invalid.',
            ]);
        }

        $user = User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Acryluxe Admin',
                'password' => Hash::make($adminPassword),
                'is_admin' => true,
            ],
        );

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }
}
