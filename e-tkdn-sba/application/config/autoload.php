<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
*/

/*
| -------------------------------------------------------------------
| Libraries
| -------------------------------------------------------------------
*/
$autoload['libraries'] = array('database', 'session', 'form_validation');

/*
| -------------------------------------------------------------------
| Drivers
| -------------------------------------------------------------------
*/
$autoload['drivers'] = array();

/*
| -------------------------------------------------------------------
| Helper Files
| -------------------------------------------------------------------
*/
$autoload['helper'] = array('url', 'form', 'html', 'date');

/*
| -------------------------------------------------------------------
| Config Files
| -------------------------------------------------------------------
*/
$autoload['config'] = array();

/*
| -------------------------------------------------------------------
| Language Files
| -------------------------------------------------------------------
*/
$autoload['language'] = array();

/*
| -------------------------------------------------------------------
| Models
| -------------------------------------------------------------------
*/
$autoload['model'] = array();

/*
| -------------------------------------------------------------------
| Packages
| -------------------------------------------------------------------
*/
$autoload['packages'] = array();
