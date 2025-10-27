<x-layouts.app>
    @include('commission-calculations.form', [
        'commissionCalculation' => $commissionCalculation,
        'policies' => $policies,
        'agents' => $agents,
        'companies' => $companies,
        'commissionStructures' => $commissionStructures,
    ])
</x-layouts.app>
