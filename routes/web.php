<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'ems/api'], function () use ($router) {
    //Unauthenticated routes
    $router->post('login', 'AuthLoginController@Login'); //admin/employee login
    $router->post('register/admin', 'AuthRegistrationController@adminRegister'); // admin register
    $router->post('register/employee', 'AuthRegistrationController@employeeRegister'); //employee register
    $router->post('create/FirstTimePassword/{id}', 'AuthLoginController@changePassword');//First time change Password
    $router->post('logout', 'AuthLoginController@logout'); //Logout
    $router->get('validate/token', 'GeneralController@validateToken'); // Validate Token

});
