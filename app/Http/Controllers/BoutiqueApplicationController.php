<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoutiqueApplicationRequest;
use App\Models\Boutique;
use App\Notifications\NewBoutiqueApplicationNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BoutiqueApplicationController extends Controller
{
    public function create(): View
    {
        return view('pages.boutique-application');
    }

    public function store(BoutiqueApplicationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $boutique = new Boutique;
        $boutique->name = $validated['name'];
        $boutique->slug = Str::slug($validated['name']);
        $boutique->description = $validated['bio'];
        $boutique->county = $validated['region'];
        $boutique->contact_email = $validated['contact_email'];
        $boutique->phone = $validated['phone'] ?? null;
        $boutique->pending_email = $validated['email'];
        $boutique->pending_password = $validated['password'];
        $boutique->status = Boutique::STATUS_PENDING;
        $boutique->is_active = false;

        if ($request->hasFile('logo')) {
            $boutique->logo = $request->file('logo')->store('boutiques/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $boutique->cover_image = $request->file('cover_image')->store('boutiques/covers', 'public');
        }

        if (! empty($validated['instagram'])) {
            $boutique->social_links = [
                'instagram' => $validated['instagram'],
            ];
        }

        $boutique->save();

        Notification::route('mail', config('app.admin_email'))
            ->notify(new NewBoutiqueApplicationNotification($boutique));

        return redirect()->route('boutique.application.confirmation')
            ->with('success', 'Your boutique application has been submitted successfully. We will review it within 48 hours.');
    }

    public function confirmation(): View
    {
        return view('pages.boutique-application-confirmation');
    }
}
