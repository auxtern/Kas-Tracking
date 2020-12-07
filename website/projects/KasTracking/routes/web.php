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

/*
==============================================================
ORGANISASI
==============================================================
*/

// DASBOR ORGANISASI
Route::get('organisasi', 'OrganisasiController@index')->name('organisasi');

// HALAMAN BUAT ORGANISASI
Route::get('organisasi/create', 'OrganisasiController@createView')->name('organisasi/create');

// BUAT ORGANISASI
Route::post('organisasi/create', 'OrganisasiController@create')->name('organisasi/create');

// HALAMAN BENDAHARA
Route::get('organisasi/manage/users/{organisasi_id}', 'OrganisasiController@manageUsers')->name('organisasi/manage/users');

// TAMBAH BENDAHARA
Route::post('organisasi/manage/users/{organisasi_id}', 'OrganisasiController@users')->name('organisasi/manage/users');

// HAPUS BENDAHARA
Route::post('organisasi/manage/users/delete/{organisasi_id}', 'OrganisasiController@usersDelete')->name('organisasi/manage/users/delete');

Route::get('organisasi/manage/{organisasi_id}', 'OrganisasiController@manage')->name('organisasi/manage');


Route::get('organisasi/manage/members/{organisasi_id}', 'OrganisasiController@manageMembers')->name('organisasi/manage/members');
Route::get('organisasi/manage/money/{organisasi_id}', 'OrganisasiController@manageMoney')->name('organisasi/manage/money');
Route::get('organisasi/manage/settings/{organisasi_id}', 'OrganisasiController@manageSettings')->name('organisasi/manage/settings');

Route::post('organisasi/update', 'OrganisasiController@update')->name('organisasi/update');


Route::get('profile', 'ProfileController@index')->name('profile');

Route::get('profile/settings', 'ProfileController@settings')->name('profile/settings');

Route::match(['get', 'post'], '/profile/change/password', 'ProfileController@changePassword')->name('profile/change/password');

Route::match(['get', 'post'], 'profile/change/pictures', 'ProfileController@changePictures')->name('profile/change/pictures');

Route::match(['get', 'post'], 'profile/change/personal', 'ProfileController@changePersonal')->name('profile/change/personal');

Route::match(['get', 'post'], 'profile/change/contact', 'ProfileController@changeContact')->name('profile/change/contact');


// Members Route
