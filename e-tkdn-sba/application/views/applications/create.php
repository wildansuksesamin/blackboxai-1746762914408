<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Create New Application</h2>
            <p class="mt-1 text-sm text-gray-500">Fill in the details below to submit a new TKDN application.</p>
        </div>

        <?php echo form_open('applications/create', ['class' => 'space-y-6']); ?>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" name="company_name" id="company_name" 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm <?php echo form_error('company_name') ? 'border-red-300' : ''; ?>"
                           value="<?php echo set_value('company_name'); ?>" required>
                    <?php echo form_error('company_name', '<p class="mt-1 text-sm text-red-600">', '</p>'); ?>
                </div>

                <!-- Product Name -->
                <div>
                    <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" name="product_name" id="product_name" 
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm <?php echo form_error('product_name') ? 'border-red-300' : ''; ?>"
                           value="<?php echo set_value('product_name'); ?>" required>
                    <?php echo form_error('product_name', '<p class="mt-1 text-sm text-red-600">', '</p>'); ?>
                </div>

                <!-- TKDN Percentage -->
                <div>
                    <label for="tkdn_percentage" class="block text-sm font-medium text-gray-700">TKDN Percentage</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="number" name="tkdn_percentage" id="tkdn_percentage" 
                               class="block w-full px-3 py-2 pr-12 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm <?php echo form_error('tkdn_percentage') ? 'border-red-300' : ''; ?>"
                               value="<?php echo set_value('tkdn_percentage'); ?>"
                               min="0" max="100" step="0.01" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">%</span>
                        </div>
                    </div>
                    <?php echo form_error('tkdn_percentage', '<p class="mt-1 text-sm text-red-600">', '</p>'); ?>
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" id="percentage_bar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <div class="mt-1">
                    <textarea name="description" id="description" rows="4"
                              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm <?php echo form_error('description') ? 'border-red-300' : ''; ?>"
                              placeholder="Describe the product and its local content components..."
                    ><?php echo set_value('description'); ?></textarea>
                </div>
                <?php echo form_error('description', '<p class="mt-1 text-sm text-red-600">', '</p>'); ?>
                <p class="mt-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Brief description of the product and its local content components.
                </p>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="<?php echo site_url('applications'); ?>" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-arrow-left mr-2"></i> Back to List
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-paper-plane mr-2"></i> Submit Application
                </button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>

<!-- Preview Card -->
<div class="mt-6 bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900">
            <i class="fas fa-eye mr-2"></i> Application Preview
        </h3>
        <div class="mt-4 border rounded-lg p-4 bg-gray-50">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-gray-500">Company Name</p>
                    <p class="mt-1 text-sm text-gray-900" id="preview_company_name">-</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Product Name</p>
                    <p class="mt-1 text-sm text-gray-900" id="preview_product_name">-</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">TKDN Percentage</p>
                    <p class="mt-1 text-sm text-gray-900" id="preview_tkdn_percentage">-</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Description</p>
                    <p class="mt-1 text-sm text-gray-900" id="preview_description">-</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live preview functionality
    const fields = ['company_name', 'product_name', 'tkdn_percentage', 'description'];
    fields.forEach(field => {
        const input = document.getElementById(field);
        const preview = document.getElementById('preview_' + field);
        
        input.addEventListener('input', function() {
            preview.textContent = this.value || '-';
            if (field === 'tkdn_percentage' && this.value) {
                preview.textContent = this.value + '%';
                document.getElementById('percentage_bar').style.width = Math.min(100, Math.max(0, this.value)) + '%';
            }
        });
    });

    // Initialize percentage bar if there's an initial value
    const tkdnInput = document.getElementById('tkdn_percentage');
    if (tkdnInput.value) {
        document.getElementById('percentage_bar').style.width = Math.min(100, Math.max(0, tkdnInput.value)) + '%';
    }
});
</script>
