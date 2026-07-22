<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEnquiryStatusRequest;
use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    public function index(Request $request): View
    {
        $enquiries = $request->user()->boutique->enquiries()
            ->with('product')
            ->when($request->query('status'), fn ($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pages.dashboard.enquiries.index', compact('enquiries'));
    }

    public function show(Request $request, Enquiry $enquiry): View
    {
        abort_unless($enquiry->boutique_id === $request->user()->boutique_id, 403);

        $enquiry->load(['product', 'variant']);

        return view('pages.dashboard.enquiries.show', compact('enquiry'));
    }

    public function update(UpdateEnquiryStatusRequest $request, Enquiry $enquiry): RedirectResponse
    {
        abort_unless($enquiry->boutique_id === $request->user()->boutique_id, 403);

        $enquiry->status = $request->validated()['status'];
        $enquiry->save();

        return redirect()->route('account.enquiries.show', $enquiry)
            ->with('success', 'Booking request status updated.');
    }
}
