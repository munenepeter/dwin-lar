<!-- resources/views/policies/forms/_policy_type_form.blade.php (converted to Blade; not directly used in PolicyController, but for completeness if you have PolicyTypeController) -->
@php
    $isEdit = isset($policyType) && $policyType !== null;
    $formAction = $isEdit ? '/admin/policies/updatePolicyType' : '/admin/policies/storePolicyType'; // Adjust routes as needed
    $dialogTitle = $isEdit ? 'Edit Policy Type' : 'Add New Policy Type';

    // Default values
    $policyType = $policyType ?? (object)[
        'id' => '',
        'type_name' => '',
        'description' => ''
    ];
@endphp

<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden h-full">
    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-4">{{ $dialogTitle }}</h3>
    <div class="mt-6 p-6 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        <form action="{{ $formAction }}" method="POST" class="space-y-4">
            @csrf
            @if ($isEdit)
                @method('PATCH')
                <input type="hidden" name="id" value="{{ $policyType->id }}">
            @endif

            <div>
                <label for="type_name" class="block text-sm font-medium text-gray-700">Policy Type Name</label>
                <input type="text" id="type_name" name="type_name" value="{{ $policyType->type_name }}"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="3"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">{{ $policyType->description ?? '' }}</textarea>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" class="close-dialog px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    {{ $isEdit ? 'Update Policy Type' : 'Create Policy Type' }}
                </button>
            </div>
        </form>
    </div>
</section>