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

$router->get('test', function () {
    return 'Testing new deployment';
});


$router->group(['prefix' => 'ems/api'], function () use ($router) {
    //Unauthenticated routes
    $router->post('login', 'AuthLoginController@Login'); //admin/employee login
    $router->post('register/admin', 'AuthRegistrationController@adminRegister'); // admin register
    $router->post('register/employee', 'AuthRegistrationController@employeeRegister'); //employee register




     //Authenticated routes
    $router->group(['middleware' => ['auth']], function () use ($router) {
        $router->post('logout', 'AuthLoginController@logout'); //Logout
        $router->get('validate/token', 'AuthLoginController@validateToken'); // Validate Token
        $router->post('create/FirstTimePassword/{id}', 'AuthLoginController@changePassword');//First time change Password
        $router->get('profile/{id}', 'AuthLoginController@profile');// Profile
    });
    

    $router->group(['prefix' => 'employee', 'middleware' => ['auth']], function () use ($router) {
        $router->post('update/employeeImage/{id}', 'EmployeeController@uploadUserImage');//Update Employee Image
        $router->get('listAllEmployee', 'EmployeeController@show'); // List All Employee
        $router->get('getEmployee/{id}', 'EmployeeController@getEmployee'); // Get Employee with Salary
        $router->post('deleteAllEmployee/{id}', 'EmployeeController@deleteAllEmployee'); // Delete Employee
        $router->post('assign/leave', 'EmployeeController@assignLeave'); // Assign Leave to Employee
        $router->post('grant/emp-leave/{id}', 'EmployeeController@grantLeave'); // Grant Leave to Employee

        $router->get('getEmployeeReports/{id}', 'EmployeeController@getEmployeeReports'); // Get Employee Reports
    });





});
