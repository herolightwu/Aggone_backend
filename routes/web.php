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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified', 'role:user']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::group(['middleware' => ['auth', 'verified', 'role:admin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::redirect('/', '/admin/dashboard');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('users', 'UserController');
    Route::resource('players', 'PlayerController');
    Route::resource('coaches', 'CoachController');
    Route::put('users/{user}/update-password', 'UserController@updatePassword')->name('users.update-pwd');

    Route::resource('groups', 'UserGroupController');
    Route::resource('deleted-groups', 'DeletedGroupController');
    Route::resource('deleted-users', 'DeletedUserController');
    Route::resource('countries', 'CountryController');
    Route::resource('deleted-countries', 'DeletedCountryController');
    Route::resource('cities', 'CityController');
    Route::resource('deleted-cities', 'DeletedCityController');

    Route::resource('sports', 'SportController');
    Route::resource('deleted-sports', 'DeletedSportController');
});
