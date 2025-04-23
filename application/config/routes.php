<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'page'; // Loads Page controller’s index method
$route['404_override'] = ''; // No custom 404 controller
$route['translate_uri_dashes'] = FALSE; // Dashes not translated

// Public routes
$route['login'] = 'page/login';
$route['signup'] = 'page/signup';
$route['signup/(:any)'] = 'page/signup/$1'; // Dynamic signup route
$route['verify-otp'] = 'page/verify_otp';
$route['home'] = 'user/home';

// Static pages
$route['contact-us'] = 'user/contact';
$route['terms-and-conditions'] = 'user/terms';
$route['privacy-policy'] = 'user/privacy';
$route['about-us'] = 'user/aboutus';