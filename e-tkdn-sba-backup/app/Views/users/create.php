<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Create New User</h1>
            <p class="text-gray-600">Add a new user to the system</p>
        </div>
        <a href="<?= base_url('users') ?>" 
           class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Users
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <form action="<?= base_url('users/store') ?>" method="POST" class="p-6">
        <?= csrf_field() ?>

        <!-- Error Messages -->
        <?php if (session()->has('errors')) : ?>
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc list-inside">
                                <?php foreach (session('errors') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Basic Information -->
        <div class="mb-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="full_name" 
                           name="full_name" 
                           value="<?= old('full_name') ?>"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                           required>
                    <p class="mt-1 text-sm text-gray-500">Enter the user's full name</p>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select id="role" 
                            name="role" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                            required>
                        <option value="">Select a role</option>
                        <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Administrator</option>
                        <option value="staff" <?= old('role') === 'staff' ? 'selected' : '' ?>>Staff</option>
                        <option value="user" <?= old('role') === 'user' ? 'selected' : '' ?>>Regular User</option>
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Select the user's role and permissions level</p>
                </div>
            </div>
        </div>

        <!-- Account Credentials -->
        <div class="mb-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Account Credentials</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           value="<?= old('username') ?>"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                           required>
                    <p class="mt-1 text-sm text-gray-500">Choose a unique username</p>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="<?= old('email') ?>"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                           required>
                    <p class="mt-1 text-sm text-gray-500">Enter a valid email address</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                           required>
                    <p class="mt-1 text-sm text-gray-500">Minimum 6 characters</p>
                </div>

                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="confirm_password" 
                           name="confirm_password" 
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                           required>
                    <p class="mt-1 text-sm text-gray-500">Re-enter the password</p>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3">
            <button type="button" 
                    onclick="window.location.href='<?= base_url('users') ?>'" 
                    class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                Cancel
            </button>
            <button type="submit" 
                    class="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                Create User
            </button>
        </div>
    </form>
</div>

<script>
// Client-side validation
document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match');
        return false;
    }
    
    if (password.length < 6) {
        e.preventDefault();
        alert('Password must be at least 6 characters long');
        return false;
    }
    
    return true;
});

// Username validation
document.getElementById('username').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^a-zA-Z0-9_]/g, '');
});
</script>
<?= $this->endSection() ?>
