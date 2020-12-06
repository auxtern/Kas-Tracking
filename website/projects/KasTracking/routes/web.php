<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
Auth::routes(['verify' => true]);

// Home
Route::get('/', 'OrganisasiController@index')->name('/');
Route::get('home', 'OrganisasiController@index')->name('home');

// ORGANISASI
Route::get('organisasi', 'OrganisasiController@index')->name('organisasi');

Route::get('organisasi/create', 'OrganisasiController@createView')->name('organisasi/create');
Route::post('organisasi/create', 'OrganisasiController@create')->name('organisasi/create');



Route::get('profile', 'ProfileController@index')->name('profile');

Route::get('profile/settings', 'ProfileController@settings')->name('profile/settings');

Route::match(['get', 'post'], '/profile/change/password', 'ProfileController@changePassword')->name('profile/change/password');

Route::match(['get', 'post'], 'profile/change/pictures', 'ProfileController@changePictures')->name('profile/change/pictures');

Route::match(['get', 'post'], 'profile/change/personal', 'ProfileController@changePersonal')->name('profile/change/personal');

Route::match(['get', 'post'], 'profile/change/contact', 'ProfileController@changeContact')->name('profile/change/contact');


// Members Route
