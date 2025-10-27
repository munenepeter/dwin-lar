<x-layouts.app>
    @include('commission-calculations.form', [
        'commissionCalculation' => null,
        'policies' => $policies,
        'agents' => $agents,
        'companies' => $companies,
        'commissionStructures' => $commissionStructures,
    ])
</x-layouts.app>
