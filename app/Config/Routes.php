<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');
$routes->post('login/attempt', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');
$routes->get('admin/prefixes', 'PrefixeController::index', ['filter' => 'auth']);
$routes->get('admin/prefixes/ajouter', 'PrefixeController::ajouter', ['filter' => 'auth']);
$routes->post('admin/prefixes/store', 'PrefixeController::store', ['filter' => 'auth']);
$routes->get('admin/prefixes/modifier/(:num)', 'PrefixeController::modifier/$1', ['filter' => 'auth']);
$routes->post('admin/prefixes/update/(:num)', 'PrefixeController::update/$1', ['filter' => 'auth']);
$routes->get('admin/prefixes/supprimer/(:num)', 'PrefixeController::supprimer/$1', ['filter' => 'auth']);

$routes->get('admin/clients', 'ClientController::index', ['filter' => 'auth']);
$routes->get('admin/clients/create', 'ClientController::create', ['filter' => 'auth']);
$routes->post('admin/clients/store', 'ClientController::store', ['filter' => 'auth']);
$routes->get('admin/clients/edit/(:num)', 'ClientController::edit/$1', ['filter' => 'auth']);
$routes->post('admin/clients/update/(:num)', 'ClientController::update/$1', ['filter' => 'auth']);
$routes->get('admin/clients/delete/(:num)', 'ClientController::delete/$1', ['filter' => 'auth']);
$routes->post('admin/clients/delete/(:num)', 'ClientController::delete/$1', ['filter' => 'auth']);
$routes->get('admin/clients/historique/(:num)', 'ClientController::historique/$1', ['filter' => 'auth']);

$routes->get('client/login/(:any)', 'ClientController::login/$1', ['filter' => 'auth']);
$routes->get('client/dashboard', 'ClientController::dashboard', ['filter' => 'auth']);
$routes->get('client/retrait', 'TransactionController::retrait', ['filter' => 'auth']);
$routes->post('client/retrait/effectuer', 'TransactionController::effectuerRetrait', ['filter' => 'auth']);
$routes->get('client/transfert', 'TransactionController::transfert', ['filter' => 'auth']);
$routes->post('client/transfert/effectuer', 'TransactionController::effectuerTransfert', ['filter' => 'auth']);
$routes->get('client/historique', 'TransactionController::historique', ['filter' => 'auth']);
$routes->get('client/depot', 'TransactionController::depot', ['filter' => 'auth']);
$routes->post('client/depot/effectuer', 'TransactionController::effectuerDepot', ['filter' => 'auth']);
$routes->get('admin/tableau-de-bord', 'TableauDeBordController::index', ['filter' => 'auth']);
$routes->get('admin/commission', 'CommissionController::index', ['filter' => 'auth']);
$routes->post('admin/commission/update', 'CommissionController::update', ['filter' => 'auth']);
$routes->get('admin/situation', 'SituationController::index', ['filter' => 'auth']);
