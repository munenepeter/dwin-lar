@php
    $isEdit = isset($policyType) && $policyType !== null;
    $formAction = $isEdit
        ? route('policy-types.update', $policyType)
        : route('policy-types.store');
    $dialogTitle = $isEdit ? 'Edit Policy Type' : 'Add New Policy Type';
    $policyType = $policyType ?? (object) [
        'id' => '',
        'type_name' => '',
        'description' => '',
        'is_active' => true,
    ];
@endphp

<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-4">{{ $dialogTitle }}</h3>
    <form id="policy-type-form" action="{{ $formAction }}" method="POST"
        class="space-y-4 p-4 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div>
            <label for="type_name" class="block text-sm font-medium text-gray-700">Type Name</label>
            <input type="text" id="type_name" name="type_name"
                value="{{ $policyType->type_name }}"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                required>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" rows="4"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">{{ $policyType->description }}</textarea>
        </div>

        <div>
            <label for="is_active" class="block text-sm font-medium text-gray-700">Active Status</label>
            <select id="is_active" name="is_active"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
                <option value="1" {{ $policyType->is_active ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$policyType->is_active ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <button type="button"
                class="close-dialog px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                {{ $isEdit ? 'Update Policy Type' : 'Create Policy Type' }}
            </button>
        </div>
    </form>
</section>
