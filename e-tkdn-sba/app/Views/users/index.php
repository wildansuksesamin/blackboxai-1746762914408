<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-semibold text-gray-800">User Management</h1>
        <p class="text-gray-600">Manage system users and their access levels</p>
    </div>
    <a href="<?= base_url('users/create') ?>" 
       class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
        <i class="fas fa-user-plus mr-2"></i>
        Add New User
    </a>
</div>

<!-- Flash Messages -->
<?php if (session()->has('success')) : ?>
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-500"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700"><?= session('success') ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->has('error')) : ?>
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700"><?= session('error') ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Users Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-900">System Users</h2>
            
            <!-- Search Box -->
            <div class="relative">
                <input type="text" 
                       id="searchInput" 
                       placeholder="Search users..." 
                       class="w-64 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        User
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Last Login
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-500"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= esc($user['full_name']) ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= esc($user['email']) ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                            $roleColors = [
                                'super_admin' => 'purple',
                                'admin' => 'indigo',
                                'staff' => 'blue',
                                'user' => 'gray'
                            ];
                            $color = $roleColors[$user['role']] ?? 'gray';
                            ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-<?= $color ?>-100 text-<?= $color ?>-800">
                                <?= ucfirst($user['role']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if ($user['is_active']) : ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            <?php else : ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= $user['last_login'] ? date('d M Y H:i', strtotime($user['last_login'])) : 'Never' ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <?php if ($user['id'] != session()->get('id')) : ?>
                                <a href="<?= base_url('users/edit/' . $user['id']) ?>" 
                                   class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    Edit
                                </a>
                                <button onclick="toggleUserStatus(<?= $user['id'] ?>, '<?= $user['is_active'] ? 'deactivate' : 'activate' ?>')"
                                        class="text-blue-600 hover:text-blue-900 mr-3">
                                    <?= $user['is_active'] ? 'Deactivate' : 'Activate' ?>
                                </button>
                                <button onclick="confirmDelete(<?= $user['id'] ?>, '<?= esc($user['username']) ?>')"
                                        class="text-red-600 hover:text-red-900">
                                    Delete
                                </button>
                            <?php else : ?>
                                <span class="text-gray-400">Current User</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchText = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const name = row.querySelector('td:first-child').textContent.toLowerCase();
        const email = row.querySelector('td:first-child .text-gray-500').textContent.toLowerCase();
        const role = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        
        if (name.includes(searchText) || email.includes(searchText) || role.includes(searchText)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Delete confirmation
function confirmDelete(userId, username) {
    if (confirm(`Are you sure you want to delete user "${username}"? This action cannot be undone.`)) {
        window.location.href = `<?= base_url('users/delete/') ?>${userId}`;
    }
}

// Toggle user status
function toggleUserStatus(userId, action) {
    if (confirm(`Are you sure you want to ${action} this user?`)) {
        window.location.href = `<?= base_url('users/toggleStatus/') ?>${userId}`;
    }
}
</script>
<?= $this->endSection() ?>
