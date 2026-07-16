<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function overview(Request $request): View
    {
        return view('pages.account.overview');
    }

    public function boutiqueInfo(Request $request): View
    {
        return view('pages.account.boutique-info', [
            'boutique' => $request->user()->boutique,
        ]);
    }

    public function products(Request $request): View
    {
        $products = $request->user()->boutique->products()
            ->latest()
            ->paginate(15);

        return view('pages.account.products', compact('products'));
    }

    public function settings(Request $request): View
    {
        return view('pages.account.settings', [
            'user' => $request->user(),
        ]);
    }

    public function helpSupport(Request $request): View
    {
        return view('pages.account.help-support');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$request->user()->id],
        ]);

        $request->user()->update($validated);

        return redirect()->route('account.settings')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        return redirect()->route('account.settings')
            ->with('success', 'Password updated successfully.');
    }
}
