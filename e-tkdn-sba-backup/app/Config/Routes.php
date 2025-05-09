<?php

namespace Config;

// Create a new instance of our RouteCollection class.
use CodeIgniter\Router\RouteCollection;

$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Authentication Routes
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::login');
$routes->post('auth/authenticate', 'Auth::authenticate');
$routes->get('logout', 'Auth::logout');

// Protected Routes (require authentication)
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');
    
    // TKDN Applications
    $routes->group('applications', function($routes) {
        $routes->get('/', 'Applications::index');
        $routes->get('create', 'Applications::create');
        $routes->post('store', 'Applications::store');
        $routes->get('view/(:num)', 'Applications::view/$1');
        $routes->get('edit/(:num)', 'Applications::edit/$1');
        $routes->post('update/(:num)', 'Applications::update/$1');
        $routes->post('submit/(:num)', 'Applications::submit/$1');
        $routes->post('approve/(:num)', 'Applications::approve/$1');
        $routes->post('reject/(:num)', 'Applications::reject/$1');
    });
    
    // User Management (admin only)
    $routes->group('users', ['filter' => 'admin'], function($routes) {
        $routes->get('/', 'Users::index');
        $routes->get('create', 'Users::create');
        $routes->post('store', 'Users::store');
        $routes->get('edit/(:num)', 'Users::edit/$1');
        $routes->post('update/(:num)', 'Users::update/$1');
        $routes->get('delete/(:num)', 'Users::delete/$1');
    });
    
    // Reports
    $routes->group('reports', function($routes) {
        $routes->get('/', 'Reports::index');
        $routes->get('generate', 'Reports::generate');
        $routes->post('export', 'Reports::export');
    });
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
