<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Logic');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Logic::index');
$routes->get('/m', 'Logic::modern');
$routes->get('/m0', 'Logic::modern2');
$routes->get('/sbidsearch', 'Logic::idsearch');
$routes->get('/idsearch', 'Logic::idsearchj');
$routes->get('/samp', 'Logic::samp');
$routes->get('/buypin', 'Logic::buypin');
$routes->get('/7c67ff5de8e5c90c/(:any)', 'Logic::vend/$1');
$routes->get('/register', 'Logic::register');
$routes->get('/register/(:any)', 'Logic::register/$1');
$routes->get('/pinstatus', 'Logic::pinstatus');
$routes->get('/vendors', 'Logic::vendors');
$routes->get('/msg', 'Logic::msg');

$routes->get('/genpin', 'PinGenerator::generate');

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->get('verify-pin', 'PinsController::verifyPin');
    $routes->get('pin-status', 'PinsController::pinStatus');
});

// $routes->post('/registration', 'Logic::registration');

$routes->post('/register', 'Logic::pregister');
$routes->get('/regc', 'Logic::cregisterPin');
$routes->get('/slip', 'Logic::slip');
$routes->post('/registration', 'Logic::registration');
$routes->get('/notification', 'Logic::notif');


$routes->post('/sns/pmc', 'Logic::sms');
$routes->get('pin', 'Logic::pin');
$routes->get('samp', 'Logic::samp');
$routes->get('pinstat', 'Logic::pinstat');
$routes->get('payonline', 'Logic::payonline');
$routes->post('proceedpayonline', 'Logic::proceedOnline');
$routes->get('payvesselcall', 'Logic::webhook');
$routes->get('tt', 'Logic::webhk');

/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
