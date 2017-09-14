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


$api->get('/quantities', 'QuantitiesController@index');

$api->post('/users', 'UsersController@store');
$api->post('/users/confirmations', 'ConfirmationsController@store');

$api->post('/tokens', 'TokensController@store');
$api->put('/tokens', 'TokensController@update');

$api->get('/regions', 'RegionsController@index');
$api->get('/spheres', 'SpheresController@index');


$api->group(['middleware' => 'api.auth'], function ($api) {
    $api->get('/tokens/test', 'TokensController@test');
    $api->delete('/tokens/{token}', 'TokensController@delete');


    // + filter status=archive,active, without
    $api->get('/demands', 'DemandsController@index');
    $api->post('/demands', 'DemandsController@store');

    //status=archive,active, without
    $api->post('/demands/active', 'DemandsController@storeActive');
    $api->post('/demands/cancel', 'DemandsController@storeCancel');
    $api->post('/demands/done', 'DemandsController@storeDone');

    $api->patch('/demands/{id}', 'DemandsController@update');
    $api->delete('/demands/{id}', 'DemandsController@delete');

    // status=draft, archive, active, without
    $api->get('/responses', 'ResponsesController@index');

    // status=archive, active responseItems + data
    $api->patch('/responses/{id}', 'ResponsesController@update');
    $api->post('/responses/{id}/readed', 'ResponsesController@updateReaded');

    // price
    $api->patch('/responseItems/{id}', 'ResponseItemsController@update');
    $api->delete('/responseItems/{id}', 'ResponseItemsController@delete');

    // response_item_id
    $api->patch('/demandItems/{id}', 'DemandItemsController@update');

    //responseItems
    $api->post('/invoices', 'InvoicesController@store');
    //:todo + file
    $api->put('/invoices/{id}', 'InvoicesController@update');

    //download file
    $api->get('/invoices/{id}/files/{name}', 'InvoicesController@file');
    //
    $api->delete('/invoices/{id}', 'InvoicesController@delete');

    //:todo demands, responses
    $api->get('/updates', 'UpdatesController@index');

    // spheres, regions
    //$api->get('/companies/search', 'CompaniesController@search');

    // status=archive, active responseItems + data
    $api->get('/companies/{id}', 'CompaniesController@get');
    $api->patch('/companies/{id}', 'CompaniesController@update');


    $api->get('/messages', 'MessagesController@index');
    $api->post('/messages', 'MessagesController@store');
    $api->post('/messages/{id}/readed', 'MessagesController@updateReaded');

});
