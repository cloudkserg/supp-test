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

    // + filter status=archive,active, without
    $api->get('/demands', 'DemandsController@index');
    $api->post('/demands', 'DemandsController@store');
    //status=archive,active, without
    $api->patch('/demands', 'DemandsController@update');

    // status=draft, archive, active, without
    $api->get('/responses', 'ResponsesController@index');

    // status=archive, active responseItems + data
    $api->patch('/responses', 'ResponsesController@update');

    // price
    $api->patch('/responseItems/{id}', 'ResponseItemsController@update');
    $api->delete('/responseItems/{id}', 'ResponseItemsController@delete');

    // response_item_id
    $api->patch('/demandItems/{id}', 'DemandItemsController@update');

    //:todo
    $api->post('/invoices', 'InvoicesController@store');
    //:todo + file
    $api->patch('/invoices/{id}', 'InvoicesController@update');
    //:todo
    $api->delete('/invoices/{id}', 'InvoicesController@delete');

    //:todo demands, responses
    $api->get('/updates', 'UpdatesController@index');

    // spheres, regions
    $api->get('/companies/search', 'CompaniesController@search');

});
