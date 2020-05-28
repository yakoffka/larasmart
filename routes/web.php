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
    return redirect()->route('devices.index');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/relays/{relay}/toggle_on', 'DeviceController@toggleOn')->name('relays.toggle_on');
Route::post('/relays/{relay}/toggle_off', 'DeviceController@toggleOff')->name('relays.toggle_off');
Route::get('/devices/report', 'DeviceController@report')->name('devices.report');
Route::resource('/devices', 'DeviceController')->except(['edit', 'create']);
