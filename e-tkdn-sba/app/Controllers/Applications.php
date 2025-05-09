<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\TkdnApplicationModel;

class Applications extends BaseController
{
    protected $tkdnModel;

    public function __construct()
    {
        $this->tkdnModel = new TkdnApplicationModel();
    }

    public function index()
    {
        $data = [
            'title' => 'TKDN Applications',
            'applications' => $this->tkdnModel->getApplicationsByUser(session()->get('id'))
        ];

        if (session()->get('role') === 'admin' || session()->get('role') === 'super_admin') {
            $data['applications'] = $this->tkdnModel->findAll();
        }

        return view('applications/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create New Application'
        ];

        return view('applications/create', $data);
    }

    public function store()
    {
        // Validate input
        $rules = [
            'company_name' => 'required|min_length[3]|max_length[255]',
            'product_name' => 'required|min_length[3]|max_length[255]',
            'product_description' => 'required',
            'tkdn_percentage' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Prepare data
        $data = [
            'company_name' => $this->request->getPost('company_name'),
            'product_name' => $this->request->getPost('product_name'),
            'product_description' => $this->request->getPost('product_description'),
            'tkdn_percentage' => $this->request->getPost('tkdn_percentage'),
            'status' => 'draft',
            'created_by' => session()->get('id')
        ];

        // Save application
        if ($this->tkdnModel->insert($data)) {
            return redirect()->to('applications')
                ->with('success', 'Application created successfully');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create application. Please try again.');
    }

    public function view($id)
    {
        $application = $this->tkdnModel->find($id);

        if (!$application) {
            return redirect()->to('applications')
                ->with('error', 'Application not found');
        }

        // Check if user has access to this application
        if (session()->get('role') !== 'admin' && 
            session()->get('role') !== 'super_admin' && 
            $application['created_by'] !== session()->get('id')) {
            return redirect()->to('applications')
                ->with('error', 'You do not have permission to view this application');
        }

        $data = [
            'title' => 'View Application',
            'application' => $application
        ];

        return view('applications/view', $data);
    }

    public function submit($id)
    {
        $application = $this->tkdnModel->find($id);

        if (!$application) {
            return redirect()->to('applications')
                ->with('error', 'Application not found');
        }

        // Check if user has access to submit this application
        if ($application['created_by'] !== session()->get('id')) {
            return redirect()->to('applications')
                ->with('error', 'You do not have permission to submit this application');
        }

        if ($this->tkdnModel->submitForReview($id)) {
            return redirect()->to('applications')
                ->with('success', 'Application submitted for review successfully');
        }

        return redirect()->back()
            ->with('error', 'Failed to submit application. Please try again.');
    }

    public function approve($id)
    {
        // Check if user has admin privileges
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'super_admin') {
            return redirect()->to('applications')
                ->with('error', 'You do not have permission to approve applications');
        }

        $notes = $this->request->getPost('notes');

        if ($this->tkdnModel->approveApplication($id, $notes)) {
            return redirect()->to('applications')
                ->with('success', 'Application approved successfully');
        }

        return redirect()->back()
            ->with('error', 'Failed to approve application. Please try again.');
    }

    public function reject($id)
    {
        // Check if user has admin privileges
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'super_admin') {
            return redirect()->to('applications')
                ->with('error', 'You do not have permission to reject applications');
        }

        $notes = $this->request->getPost('notes');

        if (!$notes) {
            return redirect()->back()
                ->with('error', 'Please provide rejection reason');
        }

        if ($this->tkdnModel->rejectApplication($id, $notes)) {
            return redirect()->to('applications')
                ->with('success', 'Application rejected successfully');
        }

        return redirect()->back()
            ->with('error', 'Failed to reject application. Please try again.');
    }
}
