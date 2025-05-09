<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Application Details</h1>
            <p class="text-gray-600">View TKDN application information</p>
        </div>
        <div>
            <a href="<?= base_url('applications') ?>" 
               class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Applications
            </a>
        </div>
    </div>
</div>

<!-- Status Banner -->
<?php
$statusColors = [
    'draft' => 'gray',
    'submitted' => 'blue',
    'review' => 'yellow',
    'approved' => 'green',
    'rejected' => 'red'
];
$color = $statusColors[$application['status']] ?? 'gray';
?>
<div class="bg-<?= $color ?>-50 border-l-4 border-<?= $color ?>-500 p-4 mb-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-info-circle text-<?= $color ?>-500"></i>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-<?= $color ?>-800">
                Application Status: <?= ucfirst($application['status']) ?>
            </h3>
            <?php if ($application['status'] === 'rejected' && !empty($application['notes'])) : ?>
                <div class="mt-2 text-sm text-<?= $color ?>-700">
                    Rejection Reason: <?= esc($application['notes']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Application Details -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <!-- Company Information -->
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Company Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500">Company Name</label>
                <p class="mt-1 text-sm text-gray-900"><?= esc($application['company_name']) ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">Submission Date</label>
                <p class="mt-1 text-sm text-gray-900">
                    <?= $application['submission_date'] ? date('d M Y H:i', strtotime($application['submission_date'])) : '-' ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Product Information -->
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Product Information</h2>
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500">Product Name</label>
                <p class="mt-1 text-sm text-gray-900"><?= esc($application['product_name']) ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">Product Description</label>
                <p class="mt-1 text-sm text-gray-900 whitespace-pre-line"><?= esc($application['product_description']) ?></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">TKDN Percentage</label>
                <p class="mt-1 text-sm text-gray-900"><?= number_format($application['tkdn_percentage'], 2) ?>%</p>
            </div>
        </div>
    </div>

    <!-- Review Information -->
    <?php if ($application['status'] === 'approved' || $application['status'] === 'rejected') : ?>
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Review Information</h2>
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500">Review Date</label>
                <p class="mt-1 text-sm text-gray-900">
                    <?= date('d M Y H:i', strtotime($application['approval_date'])) ?>
                </p>
            </div>
            <?php if (!empty($application['notes'])) : ?>
            <div>
                <label class="block text-sm font-medium text-gray-500">Notes</label>
                <p class="mt-1 text-sm text-gray-900"><?= esc($application['notes']) ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Action Buttons -->
    <div class="p-6 bg-gray-50">
        <div class="flex justify-end space-x-3">
            <?php if ($application['status'] === 'draft' && ($application['created_by'] === session()->get('id'))) : ?>
                <a href="<?= base_url('applications/edit/' . $application['id']) ?>" 
                   class="px-4 py-2 text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                    Edit Application
                </a>
                <button onclick="submitApplication(<?= $application['id'] ?>)"
                        class="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                    Submit for Review
                </button>
            <?php endif; ?>

            <?php if ($application['status'] === 'review' && 
                    (session()->get('role') === 'admin' || session()->get('role') === 'super_admin')) : ?>
                <button onclick="showApprovalModal()"
                        class="px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded-lg">
                    Approve
                </button>
                <button onclick="showRejectionModal()"
                        class="px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg">
                    Reject
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Approval Modal -->
<div id="approvalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Approve Application</h3>
            <form action="<?= base_url('applications/approve/' . $application['id']) ?>" method="POST">
                <?= csrf_field() ?>
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
            <form action="<?= base_url('applications/reject/' . $application['id']) ?>" method="POST">
                <?= csrf_field() ?>
                <div class="mb-4">
                    <label for="rejectionNotes" class="block text-sm font-medium text-gray-700 mb-1">
                        Reason for Rejection <span class="text-red-500">*</span>
                    </label>
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
    if (confirm('Are you sure you want to submit this application for review? You won\'t be able to edit it after submission.')) {
        window.location.href = `<?= base_url('applications/submit/') ?>${id}`;
    }
}

function showApprovalModal() {
    document.getElementById('approvalModal').classList.remove('hidden');
}

function hideApprovalModal() {
    document.getElementById('approvalModal').classList.add('hidden');
}

function showRejectionModal() {
    document.getElementById('rejectionModal').classList.remove('hidden');
}

function hideRejectionModal() {
    document.getElementById('rejectionModal').classList.add('hidden');
}
</script>
<?= $this->endSection() ?>
