<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/devices', 'DeviceController@index')->name('devices.index')->middleware(['auth']);
//Route::post('/devices', 'DeviceController@store')->name('devices.store')->middleware(['auth']);

Route::get('/devices/report', 'DeviceController@report')->name('devices.report')->middleware(['auth']);
Route::resource('/devices', 'DeviceController')->except(['edit', 'create'])->middleware(['auth']);
