<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCollaborationRequest;
use App\Mail\CollaborationEnquiryMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class CollaborationController extends Controller
{
    public function store(StoreCollaborationRequest $request): JsonResponse
    {
        Mail::to(config('app.admin_email'))->send(new CollaborationEnquiryMail(
            name: $request->validated('name'),
            email: $request->validated('email'),
            company: $request->validated('company'),
            enquiryMessage: $request->validated('message'),
        ));

        return response()->json(['message' => 'Enquiry sent successfully.']);
    }
}
