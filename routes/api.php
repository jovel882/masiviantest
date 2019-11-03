<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'tree'], function () {    
    Route::get('/','TreeController@search')
        ->name('tree_search');
    Route::get('/all','TreeController@getAll')
        ->name('tree_getAll');
    Route::get('/{id}','TreeController@get')
        ->where('id', '[0-9]+')
        ->name('tree_get');
    Route::post('/','TreeController@create')
        ->name('tree_create');
    Route::put('/{id}','TreeController@update')
        ->where('id', '[0-9]+')
        ->name('tree_update');
    Route::delete('/{id}','TreeController@delete')
        ->where('id', '[0-9]+')
        ->name('tree_delete');
    Route::get('/{id}/lowestCommonAncestor','TreeController@lowestCommonAncestor')
        ->where('id', '[0-9]+')
        ->name('tree_lowestCommonAncestor');
    Route::group(['prefix' => '{id}/node',"where"=>["id"=>"[0-9]+"]], function () {
        Route::post('/','NodeController@createOrigin')
        ->name('tree_node_createOrigin');
        Route::get('/{node}','NodeController@get')
        ->where('node', '[0-9]+')
        ->name('tree_node_get');                
        Route::post('/{node}','NodeController@create')
        ->where('node', '[0-9]+')
        ->name('tree_node_create');                
        Route::put('/{node}','NodeController@update')
        ->where('node', '[0-9]+')
        ->name('tree_node_update');                
    }); 
});    