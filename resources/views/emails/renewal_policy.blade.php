blade
@component('mail::message')
# Policy Renewal Notification

Dear {{ $policyRenewal->originalPolicy->client->first_name }},

Your policy **{{ $policyRenewal->originalPolicy->policy_number }}** has been successfully renewed!

The new policy number is **{{ $policyRenewal->newPolicy->policy_number }}** and the renewal date is **{{ $policyRenewal->renewal_date->format('Y-m-d') }}**.

@component('mail::button', ['url' => url('/policies/' . $newPolicy->id)])
View New Policy Details
@endcomponent

Thank you for your continued trust in us.

Regards,
{{ config('app.name') }}
@endcomponent