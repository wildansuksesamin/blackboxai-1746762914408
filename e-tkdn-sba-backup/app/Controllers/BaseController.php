<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = [];
    protected $session;
    protected $db;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Load helpers
        helper(['form', 'url']);

        // Initialize session
        $this->session = \Config\Services::session();

        // Initialize database
        $this->db = \Config\Database::connect();

        // Set default timezone
        date_default_timezone_set('Asia/Jakarta');
    }

    protected function getCurrentTime()
    {
        return date('Y-m-d H:i:s');
    }

    protected function formatDate($date)
    {
        if (!$date) return '';
        return date('Y-m-d', strtotime($date));
    }

    protected function formatDateTime($datetime)
    {
        if (!$datetime) return '';
        return date('Y-m-d H:i:s', strtotime($datetime));
    }
}
