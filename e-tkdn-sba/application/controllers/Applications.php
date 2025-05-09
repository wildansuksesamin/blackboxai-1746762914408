<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Applications extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tkdnapplication_model');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $this->data['title'] = 'Applications';
        $this->data['applications'] = $this->tkdnapplication_model->get_all();
        $this->render('applications/index');
    }

    public function create()
    {
        $this->data['title'] = 'Create Application';

        $this->form_validation->set_rules('company_name', 'Company Name', 'required|trim');
        $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim');
        $this->form_validation->set_rules('tkdn_percentage', 'TKDN Percentage', 'required|numeric|greater_than[0]|less_than[101]');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->render('applications/create');
        } else {
            $data = array(
                'company_name' => $this->input->post('company_name', TRUE),
                'product_name' => $this->input->post('product_name', TRUE),
                'tkdn_percentage' => $this->input->post('tkdn_percentage', TRUE),
                'description' => $this->input->post('description', TRUE),
                'status' => 'pending',
                'user_id' => $this->session->userdata('user_id')
            );

            if ($this->tkdnapplication_model->insert($data)) {
                $this->session->set_flashdata('success', 'Application created successfully.');
                redirect('applications');
            } else {
                $this->session->set_flashdata('error', 'Error creating application.');
                redirect('applications/create');
            }
        }
    }

    public function view($id)
    {
        $this->data['title'] = 'View Application';
        $this->data['application'] = $this->tkdnapplication_model->get_by_id($id);
        
        if (!$this->data['application']) {
            show_404();
        }

        // Check if user has access to this application
        if ($this->session->userdata('role') !== 'admin' && 
            $this->session->userdata('user_id') !== $this->data['application']->user_id) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('applications');
        }

        $this->render('applications/view');
    }

    public function edit($id)
    {
        // Only admin can edit applications
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Access denied. Admin privileges required.');
            redirect('applications');
        }

        $this->data['title'] = 'Edit Application';
        $this->data['application'] = $this->tkdnapplication_model->get_by_id($id);
        
        if (!$this->data['application']) {
            show_404();
        }

        $this->form_validation->set_rules('company_name', 'Company Name', 'required|trim');
        $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim');
        $this->form_validation->set_rules('tkdn_percentage', 'TKDN Percentage', 'required|numeric|greater_than[0]|less_than[101]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[pending,approved,rejected]');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->render('applications/edit');
        } else {
            $data = array(
                'company_name' => $this->input->post('company_name', TRUE),
                'product_name' => $this->input->post('product_name', TRUE),
                'tkdn_percentage' => $this->input->post('tkdn_percentage', TRUE),
                'description' => $this->input->post('description', TRUE),
                'status' => $this->input->post('status', TRUE)
            );

            if ($this->tkdnapplication_model->update($id, $data)) {
                $this->session->set_flashdata('success', 'Application updated successfully.');
                redirect('applications');
            } else {
                $this->session->set_flashdata('error', 'Error updating application.');
                redirect('applications/edit/' . $id);
            }
        }
    }

    public function delete($id)
    {
        // Only admin can delete applications
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Access denied. Admin privileges required.');
            redirect('applications');
        }

        $application = $this->tkdnapplication_model->get_by_id($id);
        
        if (!$application) {
            show_404();
        }

        if ($this->tkdnapplication_model->delete($id)) {
            $this->session->set_flashdata('success', 'Application deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error deleting application.');
        }

        redirect('applications');
    }
}
