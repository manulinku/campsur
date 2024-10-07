<?php

use Illuminate\Support\Facades\Route;

// Página de inicio
Route::get('/', function () {
    // (IMPORTANTE CAMBIAR CUANDO ESTÉ EN PRODUCCIÓN)
//    if (Auth::check()) {
//         // Si el usuario está autenticado, redirige a la vista del menú
//         return redirect()->route('menu'); // Asegúrate de definir la ruta 'menu'
//     }

    // Si el usuario no está autenticado, muestra la vista de login (IMPORTANTE CAMBIAR CUANDO ESTÉ EN PRODUCCIÓN)
    // return view('Auth/login');
    return view('bienvenida');
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
    Route::get('/albaranes', 'HomeController@albaranes')->name('albaranes');
    Route::get('/albaranes/{NUMERO}', 'HomeController@mostrarAlbaran')->name('mostrarAlbaran');
    Route::get('/facturas', 'HomeController@facturas')->name('facturas');
    Route::get('/facturas/{NUMERO}', 'HomeController@mostrarFactura')->name('mostrarFactura');
    Route::get('/movimientos/{codigo_proveedor}', 'HomeController@mostrarMovimientos')->name('movimientos.envase.palet');
});    

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/clientes', 'ClienteController@index')->name('clientes.index');
    Route::get('/clientes/{id}/edit', 'ClienteController@edit')->name('clientes.edit');
    Route::post('/clientes/{id}', 'ClienteController@update')->name('clientes.update');
});