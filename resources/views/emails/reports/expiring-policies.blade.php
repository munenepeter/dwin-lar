@component('mail::message')
# Expiring Policies Report

Dear Recipient,

Attached is the Expiring Policies Report for policies expiring within {{ $daysAhead }} days.

If you have any questions, please contact us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent