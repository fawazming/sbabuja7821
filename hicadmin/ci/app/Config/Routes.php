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
$routes->setDefaultController('Home');
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
$routes->group('stat', static function ($routes) {
    $routes->get('/', 'Stat::index');
    $routes->get('/dashboard', 'Stat::dashboard');
    $routes->get('/printe', 'Stat::printe');
    $routes->get('/printm', 'Stat::printm');
    $routes->post('/auth', 'Stat::auth');
    $routes->get('/manual', 'Stat::manual');
    $routes->get('/manual1', 'Stat::manual1');
    $routes->post('/manual2', 'Stat::manual2');
    $routes->get('/logout', 'Stat::logout');
    $routes->get('/cert/(:any)', 'Stat::cert/$1');
});

$routes->group('vendor', static function ($routes) {
    $routes->get('/', 'Vendor::index');
    // $routes->get('/samp', 'Vendor::samp');
    $routes->get('/dashboard', 'Vendor::dashboard');
    $routes->get('/special', 'Vendor::special');
    $routes->get('/manual', 'Vendor::manual');
    $routes->get('/sync/(:any)', 'Vendor::sync/$1');
    $routes->get('/lock/(:any)', 'Vendor::lock/$1');
    $routes->get('/tag', 'Vendor::tag');
    $routes->get('/sellpin', 'Vendor::sellpin');
    $routes->get('/calibrate', 'Vendor::calibrate');
    $routes->get('/reset', 'Vendor::resetPin');
    $routes->post('/auth', 'Vendor::auth');
    $routes->post('/sharepin', 'Vendor::sharepin');
    $routes->post('/printtag', 'Vendor::printtag');
    $routes->post('/logupdate', 'Vendor::logupdate');
    $routes->get('/logout', 'Vendor::logout');
});

$routes->get('/', 'General::index');

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
