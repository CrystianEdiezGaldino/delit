<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Main::index');
$routes->get('/login', 'Main::login');
$routes->post('/auth', 'Main::auth');
$routes->get('/logout', 'Main::logout');
$routes->get('/menus', 'Main::menus');
$routes->get('/', 'Main::index', ['filter' => 'auth']);
