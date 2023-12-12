<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('login', 'Users::login');
$routes->get('register', 'Users::register');
$routes->post('insertar', 'Users::insertar');
$routes->post('loginA', 'Users::loginA');
$routes->post('logoutUser', 'Users::logoutUser');
$routes->post('cambiaEstado/(:num)/(:any)', 'Users::cambiarEstadoPerfil/$1/$2');


$routes->get('categories', 'Categories::index');
$routes->post('agregarCategorie', 'Categories::agregar');
$routes->post('delete/(:num)', 'Categories::delete/$1');
$routes->post('editCategory/(:num)', 'Categories::editCategory/$1');

$routes->get('news_sources', 'NewsSources::index');
$routes->post('agregar', 'NewsSources::agregar');
$routes->post('deleteNewsSources/(:num)', 'NewsSources::delete/$1');
$routes->post('editNewsSources/(:num)', 'NewsSources::editNewsSources/$1');

$routes->get('your_unique_news', 'YourNews::index');

$routes->get('portada_publica', 'YourNews::portadaPublica');
$routes->get('portada_privada', 'YourNews::portadaPublica');


$routes->get('portada_publica/(:segment)/(:segment)/(:num)', 'YourNews::portadaPublica/$1/$2/$3');
$routes->get('search', 'YourNews::search');



