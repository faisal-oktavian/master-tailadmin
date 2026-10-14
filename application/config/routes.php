<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth
$route['login']         = 'auth/index';
$route['login/process'] = 'auth/process';
$route['logout']        = 'auth/logout';

// Dashboard
$route['dashboard'] = 'dashboard/index';
