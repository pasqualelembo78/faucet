<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/registrar', 'HomeController@registrar')->name('registrar')->middleware('guest');

Auth::routes();

// ✅ Tolto 'active' da qui
Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/perfil', 'HomeController@perfil')->name('perfil');
    Route::post('/home', 'HomeController@perfilPost')->name('perfilPost');
    Route::post('/retirar', 'HomeController@retirarPost')->name('retirarPost');
    Route::post('/editar', 'HomeController@editarPost')->name('editarPost');
});

// Queste rotte puoi anche rimuoverle se non usi più la conferma via email
Route::post('/reenviar', 'HomeController@reenviar')->name('reenviar')->middleware('auth');
Route::get('/verificar', 'HomeController@verificar')->name('verificar')->middleware('auth');
Route::get('/verificar/{code}', 'HomeController@activar')->name('activar')->middleware('auth');

Route::get('/{code}', 'HomeController@referido')->name('referido')->middleware('guest');
Route::post('/referido', 'HomeController@referidoPost')->name('referidoPost')->middleware('guest');

Route::get('/prueba/info', 'HomeController@prueba');