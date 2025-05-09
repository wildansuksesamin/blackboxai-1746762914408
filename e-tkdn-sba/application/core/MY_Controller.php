<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    protected $data = array();
    
    public function __construct()
    {
        parent::__construct();
        
        // Load commonly used helpers
        $this->load->helper(array('url', 'form'));
        
        // Load commonly used libraries
        $this->load->library(array('session', 'form_validation'));
        
        // Set default title if not overridden in child controllers
        $this->data['title'] = 'E-TKDN SBA';
        
        // Set any site-wide JS or CSS here
        $this->data['css'] = array();
        $this->data['js'] = array();
    }
    
    protected function render($view, $layout = 'layout/admin_template')
    {
        if ($layout) {
            $this->load->view($layout, array_merge($this->data, array('content' => $view)));
        } else {
            $this->load->view($view, $this->data);
        }
    }
    
    protected function json_response($data, $status = 200)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($status)
            ->set_output(json_encode($data));
    }
}
