<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-2xl font-semibold text-gray-800">Create New Application</h1>
    <p class="text-gray-600">Submit a new TKDN application for review</p>
</div>

<!-- Application Form -->
<div class="bg-white rounded-lg shadow-sm">
    <form action="<?= base_url('applications/store') ?>" method="POST" class="p-6">
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

        <!-- Company Information -->
        <div class="mb-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Company Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Company Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="company_name" 
                           name="company_name" 
                           value="<?= old('company_name') ?>"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                           required>
                </div>
            </div>
        </div>

        <!-- Product Information -->
        <div class="mb-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Product Information</h2>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Product Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="product_name" 
                           name="product_name" 
                           value="<?= old('product_name') ?>"
                           class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                           required>
                </div>

                <div>
                    <label for="product_description" class="block text-sm font-medium text-gray-700 mb-1">
                        Product Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="product_description" 
                              name="product_description" 
                              rows="4"
                              class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                              required><?= old('product_description') ?></textarea>
                    <p class="mt-1 text-sm text-gray-500">
                        Provide a detailed description of your product including its features and specifications.
                    </p>
                </div>

                <div class="max-w-xs">
                    <label for="tkdn_percentage" class="block text-sm font-medium text-gray-700 mb-1">
                        TKDN Percentage <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                               id="tkdn_percentage" 
                               name="tkdn_percentage" 
                               value="<?= old('tkdn_percentage') ?>"
                               min="0" 
                               max="100" 
                               step="0.01"
                               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-12" 
                               required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500">%</span>
                        </div>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                        Enter a value between 0 and 100
                    </p>
                </div>
            </div>
        </div>

        <!-- Supporting Documents -->
        <div class="mb-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Supporting Documents</h2>
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Document upload functionality will be available in the next phase. For now, please prepare the following documents:
                        </p>
                        <ul class="mt-2 text-sm text-blue-700 list-disc list-inside">
                            <li>Company Registration Certificate</li>
                            <li>Product Specifications</li>
                            <li>Manufacturing Process Documentation</li>
                            <li>Component Details and Sources</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3">
            <a href="<?= base_url('applications') ?>" 
               class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                Cancel
            </a>
            <button type="submit" 
                    class="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                Save as Draft
            </button>
        </div>
    </form>
</div>

<script>
// Client-side validation
document.querySelector('form').addEventListener('submit', function(e) {
    const tkdnPercentage = parseFloat(document.getElementById('tkdn_percentage').value);
    
    if (isNaN(tkdnPercentage) || tkdnPercentage < 0 || tkdnPercentage > 100) {
        e.preventDefault();
        alert('TKDN Percentage must be between 0 and 100');
        return false;
    }
    
    return true;
});
</script>
<?= $this->endSection() ?>
