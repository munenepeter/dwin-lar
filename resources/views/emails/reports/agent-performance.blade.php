@component('mail::message')
# Agent Performance Report

Dear Recipient,

Attached is the Agent Performance Report for {{ $agentName }} covering the period from {{ $startDate }} to {{ $endDate }}.

If you have any questions, please contact us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent