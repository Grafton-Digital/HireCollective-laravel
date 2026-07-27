<x-mail::message>
# New Collaboration Enquiry

<x-mail::table>
| Field | Details |
|:------|:--------|
| **Name** | {{ $name }} |
| **Email** | {{ $email }} |
@if($company)
| **Company / Brand** | {{ $company }} |
@endif
</x-mail::table>

## Message

{{ $enquiryMessage }}

<x-mail::button :url="config('app.url')">
Visit Site
</x-mail::button>

</x-mail::message>
