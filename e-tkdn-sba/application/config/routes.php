<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|   example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
*/

// Default route
$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth routes
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';

// Dashboard route
$route['dashboard'] = 'dashboard';

// Application routes
$route['applications'] = 'applications/index';
$route['applications/create'] = 'applications/create';
$route['applications/view/(:num)'] = 'applications/view/$1';
$route['applications/edit/(:num)'] = 'applications/edit/$1';
$route['applications/delete/(:num)'] = 'applications/delete/$1';

// User management routes (admin only)
$route['users'] = 'users/index';
$route['users/create'] = 'users/create';
$route['users/edit/(:num)'] = 'users/edit/$1';
$route['users/delete/(:num)'] = 'users/delete/$1';
