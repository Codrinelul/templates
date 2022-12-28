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
    
    Route::middleware('auth:api')->get('/templates', function (Request $request) {
        return $request->user();
    });
    
    Route::get('/templates/api', "Api\ApiController@index");
    Route::get('/templates/list', "Api\ApiController@list");
    Route::get('/templates/apitypes', "Api\ApiController@apitypes");

    /* Route::lapiv(function () {
        Route::get('/templates/api', "Api\Version\ApiVersionController@index");
        Route::get('/templates/list', "Api\Version\ApiVersionController@list");
        Route::get('/templates/apitypes', "Api\Version\ApiVersionController@apitypes");
    }); */