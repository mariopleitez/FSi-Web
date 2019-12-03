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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Posts

Route::resource('posts', 'Api\PostsController', [
    'names' => [
        'index' => 'api.posts.index',
        'show'  => 'api.posts.show'
    ],
    'only' => ['index','show']
]);


Route::resource('users', 'Api\UsersController', [
    'names' => [
        'store' => 'api.users.register',
    ],
    'only' => ['store']
]);

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

Route::post('oauth/personaltoken', 'Api\SocialRegisterController@personaltoken');

Route::get('auth/{provider}', 'Api\SocialRegisterController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Api\SocialRegisterController@handleProviderCallback');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('subscribe', 'Api\PaymentsController@subscribe')->name('Api.subscribe.post');
    Route::get('changePlan', 'Api\PaymentsController@changePlan')->name('Api.changePlan.post');
    Route::get('cancelPlan', 'Api\PaymentsController@cancelPlan')->name('Api.cancelPlan.get');
    Route::post('likes', 'Api\UsersController@likes')->name('Api.likes.post');
    Route::get('proyectos', 'Api\UsersController@getproyectos')->name('Api.getproyectos');
}); 

Route::get('getplans/{postid?}', 'Api\PlansController@index')->name('Api.get.plans');
