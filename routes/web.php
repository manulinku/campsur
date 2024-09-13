<?php

use Illuminate\Support\Facades\Route;

// Página de inicio
Route::get('/', function () {
    return view('Auth/login');
});

// Otras rutas de la aplicación
Route::get('contacto', function () {
    return view('contacto');
});

// Rutas de autorización para el Usuario
Auth::routes();

Route::middleware('auth')->group(function () {
// Ruta para el dashboard o página de inicio después de login
    Route::get('/menu', 'HomeController@index')->name('menu');
});    

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/clientes', 'ClienteController@index')->name('clientes.index');
    Route::get('/clientes/{id}/edit', 'ClienteController@edit')->name('clientes.edit');
    Route::post('/clientes/{id}', 'ClienteController@update')->name('clientes.update');
});