<?php

namespace App\Core;

use CodeIgniter\Config\DotEnv;
use CodeIgniter\Config\Services;
use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\URI;
use CodeIgniter\Router\RouteCollection;
use Config\App;
use Config\Cache;
use Config\View;
use Exception;

class CodeIgniter extends \CodeIgniter\CodeIgniter
{
    protected function initialize()
    {
        // Set default timezone on the server
        date_default_timezone_set(config(App::class)->appTimezone ?? 'UTC');

        // Setup Exception Handling
        Services::exceptions()->initialize();

        $this->initializeKint();

        if (! CI_DEBUG) {
            // In production, we want errors to be logged instead of displayed
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        }

        // Initialize our Request and Response objects
        $this->request  = Services::request();
        $this->response = Services::response();

        // Initialize the URI
        $this->detectURI($this->request->getMethod(), $this->request->getServer('SCRIPT_NAME'));

        // Initialize our Router
        $this->router = Services::router($this->request);

        // Initialize the Security class
        Services::security();

        $this->benchmark = Services::timer();
        $this->benchmark->start('total_execution');
        $this->benchmark->start('bootstrap');

        return $this;
    }

    protected function detectURI(string $protocol, ?string $baseURL): void
    {
        $uri = new URI();

        // Set the base URL automatically if none was provided
        if (empty($baseURL)) {
            $baseURL = $this->request->detectPath();
        }

        // If we're using a CLI command, ignore the URI
        if (is_cli()) {
            $uri->setPath(URI::createURIString());
            return;
        }

        $uri->setPath(URI::createURIString(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        ));

        // Let's try to ensure that we have something usable
        if (empty($uri->getPath())) {
            $uri->setPath('/');
        }

        $this->request->setUri($uri);
    }
}
