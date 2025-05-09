<?php

namespace App\Models;

use CodeIgniter\Model;

class TkdnApplicationModel extends Model
{
    protected $table = 'tkdn_applications';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'company_name',
        'product_name',
        'product_description',
        'tkdn_percentage',
        'status',
        'submission_date',
        'approval_date',
        'notes',
        'created_by',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'company_name' => 'required|min_length[3]|max_length[255]',
        'product_name' => 'required|min_length[3]|max_length[255]',
        'tkdn_percentage' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        'created_by' => 'required|integer'
    ];

    protected $validationMessages = [
        'company_name' => [
            'required' => 'Nama perusahaan harus diisi',
            'min_length' => 'Nama perusahaan minimal 3 karakter',
            'max_length' => 'Nama perusahaan maksimal 255 karakter'
        ],
        'product_name' => [
            'required' => 'Nama produk harus diisi',
            'min_length' => 'Nama produk minimal 3 karakter',
            'max_length' => 'Nama produk maksimal 255 karakter'
        ],
        'tkdn_percentage' => [
            'required' => 'Persentase TKDN harus diisi',
            'numeric' => 'Persentase TKDN harus berupa angka',
            'greater_than_equal_to' => 'Persentase TKDN minimal 0',
            'less_than_equal_to' => 'Persentase TKDN maksimal 100'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get recent applications with limit
     *
     * @param int $limit Number of records to return
     * @return array
     */
    public function getRecentApplications($limit = 5)
    {
        return $this->select('tkdn_applications.*, users.username as created_by_user')
                    ->join('users', 'users.id = tkdn_applications.created_by')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->find();
    }

    /**
     * Get applications by status
     *
     * @param string $status Status to filter by
     * @return array
     */
    public function getApplicationsByStatus($status)
    {
        return $this->where('status', $status)->findAll();
    }

    /**
     * Get applications by user
     *
     * @param int $userId User ID to filter by
     * @return array
     */
    public function getApplicationsByUser($userId)
    {
        return $this->where('created_by', $userId)->findAll();
    }

    /**
     * Submit application for review
     *
     * @param int $id Application ID
     * @return bool
     */
    public function submitForReview($id)
    {
        return $this->update($id, [
            'status' => 'review',
            'submission_date' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Approve application
     *
     * @param int $id Application ID
     * @param string $notes Approval notes
     * @return bool
     */
    public function approveApplication($id, $notes = '')
    {
        return $this->update($id, [
            'status' => 'approved',
            'approval_date' => date('Y-m-d H:i:s'),
            'notes' => $notes
        ]);
    }

    /**
     * Reject application
     *
     * @param int $id Application ID
     * @param string $notes Rejection reason
     * @return bool
     */
    public function rejectApplication($id, $notes)
    {
        return $this->update($id, [
            'status' => 'rejected',
            'approval_date' => date('Y-m-d H:i:s'),
            'notes' => $notes
        ]);
    }

    /**
     * Get application statistics
     *
     * @return array
     */
    public function getStatistics()
    {
        return [
            'total' => $this->countAll(),
            'draft' => $this->where('status', 'draft')->countAllResults(),
            'review' => $this->where('status', 'review')->countAllResults(),
            'approved' => $this->where('status', 'approved')->countAllResults(),
            'rejected' => $this->where('status', 'rejected')->countAllResults()
        ];
    }
}
