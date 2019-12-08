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

Route::get('/participantLobby/{roomId}', 'RoomController@participantLobby')->name('participantLobby');
Route::view('/bingocard', 'room/index');

Route::get('/room/start', 'RoomController@startGame')->name('startGame');
Route::post('/room', 'RoomController@createRoom')->name('createRoom');
Route::get('/room/{roomId}', 'RoomController@joinRoom')->name('room');
Route::post('/room/{roomId}', 'RoomController@createUser');
Route::post('/newroom', 'RoomController@forceCreateRoom')->name('forceNewRoom');


Route::view('/', 'index')->name('index');
