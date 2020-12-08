<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
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

// Daftar ORGANISASI yagn diikuti
Route::get('organisasi', 'OrganisasiController@index')->name('organisasi');

// Dasbor Organisasi
Route::get('organisasi/manage/{organisasi_id}', 'OrganisasiController@manage')->name('organisasi/manage');

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

// Halaman Anggota
Route::get('organisasi/manage/members/{organisasi_id}', 'OrganisasiController@manageMembers')->name('organisasi/manage/members');

// TAMBAH Anggota
Route::post('organisasi/manage/members/{organisasi_id}', 'OrganisasiController@members')->name('organisasi/manage/members');

// Ubah Anggota
Route::post('organisasi/manage/members/update/{organisasi_id}', 'OrganisasiController@membersUpdate')->name('organisasi/manage/members/update');

// Halaman Tracking
Route::get('organisasi/manage/money/{organisasi_id}', 'OrganisasiController@manageMoney')->name('organisasi/manage/money');

// Tambah Tracking
Route::post('organisasi/tracking/add/{organisasi_id}', 'OrganisasiController@trackingAdd')->name('organisasi/tracking/add');

// Tambah Tracking Custome
Route::post('organisasi/tracking/addc/{organisasi_id}', 'OrganisasiController@trackingAddc')->name('organisasi/tracking/addc');

// Ubah Tracking Custome
Route::post('organisasi/tracking/updatec/{organisasi_id}', 'OrganisasiController@trackingUpdatec')->name('organisasi/tracking/updatec');

// Halaman untuk mengubah organisasi
Route::get('organisasi/manage/settings/{organisasi_id}', 'OrganisasiController@manageSettings')->name('organisasi/manage/settings');

// Ubah data organisasi
Route::post('organisasi/update', 'OrganisasiController@update')->name('organisasi/update');

// Ubah bendahara utama organisasi
Route::post('organisasi/change', 'OrganisasiController@change')->name('organisasi/change');

// Halaman Profil
Route::get('profile', 'ProfileController@index')->name('profile');

// Halaman pengaturan profil
Route::get('profile/settings', 'ProfileController@settings')->name('profile/settings');

// ubah kata sandi
Route::match(['get', 'post'], '/profile/change/password', 'ProfileController@changePassword')->name('profile/change/password');

// ubah foto profil
Route::match(['get', 'post'], 'profile/change/pictures', 'ProfileController@changePictures')->name('profile/change/pictures');

// ubah data pribadi
Route::match(['get', 'post'], 'profile/change/personal', 'ProfileController@changePersonal')->name('profile/change/personal');

// ubah data contact
Route::match(['get', 'post'], 'profile/change/contact', 'ProfileController@changeContact')->name('profile/change/contact');


/*
==============================================================
Anggota
==============================================================
*/

// Halaman masuk sebagai anggota
Route::get('member', function(){
    if(Cookie::get('member_id')){
        return redirect('member/dashboard');
    }
    return view("auth.member");
})->name('member');

// Periksa data masuk anggota
Route::post('member', 'LoginMembersController@cekAnggota')->name('member');

// Keluar dari halaman anggota
Route::match(['get', 'post'], 'member/logout', 'LoginMembersController@logout')->name('member/logout');

// Halaman dasbor organisasi untuk anggota
Route::get('member/dashboard', 'MembersController@dashboard')->name('member/dashboard');

// Halaman tracking organisasi untuk anggota
Route::get('member/tracking', 'MembersController@tracking')->name('member/tracking');