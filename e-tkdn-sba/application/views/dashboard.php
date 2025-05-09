<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Application Statistics</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Total Applications -->
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-file-alt text-2xl text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-blue-900">Total Applications</h3>
                        <p class="mt-1 text-2xl font-semibold text-blue-600"><?php echo $total_applications; ?></p>
                    </div>
                </div>
            </div>

            <!-- Pending Applications -->
            <div class="bg-yellow-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock text-2xl text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-yellow-900">Pending</h3>
                        <p class="mt-1 text-2xl font-semibold text-yellow-600"><?php echo $pending_applications; ?></p>
                    </div>
                </div>
            </div>

            <!-- Approved Applications -->
            <div class="bg-green-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-2xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-green-900">Approved</h3>
                        <p class="mt-1 text-2xl font-semibold text-green-600"><?php echo $approved_applications; ?></p>
                    </div>
                </div>
            </div>

            <!-- Rejected Applications -->
            <div class="bg-red-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-times-circle text-2xl text-red-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-red-900">Rejected</h3>
                        <p class="mt-1 text-2xl font-semibold text-red-600"><?php echo $rejected_applications; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Applications -->
<div class="mt-8 bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Recent Applications</h2>
            <a href="<?php echo site_url('applications'); ?>" class="text-sm text-indigo-600 hover:text-indigo-900">
                View all <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <?php if (!empty($recent_applications)): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($recent_applications as $app): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $app->id; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $app->company_name; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $status_colors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'approved' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800'
                                ];
                                $color = isset($status_colors[$app->status]) ? $status_colors[$app->status] : 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $color; ?>">
                                    <?php echo ucfirst($app->status); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo date('d M Y', strtotime($app->created_at)); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="<?php echo site_url('applications/view/'.$app->id); ?>" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    View <i class="fas fa-eye ml-1"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-4">No recent applications found.</p>
        <?php endif; ?>
    </div>
</div>
