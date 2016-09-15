<?php
/**
 * @var Dingo\Api\Routing\Router $api
 */
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
|
*/


$api->post('/users', 'UsersController@store');
$api->post('/users/{user_id}/confirmations', 'ConfirmationsController@store');

$api->post('/tokens', 'TokensController@store');
$api->put('/tokens', 'TokensController@update');


$api->group(['middleware' => 'api.auth'], function ($api) {
    $api->get('/tokens/test', 'TokensController@test');

    $api->get('/demands', 'DemandsController@indexActive');
    $api->post('/demands', 'DemandsController@store');

    $api->get('/companies/search', 'CompaniesController@search');



});
