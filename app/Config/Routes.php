<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');




$routes->get('/', 'Home::index');
$routes->get('admin', 'AdminController::index');
// $routes->post('/projects/insert', 'ProjectController::insert');

$routes->get('/projects', 'ProjectController::index'); // View all projects
$routes->get('/projects/search', 'ProjectController::search'); // Search projects
$routes->post('/projects/add', 'ProjectController::insert'); // Add a new project
$routes->post('/projects/update/(:num)', 'ProjectController::update/$1'); // Update a project
$routes->get('/projects/delete/(:num)', 'ProjectController::delete/$1'); // Delete a project
$routes->get('/projects/view/(:num)', 'ProjectController::view/$1');

$routes->get('tasks', 'AdminController::viewAllTasksOfUser');
$routes->post('/tasks/start/(:num)', 'TaskController::start/$1');
$routes->post('/tasks/finish/(:num)', 'TaskController::finish/$1');
$routes->post('/tasks/add', 'TaskController::insert'); // Add a new task
$routes->post('/tasks/delete/(:num)', 'TaskController::delete/$1'); // Delete a project
$routes->post('/tasks/update/(:num)', 'TaskController::update/$1'); // Update a project
$routes->get('/tasks/search/(:num)', 'TaskController::search/$1');//search tasks
$routes->get('/tasks/search/', 'TaskController::UserTaskSearch');//search tasks

$routes->get('users/view', 'UserController::index');
$routes->post('/users/add', 'UserController::insert'); //Insert a user
$routes->post('/users/update/(:num)', 'UserController::update/$1'); // Update a User
$routes->post('/users/delete/(:num)', 'UserController::delete/$1'); // Delete a user
$routes->get('/users/search', 'UserController::search');//search tasks

$routes->get('/search', 'AdminController::search');
