<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->group(function(){

    //List available languages
    Route::apiResource('/languages/list','LanguageController');
    //Manage keys
        //List
    Route::apiResource('/keys/list','KeysController');
        //Retrieve
    Route::get('/keys/retrieve/{key}', 'KeysController@show');
        //Create
    Route::post('keys/make', 'KeysController@store');
        //Rename
    Route::put('/keys/rename/{key}', 'KeysController@update');
        //Delete
    Route::delete('/keys/delete/{key}', 'KeysController@destroy');
    //Manage translations
        //Update values in each language
    Route::put('/keys/translation/{key}', 'KeysController@updateTranslation');
    //Export translations
    Route::get('/keys/export', 'KeysController@export');

});
