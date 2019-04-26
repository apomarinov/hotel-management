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

Route::get('/', 'HomeController@index');

Route::resource('reservations', 'ReservationsController');
Route::resource('clients', 'ClientsController');
Route::resource('rooms', 'RoomsController');
Route::resource('hotels', 'HotelsController');
Route::resource('reservation-status', 'ReservationStatusController');

Route::get('available-rooms', 'RoomsController@availableRooms');
Route::delete('reservations/{reservation}/clients/{client}', 'ReservationsController@deleteClient');

