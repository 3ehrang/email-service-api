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

/*
 * API V1 Email Service Routes
 */
Route::group([
    'middleware' => ['ServiceIdentifier'],
    'prefix' => '/emailservice/v1',
    'namespace' => 'EmailService\Api\V1',
    'as' => 'email.service.api.v1.'], function () {

    // Send email
    Route::post('emails', 'EmailController@send')->name('emails.send');

    // Get emails
    Route::get('emails', 'EmailController@index')->name('emails.index');

});

