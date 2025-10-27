<?php
$isEdit = isset($user) && $user !== null;
$formAction = $isEdit ? '/admin/users/edit/' . $user->id : '/admin/users/storeUser';
$dialogTitle = $isEdit ? 'Edit User' : 'Add New User';

// Default values for new user using stdClass
$user = $user ?? new stdClass();
$user->id = $user->id ?? '';
$user->username = $user->username ?? '';
$user->first_name = $user->first_name ?? '';
$user->last_name = $user->last_name ?? '';
$user->email = $user->email ?? '';
$user->phone = $user->phone ?? '';
$user->role_id = $user->role_id ?? '';
$user->employee_id = $user->employee_id ?? '';
$user->is_active = $user->is_active ?? true;

?>

<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-4"><?= $dialogTitle ?></h3>
    <form id="user-form" action="<?= $formAction ?>" method="POST" class="space-y-4 p-4 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($user->id) ?>">
        <?php endif; ?>
        <input type="hidden" name="signature" value="<?= md5(uniqid($user->id ?? "NEW")) ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" autocomplete="username" id="username" name="username" value="<?= htmlspecialchars($user->username) ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
            </div>
            <div>
                <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee ID</label>
                <input type="text" id="employee_id" name="employee_id" value="<?= htmlspecialchars($user->employee_id) ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" autocomplete="given-name" id="first_name" name="first_name" value="<?= htmlspecialchars($user->first_name) ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" autocomplete="family-name" id="last_name" name="last_name" value="<?= htmlspecialchars($user->last_name) ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" autocomplete="email" id="email" name="email" value="<?= htmlspecialchars($user->email) ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="tel" autocomplete="tel" id="phone" name="phone" value="<?= htmlspecialchars($user->phone) ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
            </div>
        </div>
        <?php if (!$isEdit): ?>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" autocomplete="new-password" id="password" name="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
            </div>
        <?php endif; ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="role_id" class="block text-sm font-medium text-gray-700">Role</label>
                <select id="role_id" name="role_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                    <option value="">Select Role</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= htmlspecialchars($role->id) ?>" <?= ($user->role_id == $role->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($role->role_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="is_active" class="block text-sm font-medium text-gray-700">Active Status</label>
                <select id="is_active" name="is_active" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
                    <option value="1" <?= $user->is_active ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= !$user->is_active ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <button type="button" class="close-dialog px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                <?= $isEdit ? 'Update User' : 'Create User' ?>
            </button>
        </div>
    </form>
</section>