<x-mail::message>
# New Boutique Application

**{{ $boutique->name }}** has submitted an application.

<x-mail::table>
| Field | Details |
|:------|:--------|
| **Boutique Name** | {{ $boutique->name }} |
| **Region** | {{ $boutique->county }} |
| **Contact Email** | {{ $boutique->contact_email }} |
@if($boutique->phone)
| **Phone** | {{ $boutique->phone }} |
@endif
@if($boutique->city)
| **City** | {{ $boutique->city }} |
@endif
</x-mail::table>

<x-mail::button :url="url('/admin/boutique-enquiries')">
Review Application
</x-mail::button>

Please review and approve or reject this application.

</x-mail::message>
