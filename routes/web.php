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
Route::get('/room/return', 'RoomController@returnRoom')->name('returnRoom');
Route::post('/room', 'RoomController@createRoom')->name('createRoom');
Route::get('/room/{roomId}', 'RoomController@joinRoom')->name('room');
Route::post('/room/{roomId}', 'RoomController@createUser');
Route::get('/room/{roomId}/reach', 'RoomController@reachNotification')->name('reachNotification');
Route::get('/room/{roomId}/participants', 'RoomController@getParticipants')->name('getParticipants');
Route::post('/newroom', 'RoomController@forceCreateRoom')->name('forceNewRoom');


Route::view('/', 'index')->name('index');
