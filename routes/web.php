<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::post(
    'stripe/webhook',
    '\App\Http\Controllers\WebhookController@handleWebhook'
);

Route::get('/logout', 'Auth\LoginController@logout')->name("getlogout");
Route::get('/', '\App\Http\Controllers\Auth\LoginController@showLoginForm');
Route::get('/home', 'HomeController@index')->name('home');




Route::group(['prefix' => 'admin', 'middleware' => ['CheckRole', 'auth']], function() {
    Route::get('home', 'Admin\HomeController@index')->name('admin.home');
    Route::resource('users', 'Admin\UsersController');
    Route::resource('posts', 'Admin\PostsController');
    Route::resource('post-types', 'Admin\PostsTypesController');
    
    Route::resource('subscriptions', 'Admin\SubscriptionController');
    Route::resource('transactions', 'Admin\TransactionsController');
    Route::resource('plans', 'Admin\PlansController');
    Route::resource('payments', 'Admin\PaymentsController');
    Route::resource('commissions', 'Admin\CommissionsController');
    Route::resource('authors', 'Admin\AuthorsController');

    Route::resource('countries', 'Admin\CountriesController');
    Route::resource('cities', 'Admin\CitiesController');
    Route::resource('states', 'Admin\StatesController');
    Route::resource('pagadito', 'Admin\PagaditoController');
    Route::resource('mentions', 'Admin\MentionsController');


    Route::post('subscribe', 'Admin\PaymentsController@subscribe')->name('admin.subscribe.post');
    Route::get('changePlan', 'Admin\PaymentsController@changePlan')->name('admin.changePlan.post');
    Route::get('cancelPlan', 'Admin\PaymentsController@cancelPlan')->name('admin.cancelPlan.get');
    Route::get('posts/getdepartamentos/{id?}', 'Admin\PostsController@getdepartamentos')->name('admin.posts.getdepartamentos');
    Route::get('posts/getciudades/{id?}', 'Admin\PostsController@getciudades')->name('admin.posts.getciudades');
});

Route::get('auth/{provider}', 'Auth\RegisterController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');



Route::get('cancelPlans', 'Admin\SubscriptionController@cancelPlan')->name('admin.cancelPlan2.get');