<x-mail::message>
# New Booking Request

<x-mail::table>
| Field | Details |
|:------|:--------|
| **Product** | {{ $enquiry->product->name }} |
| **Name** | {{ $enquiry->customer_name }} |
| **Email** | {{ $enquiry->customer_email }} |
@if($enquiry->customer_phone)
| **Phone** | {{ $enquiry->customer_phone }} |
@endif
@if($enquiry->desired_dates)
| **Dates** | {{ $enquiry->desired_dates }} |
@endif
</x-mail::table>

@if($enquiry->message)
## Message

{{ $enquiry->message }}
@endif

<x-mail::button :url="route('account.products.edit', $enquiry->product)">
View Product
</x-mail::button>

</x-mail::message>
