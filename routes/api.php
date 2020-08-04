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

/**
 * API version v1
 */
Route::prefix('v1')->namespace('APIv1')->group(function () {

    Route::post('login', 'LoginController@login')->name('login');
    Route::post('register', 'RegisterController@register')->name('register');

    /**
     * User Authenticated routes
     */
    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('email/verify/{hash}', 'VerificationController@verify')->name('verification.verify');
        Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
        Route::get('user', 'AuthenticationController@user')->name('user');
        Route::post('logout', 'LoginController@logout')->name('logout');

        /**
         * Film routes
         */
        Route::resource('films', 'FilmController')->only(['store', 'destroy']);
        Route::get('countryList', 'CountryController@countryList')->name('countryList');
    });

    /**
     * Films guest routes
     */
    Route::resource('films', 'FilmController')
    ->only(['index', 'show'])
    ->parameters([
        'films' => 'slug'
    ]);

});
