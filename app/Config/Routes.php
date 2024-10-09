<?php

use CodeIgniter\Router\RouteCollection;
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
//sign in
$routes->get('/Signin', 'Login::index');
$routes->post('/SigninProcess', 'Login::index');
$routes->get('/logout', 'Login::Logout');
