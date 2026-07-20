<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');
$routes->post('login/attempt', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');
$routes->get('admin/prefixes', 'PrefixeController::index');
$routes->get('admin/frais', 'FraisController::index');
$routes->get('admin/frais/create', 'FraisController::create');
$routes->post('admin/frais/store', 'FraisController::store');
$routes->get('admin/frais/edit/(:num)', 'FraisController::edit/$1');
$routes->post('admin/frais/update/(:num)', 'FraisController::update/$1');
$routes->get('admin/frais/delete/(:num)', 'FraisController::delete/$1');
$routes->get('admin/prefixes', 'PrefixeController::index', ['filter' => 'auth']);

$routes->get('admin/clients', 'ClientController::index', ['filter' => 'auth']);
$routes->get('admin/clients/create', 'ClientController::create', ['filter' => 'auth']);
$routes->post('admin/clients/store', 'ClientController::store', ['filter' => 'auth']);
$routes->get('admin/clients/edit/(:num)', 'ClientController::edit/$1', ['filter' => 'auth']);
$routes->post('admin/clients/update/(:num)', 'ClientController::update/$1', ['filter' => 'auth']);
$routes->get('admin/clients/delete/(:num)', 'ClientController::delete/$1', ['filter' => 'auth']);

$routes->get('client/login/(:any)', 'ClientController::login/$1', ['filter' => 'auth']);
$routes->get('client/dashboard', 'ClientController::dashboard', ['filter' => 'auth']);
$routes->get('client/depot', 'TransactionController::depot', ['filter' => 'auth']);
$routes->post('client/depot/effectuer', 'TransactionController::effectuerDepot', ['filter' => 'auth']);