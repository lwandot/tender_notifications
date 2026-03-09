<?php

namespace Config;

use CodeIgniter\Routes\RouteCollection;

$routes = Services::routes();

if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// Routes
$routes->get('/', 'Home::index');
$routes->get('api/tender-types', 'Home::getTenderTypes');

// Tender routes
$routes->get('tender/view/(:num)', 'Tender::view/$1');
$routes->get('tender/search', 'Tender::search');

// Authentication routes
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/register', 'Auth::register');
$routes->post('auth/register', 'Auth::register');
$routes->get('auth/logout', 'Auth::logout');

// Subscription routes (protected)
$routes->get('subscription', 'Subscription::index');
$routes->get('subscription/create', 'Subscription::create');
$routes->post('subscription/create', 'Subscription::create');
$routes->post('subscription/delete/(:num)', 'Subscription::delete/$1');
$routes->post('subscription/register-push-token', 'Subscription::registerPushToken');

// API routes
$routes->get('api/tenders', 'Api::getTenders');
$routes->get('api/tender/(:num)', 'Api::getTender/$1');
$routes->get('api/documents/download/(:num)', 'Api::downloadDocument/$1');

// Admin routes (can be added later)
// $routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
//     $routes->get('/', 'Dashboard::index');
//     $routes->resource('tenders');
//     $routes->resource('users');
// });

$routes->get('/', 'Home::index');

require APPPATH . 'Config/Routes.php';
