<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    $hello = 'Hi Mark!';
    $items = [[
            'name' => 'Anton',
            'count' => 1
        ], [
            'name' => 'Maria',
            'count' => 2
        ]
    ];
    return view('hello', compact('items', 'hello'));
});
