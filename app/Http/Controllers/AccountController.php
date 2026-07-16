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
            'boutique_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'founded' => ['nullable', 'string', 'max:4'],
            'description' => ['nullable', 'string'],
        ]);

        $boutique = $request->user()->boutique;

        if ($boutique) {
            $location = explode(',', $validated['location'] ?? '');
            $socialLinks = $boutique->social_links ?? [];

            if (isset($validated['instagram'])) {
                $socialLinks['instagram'] = $validated['instagram'];
            }

            $boutique->update([
                'name' => $validated['boutique_name'],
                'contact_email' => $validated['contact_email'],
                'phone' => $validated['phone'] ?? null,
                'city' => trim($location[0] ?? ''),
                'county' => trim($location[1] ?? ''),
                'description' => $validated['description'] ?? null,
                'social_links' => $socialLinks,
            ]);
        }

        return redirect()->route('account.settings')
            ->with('success', 'Boutique information updated successfully.');
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
