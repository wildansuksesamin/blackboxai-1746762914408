<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-semibold text-gray-800">TKDN Applications</h1>
        <p class="text-gray-600">Manage your TKDN applications</p>
    </div>
    <a href="<?= base_url('applications/create') ?>" 
       class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
        <i class="fas fa-plus mr-2"></i>
        New Application
    </a>
</div>

<!-- Filters and Search -->
<div class="bg-white rounded-lg shadow mb-6 p-4">
    <div class="flex flex-col md:flex-row gap-4">
        <!-- Status Filter -->
        <div class="flex-1">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select id="status" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="draft">Draft</option>
                <option value="submitted">Submitted</option>
                <option value="review">Under Review</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        <!-- Search -->
        <div class="flex-1">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" id="search" 
                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                   placeholder="Search by company or product name...">
        </div>
    </div>
</div>

<!-- Applications Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Company
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Product
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    TKDN %
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Submission Date
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php if (isset($applications) && !empty($applications)) : ?>
                <?php foreach ($applications as $app) : ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                <?= esc($app['company_name']) ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <?= esc($app['product_name']) ?>
                            </div>
                            <div class="text-sm text-gray-500">
                                <?= substr(esc($app['product_description']), 0, 50) . '...' ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <?= number_format($app['tkdn_percentage'], 2) ?>%
                            </div>
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
                            <?= $app['submission_date'] ? date('d M Y', strtotime($app['submission_date'])) : '-' ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="<?= base_url('applications/view/' . $app['id']) ?>" 
                               class="text-blue-600 hover:text-blue-900 mr-3">
                                View
                            </a>
                            <?php if ($app['status'] === 'draft' && ($app['created_by'] === session()->get('id'))) : ?>
                                <a href="<?= base_url('applications/edit/' . $app['id']) ?>" 
                                   class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    Edit
                                </a>
                                <button onclick="submitApplication(<?= $app['id'] ?>)" 
                                        class="text-green-600 hover:text-green-900">
                                    Submit
                                </button>
                            <?php endif; ?>
                            
                            <?php if (($app['status'] === 'review') && 
                                    (session()->get('role') === 'admin' || session()->get('role') === 'super_admin')) : ?>
                                <button onclick="showApprovalModal(<?= $app['id'] ?>)" 
                                        class="text-green-600 hover:text-green-900 mr-3">
                                    Approve
                                </button>
                                <button onclick="showRejectionModal(<?= $app['id'] ?>)" 
                                        class="text-red-600 hover:text-red-900">
                                    Reject
                                </button>
                            <?php endif; ?>
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

<!-- Approval Modal -->
<div id="approvalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Approve Application</h3>
            <form id="approvalForm" method="POST">
                <div class="mb-4">
                    <label for="approvalNotes" class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                    <textarea id="approvalNotes" name="notes" rows="3" 
                              class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="hideApprovalModal()" 
                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded-lg">
                        Approve
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div id="rejectionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Application</h3>
            <form id="rejectionForm" method="POST">
                <div class="mb-4">
                    <label for="rejectionNotes" class="block text-sm font-medium text-gray-700 mb-1">Reason for Rejection <span class="text-red-500">*</span></label>
                    <textarea id="rejectionNotes" name="notes" rows="3" required
                              class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="hideRejectionModal()" 
                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg">
                        Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function submitApplication(id) {
    if (confirm('Are you sure you want to submit this application for review?')) {
        window.location.href = `<?= base_url('applications/submit/') ?>${id}`;
    }
}

function showApprovalModal(id) {
    document.getElementById('approvalModal').classList.remove('hidden');
    document.getElementById('approvalForm').action = `<?= base_url('applications/approve/') ?>${id}`;
}

function hideApprovalModal() {
    document.getElementById('approvalModal').classList.add('hidden');
}

function showRejectionModal(id) {
    document.getElementById('rejectionModal').classList.remove('hidden');
    document.getElementById('rejectionForm').action = `<?= base_url('applications/reject/') ?>${id}`;
}

function hideRejectionModal() {
    document.getElementById('rejectionModal').classList.add('hidden');
}

// Filter functionality
document.getElementById('status').addEventListener('change', function() {
    filterApplications();
});

document.getElementById('search').addEventListener('input', function() {
    filterApplications();
});

function filterApplications() {
    const status = document.getElementById('status').value.toLowerCase();
    const search = document.getElementById('search').value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const statusCell = row.querySelector('td:nth-child(4)');
        const companyCell = row.querySelector('td:nth-child(1)');
        const productCell = row.querySelector('td:nth-child(2)');

        if (!statusCell || !companyCell || !productCell) return;

        const statusText = statusCell.textContent.toLowerCase();
        const companyText = companyCell.textContent.toLowerCase();
        const productText = productCell.textContent.toLowerCase();

        const matchesStatus = !status || statusText.includes(status);
        const matchesSearch = !search || 
                            companyText.includes(search) || 
                            productText.includes(search);

        row.style.display = matchesStatus && matchesSearch ? '' : 'none';
    });
}
</script>
<?= $this->endSection() ?>
