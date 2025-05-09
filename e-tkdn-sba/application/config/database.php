<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
*/

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => '',  // Set your database username
    'password' => '',  // Set your database password
    'database' => 'e_tkdn_sba',  // Set your database name
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

// Load database credentials from .env file if it exists
if (file_exists(FCPATH . '.env')) {
    $env = parse_ini_file(FCPATH . '.env');
    if ($env) {
        $db['default']['hostname'] = $env['DB_HOST'] ?? $db['default']['hostname'];
        $db['default']['username'] = $env['DB_USERNAME'] ?? $db['default']['username'];
        $db['default']['password'] = $env['DB_PASSWORD'] ?? $db['default']['password'];
        $db['default']['database'] = $env['DB_DATABASE'] ?? $db['default']['database'];
    }
}
