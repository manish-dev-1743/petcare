<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/register','Home::register');
$routes->post('/signup','Home::signup');
$routes->get('/login','Home::login');
$routes->post('/do-login','Home::dologin');
