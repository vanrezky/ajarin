<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', function () {
//     if (session()->has('_ci_user_login')) {
//         return redirect()->to(session('_ci_user_login.level'));
//     }
//     return redirect()->to('login');
// });
$routes->get('/', 'Home::index');
$routes->get('appoinment', 'Home::appoinment');
$routes->match(['get', 'post'], 'signin', 'Home::signin');
$routes->match(['get', 'post'], 'signup', 'Home::signup');
$routes->get('logout', 'Home::logout');

$routes->group('student', [], function ($routes) {

    $routes->get('/', 'Student::index');
    $routes->get('teacher-detail', 'Student::teacherDetail');
    $routes->get('discuss', 'Student::discuss');
    $routes->post('discuss/chat', 'Student::chat');
    $routes->match(['get', 'post'], 'profile', 'Student::profile');

    $routes->group('payment', [], function ($routes) {
        $routes->match(['get', 'post'], '/', 'Student::payment');
        $routes->post('token', 'Student::token');
        $routes->get('finish', 'Student::finish');
        $routes->get('history', 'Student::history');
        $routes->get('status', 'Student::status');
    });
});


$routes->group('teacher', [], function ($routes) {

    $routes->get('/', 'Teacher::index');
    $routes->get('discuss', 'Teacher::discuss');
    $routes->post('discuss/chat', 'Student::chat');
    $routes->match(['get', 'post'], 'profile', 'Teacher::profile');
});



$routes->group('admin', [], function ($routes) {

    $routes->match(['get', 'post'], 'login', 'Admin\Auth::index');
    $routes->get('logout', 'Admin\Auth::logout');


    $routes->get('/', 'Admin\Dashboard::index');

    $routes->group('student', [], function ($routes) {

        $routes->get('/', 'Admin\Student::index');
        $routes->match(['get', 'post'], 'data', 'Admin\Student::data');
        $routes->match(['get', 'post'], 'data/(:num)', 'Admin\Student::data/$1');
        $routes->get('delete/(:num)', 'Admin\Student::delete/$1');
    });

    $routes->group('teacher', [], function ($routes) {

        $routes->get('/', 'Admin\Teacher::index');
        $routes->match(['get', 'post'], 'data', 'Admin\Teacher::data');
        $routes->match(['get', 'post'], 'data/(:num)', 'Admin\Teacher::data/$1');
        $routes->get('delete/(:num)', 'Admin\Teacher::delete/$1');
    });


    $routes->group('user', [], function ($routes) {

        $routes->get('/', 'Admin\User::index');
        $routes->match(['get', 'post'], 'data', 'Admin\User::data');
        $routes->match(['get', 'post'], 'data/(:num)', 'Admin\User::data/$1');
        $routes->get('delete/(:num)', 'Admin\User::delete/$1');
    });


    $routes->group('transaction', [], function ($routes) {

        $routes->get('/', 'Admin\Transaction::index');
        $routes->get('receipt', 'Admin\Transaction::receipt');
    });



    $routes->get('teacher', 'Admin\Teacher::index');
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
