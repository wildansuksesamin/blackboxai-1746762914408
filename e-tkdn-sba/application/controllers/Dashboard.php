<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

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
        $this->data['title'] = 'Dashboard';
        
        // Get statistics
        $this->data['total_applications'] = $this->tkdnapplication_model->count_all();
        $this->data['pending_applications'] = $this->tkdnapplication_model->count_by_status('pending');
        $this->data['approved_applications'] = $this->tkdnapplication_model->count_by_status('approved');
        $this->data['rejected_applications'] = $this->tkdnapplication_model->count_by_status('rejected');
        
        // Get recent applications
        $this->data['recent_applications'] = $this->tkdnapplication_model->get_recent(5);
        
        $this->render('dashboard');
    }
}
