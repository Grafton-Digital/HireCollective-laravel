<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEnquiryStatusRequest;
use App\Models\Enquiry;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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

        $newStatus = $request->validated()['status'];
        $enquiry->status = $newStatus;
        $enquiry->save();

        if ($newStatus === 'confirmed' && $enquiry->desired_dates && $enquiry->product) {
            $result = $this->applyDatesToProduct($enquiry);

            if ($result['conflicts']) {
                return redirect()->route('account.enquiries.show', $enquiry)
                    ->with('success', 'Booking confirmed.')
                    ->with('date_warning', 'Some dates were already marked as unavailable: '.implode(', ', $result['conflicts']).'. The remaining dates have been added.');
            }

            return redirect()->route('account.enquiries.show', $enquiry)
                ->with('success', 'Booking confirmed. Dates have been automatically marked as unavailable on the product.');
        }

        return redirect()->route('account.enquiries.show', $enquiry)
            ->with('success', 'Booking request status updated.');
    }

    /**
     * @return array{conflicts: string[]}
     */
    private function applyDatesToProduct(Enquiry $enquiry): array
    {
        $dates = $this->parseDateRange($enquiry->desired_dates);

        if (empty($dates)) {
            return ['conflicts' => []];
        }

        $product = $enquiry->product;
        $availability = $product->availability ?? [];
        $conflicts = [];

        foreach ($dates as $date) {
            if (isset($availability[$date]) && $availability[$date] === 'unavailable') {
                $conflicts[] = $date;
            } else {
                $availability[$date] = 'unavailable';
            }
        }

        $product->availability = $availability;
        $product->save();

        return ['conflicts' => $conflicts];
    }

    /**
     * @return string[]
     */
    private function parseDateRange(string $desiredDates): array
    {
        if (! str_contains($desiredDates, ' to ')) {
            return [];
        }

        [$startStr, $endStr] = explode(' to ', $desiredDates, 2);

        try {
            $start = Carbon::parse(trim($startStr));
            $end = Carbon::parse(trim($endStr));
        } catch (\Exception) {
            return [];
        }

        $dates = [];
        foreach (CarbonPeriod::create($start, $end) as $day) {
            $dates[] = $day->format('Y-m-d');
        }

        return $dates;
    }
}
