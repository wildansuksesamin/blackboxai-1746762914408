<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
    <p class="text-gray-600">Welcome back, <?= session()->get('full_name') ?? session()->get('username') ?></p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Applications -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                <i class="fas fa-file-alt text-blue-500 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Applications</p>
                <h3 class="text-2xl font-semibold text-gray-700"><?= $total_applications ?? 0 ?></h3>
            </div>
        </div>
    </div>

    <!-- Pending Applications -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-500 bg-opacity-10">
                <i class="fas fa-clock text-yellow-500 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Pending Review</p>
                <h3 class="text-2xl font-semibold text-gray-700"><?= $pending_applications ?? 0 ?></h3>
            </div>
        </div>
    </div>

    <!-- Approved Applications -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Approved</p>
                <h3 class="text-2xl font-semibold text-gray-700"><?= $approved_applications ?? 0 ?></h3>
            </div>
        </div>
    </div>

    <!-- Rejected Applications -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-500 bg-opacity-10">
                <i class="fas fa-times-circle text-red-500 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Rejected</p>
                <h3 class="text-2xl font-semibold text-gray-700"><?= $rejected_applications ?? 0 ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Recent Applications Table -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-700">Recent Applications</h2>
            <a href="<?= base_url('applications') ?>" class="text-blue-500 hover:text-blue-600 text-sm">
                View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TKDN %</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (isset($recent_applications) && !empty($recent_applications)) : ?>
                    <?php foreach ($recent_applications as $app) : ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= esc($app['company_name']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= esc($app['product_name']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= number_format($app['tkdn_percentage'], 2) ?>%</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $statusColors = [
                                    'draft' => 'gray',
                                    'submitted' => 'blue',
                                    'review' => 'yellow',
                                    'approved' => 'green',
                                    'rejected' => 'red'
                                ];
                                $color = $statusColors[$app['status']] ?? 'gray';
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-<?= $color ?>-100 text-<?= $color ?>-800">
                                    <?= ucfirst($app['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d M Y', strtotime($app['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="<?= base_url('applications/view/' . $app['id']) ?>" 
                                   class="text-blue-500 hover:text-blue-600">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No applications found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
