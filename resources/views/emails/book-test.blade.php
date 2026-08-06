<x-mail::message>
# New Book a Test Request

<x-mail::table>
| Field | Details |
|:------|:--------|
| **Product** | {{ $productName }} |
| **Name** | {{ $customerName }} |
| **Email** | {{ $customerEmail }} |
@if($customerPhone)
| **Phone** | {{ $customerPhone }} |
@endif
</x-mail::table>

<x-mail::button :url="$productEditUrl">
View Product
</x-mail::button>

</x-mail::message>
