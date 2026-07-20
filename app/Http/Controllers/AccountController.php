<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function overview(): View
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
        $query = $request->user()->boutique->products()->with(['category', 'colours'])->latest();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $products = $query->paginate(15)->withQueryString();

        return view('pages.account.products', compact('products'));
    }

    public function settings(Request $request): View
    {
        return view('pages.account.settings', [
            'user' => $request->user(),
        ]);
    }

    public function helpSupport(): View
    {
        return view('pages.account.help-support');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'logo' => ['nullable', 'image', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'remove_logo' => ['nullable', 'in:0,1'],
            'remove_cover_image' => ['nullable', 'in:0,1'],
            'boutique_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'designer' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'founded' => ['nullable', 'string', 'max:4'],
            'description' => ['nullable', 'string'],
        ]);

        $boutique = $request->user()->boutique;
        $user = $request->user();

        if ($boutique) {
            $location = explode(',', $validated['location'] ?? '');
            $socialLinks = $boutique->social_links ?? [];

            if (isset($validated['instagram'])) {
                $socialLinks['instagram'] = $validated['instagram'];
            }

            // Update user name (designer)
            $user->update([
                'name' => $validated['designer'],
            ]);

            $updateData = [
                'name' => $validated['boutique_name'],
                'contact_email' => $validated['contact_email'],
                'phone' => $validated['phone'] ?? null,
                'city' => trim($location[0] ?? ''),
                'county' => trim($location[1] ?? ''),
                'description' => $validated['description'] ?? null,
                'social_links' => $socialLinks,
            ];

            if ($request->input('remove_logo') === '1') {
                $updateData['logo'] = null;
            } elseif ($request->hasFile('logo')) {
                $updateData['logo'] = $request->file('logo')->store('boutiques/logos', 'public');
            }

            if ($request->input('remove_cover_image') === '1') {
                $updateData['cover_image'] = null;
            } elseif ($request->hasFile('cover_image')) {
                $updateData['cover_image'] = $request->file('cover_image')->store('boutiques/covers', 'public');
            }

            $boutique->update($updateData);
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
