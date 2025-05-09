<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\TkdnApplicationModel;

class Dashboard extends BaseController
{
    protected $tkdnModel;

    public function __construct()
    {
        $this->tkdnModel = new TkdnApplicationModel();
    }

    public function index()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        // Get statistics
        $data = [
            'title' => 'Dashboard',
            'total_applications' => $this->tkdnModel->countAll(),
            'pending_applications' => $this->tkdnModel->where('status', 'review')->countAllResults(),
            'approved_applications' => $this->tkdnModel->where('status', 'approved')->countAllResults(),
            'rejected_applications' => $this->tkdnModel->where('status', 'rejected')->countAllResults(),
            'recent_applications' => $this->tkdnModel->getRecentApplications()
        ];

        // Load the dashboard view
        return view('dashboard', $data);
    }
}
