@php
    $isEdit = isset($insurance_company) && $insurance_company !== null;
    $formAction = $isEdit
        ? route('insurance-companies.update', $insurance_company)
        : route('insurance-companies.store');
    $dialogTitle = $isEdit ? 'Edit Insurance Company' : 'Add New Insurance Company';

    // Default values for new insurance company
    $insurance_company =
        $insurance_company ??
        (object) [
            'id' => '',
            'company_name' => '',
            'company_code' => '',
            'contact_person' => '',
            'email' => '',
            'phone' => '',
            'city' => '',
            'postal_code' => '',
            'country' => 'Kenya',
            'website' => '',
            'is_active' => true,
        ];
@endphp

<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-4">{{ $dialogTitle }}</h3>
    <form id="insurance-company-form" action="{{ $formAction }}" method="POST"
        class="space-y-4 p-4 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif
        <input type="hidden" name="signature" value="{{ md5(uniqid($insurance_company->id ?? 'NEW')) }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                <input type="text" id="company_name" name="company_name"
                    value="{{ $insurance_company->company_name }}"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    required>
            </div>
            <div>
                <label for="company_code" class="block text-sm font-medium text-gray-700">Company Code</label>
                <input type="text" id="company_code" name="company_code"
                    value="{{ $insurance_company->company_code }}"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    required>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="contact_person" class="block text-sm font-medium text-gray-700">Contact Person</label>
                <input type="text" autocomplete="name" id="contact_person" name="contact_person"
                    value="{{ $insurance_company->contact_person }}"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" autocomplete="email" id="email" name="email"
                    value="{{ $insurance_company->email }}"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="tel" autocomplete="tel" id="phone" name="phone"
                    value="{{ $insurance_company->phone }}"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
            </div>
            <div>
                <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                <input type="url" autocomplete="url" id="website" name="website"
                    value="{{ $insurance_company->website }}"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                <input type="text" autocomplete="address-level2" id="city" name="city"
                    value="{{ $insurance_company->city }}"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
            </div>
            <div>
                <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                <input type="text" autocomplete="postal-code" id="postal_code" name="postal_code"
                    value="{{ $insurance_company->postal_code }}"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                <input type="text" autocomplete="country-name" id="country" name="country"
                    value="{{ $insurance_company->country }}"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
            </div>
            <div>
                <label for="is_active" class="block text-sm font-medium text-gray-700">Active Status</label>
                <select id="is_active" name="is_active"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
                    <option value="1" {{ $insurance_company->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$insurance_company->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <button type="button"
                class="close-dialog px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                {{ $isEdit ? 'Update Insurance Company' : 'Create Insurance Company' }}
            </button>
        </div>
    </form>
</section>

<script>
    // JS validation remains as client-side enhancement.
    window.initializeInsuranceCompanyForm = function() {
        const insuranceCompanyForm = document.getElementById('insurance-company-form');

        insuranceCompanyForm.addEventListener('submit', (event) => {
            // Form validation
            const formData = new FormData(event.target);
            const company = {};
            for (const [key, value] of formData.entries()) {
                company[key] = value;
            }
            const errors = validateInsuranceCompany(company);
            if (Object.keys(errors).length > 0) {
                event.preventDefault();
                const inputs = insuranceCompanyForm.elements;
                for (const input of inputs) {
                    if (errors[input.name]) {
                        input.setCustomValidity(errors[input.name]);
                        input.reportValidity();
                    } else {
                        input.setCustomValidity('');
                    }
                }
            }
        });

        function validateInsuranceCompany(company) {
            const errors = {};
            if (!company.company_name) {
                errors.company_name = 'Company name is required';
            } else if (company.company_name.length > 100) {
                errors.company_name = 'Company name must be 100 characters or less';
            }
            if (!company.company_code) {
                errors.company_code = 'Company code is required';
            } else if (company.company_code.length > 20) {
                errors.company_code = 'Company code must be 20 characters or less';
            }
            if (company.contact_person && company.contact_person.length > 100) {
                errors.contact_person = 'Contact person must be 100 characters or less';
            }
            if (company.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(company.email)) {
                errors.email = 'Invalid email format';
            } else if (company.email && company.email.length > 100) {
                errors.email = 'Email must be 100 characters or less';
            }
            if (company.phone && !/^\+?[\d\s-]{7,20}$/.test(company.phone)) {
                errors.phone = 'Invalid phone number format';
            }
            if (company.city && company.city.length > 50) {
                errors.city = 'City must be 50 characters or less';
            }
            if (company.postal_code && company.postal_code.length > 20) {
                errors.postal_code = 'Postal code must be 20 characters or less';
            }
            if (company.country && company.country.length > 50) {
                errors.country = 'Country must be 50 characters or less';
            }
            if (company.website && !/^(https?:\/\/)?[\w\-]+(\.[\w\-]+)+[/#?]?.*$/.test(company.website)) {
                errors.website = 'Invalid URL format';
            } else if (company.website && company.website.length > 255) {
                errors.website = 'Website URL must be 255 characters or less';
            }
            return errors;
        }
    };
</script>
