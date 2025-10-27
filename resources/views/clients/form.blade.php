<div class="p-4">
    <h3 class="text-xl font-medium text-gray-900 mb-5">{{ isset($client) ? 'Edit Client' : 'Create New Client' }}</h3>
    <form id="clientForm" method="POST" action="{{ isset($client) ? route('clients.update', $client) : route('clients.store') }}">
        @csrf
        @if(isset($client))
        @method('PUT')
        @endif

        <!-- Basic Information -->
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First Name <span class="text-red-500">*</span></label>
                <input type="text" name="first_name" id="first_name"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    placeholder="John"
                    value="{{ old('first_name', $client->first_name ?? '') }}"
                    required>
                @error('first_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Last Name <span class="text-red-500">*</span></label>
                <input type="text" name="last_name" id="last_name"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    placeholder="Doe"
                    value="{{ old('last_name', $client->last_name ?? '') }}"
                    required>
                @error('last_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="id_number" class="block mb-2 text-sm font-medium text-gray-900">ID Number</label>
                <input type="text" name="id_number" id="id_number"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    placeholder="12345678"
                    value="{{ old('id_number', $client->id_number ?? '') }}">
                @error('id_number')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="date_of_birth" class="block mb-2 text-sm font-medium text-gray-900">Date of Birth</label>
                <input type="date" name="date_of_birth" id="date_of_birth"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    value="{{ old('date_of_birth', $client->date_of_birth ?? '') }}">
                @error('date_of_birth')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="gender" class="block mb-2 text-sm font-medium text-gray-900">Gender</label>
                <select id="gender" name="gender"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
                    <option value="">Select Gender</option>
                    <option value="MALE" {{ old('gender', $client->gender ?? '') === 'MALE' ? 'selected' : '' }}>Male</option>
                    <option value="FEMALE" {{ old('gender', $client->gender ?? '') === 'FEMALE' ? 'selected' : '' }}>Female</option>
                    <option value="OTHER" {{ old('gender', $client->gender ?? '') === 'OTHER' ? 'selected' : '' }}>Other</option>
                </select>
                @error('gender')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Contact Information -->
        <div class="grid grid-cols-6 gap-6 mt-6">
            <div class="col-span-6 sm:col-span-3">
                <label for="phone_primary" class="block mb-2 text-sm font-medium text-gray-900">Primary Phone <span class="text-red-500">*</span></label>
                <input type="text" name="phone_primary" id="phone_primary"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    placeholder="+254..."
                    value="{{ old('phone_primary', $client->phone_primary ?? '') }}"
                    required>
                @error('phone_primary')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="phone_secondary" class="block mb-2 text-sm font-medium text-gray-900">Secondary Phone</label>
                <input type="text" name="phone_secondary" id="phone_secondary"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    placeholder="+254..."
                    value="{{ old('phone_secondary', $client->phone_secondary ?? '') }}">
                @error('phone_secondary')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-6">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <input type="email" name="email" id="email"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    placeholder="john.doe@example.com"
                    value="{{ old('email', $client->email ?? '') }}">
                @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-6">
                <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Address</label>
                <textarea name="address" id="address" rows="3"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    placeholder="123 Main St">{{ old('address', $client->address ?? '') }}</textarea>
                @error('address')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="city" class="block mb-2 text-sm font-medium text-gray-900">City</label>
                <input type="text" name="city" id="city"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    placeholder="Nairobi"
                    value="{{ old('city', $client->city ?? '') }}">
                @error('city')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="county" class="block mb-2 text-sm font-medium text-gray-900">County</label>
                <input type="text" name="county" id="county"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    placeholder="Nairobi"
                    value="{{ old('county', $client->county ?? '') }}">
                @error('county')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Other Information -->
        <div class="grid grid-cols-6 gap-6 mt-6">
            <div class="col-span-6 sm:col-span-3">
                <label for="assigned_agent_id" class="block mb-2 text-sm font-medium text-gray-900">Assigned Agent</label>
                <select id="assigned_agent_id" name="assigned_agent_id"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
                    <option value="">Select Agent</option>
                    @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" {{ old('assigned_agent_id', $client->assigned_agent_id ?? '') == $agent->id ? 'selected' : '' }}>
                        {{ $agent->first_name }} {{ $agent->last_name }}
                    </option>
                    @endforeach
                </select>
                @error('assigned_agent_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="client_status" class="block mb-2 text-sm font-medium text-gray-900">Client Status <span class="text-red-500">*</span></label>
                <select id="client_status" name="client_status"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    required>
                    <option value="ACTIVE" {{ old('client_status', $client->client_status ?? 'ACTIVE') === 'ACTIVE' ? 'selected' : '' }}>Active</option>
                    <option value="INACTIVE" {{ old('client_status', $client->client_status ?? '') === 'INACTIVE' ? 'selected' : '' }}>Inactive</option>
                    <option value="SUSPENDED" {{ old('client_status', $client->client_status ?? '') === 'SUSPENDED' ? 'selected' : '' }}>Suspended</option>
                </select>
                @error('client_status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-6">
                <label for="notes" class="block mb-2 text-sm font-medium text-gray-900">Notes</label>
                <textarea name="notes" id="notes" rows="3"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    placeholder="Any relevant notes about the client...">{{ old('notes', $client->notes ?? '') }}</textarea>
                @error('notes')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end mt-6">
            <button type="button" class="close-dialog text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 mr-4">
                Cancel
            </button>
            <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Save Client
            </button>
        </div>
    </form>
</div>

<script>
    document.querySelectorAll('.close-dialog').forEach(button => {
        button.addEventListener('click', function() {
            const dialog = this.closest('dialog');
            if (dialog) {
                dialog.close();
            }
        });
    });

    document.getElementById('clientForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const form = this;
        const formData = new FormData(form);
        const actionUrl = form.getAttribute('action');

        fetch(actionUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    form.closest('dialog').close();
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Form submission error:', error);
                alert('An error occurred during form submission.');
            });
    });
</script>