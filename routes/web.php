<?php

use Illuminate\Support\Facades\Route;

// Página de inicio
Route::get('/', function () {
    return view('home');
});

// Otras rutas de la aplicación
Route::get('sobre-nosotros', function () {
    return view('sobre-nosotros');
});
Route::get('contacto', function () {
    return view('contacto');
});

//Textos legales
Route::get('aviso-legal', function () {
    return view('textosLegales.aviso-legal');
});
Route::get('politica-privacidad', function () {
    return view('textosLegales.politica-privacidad');
});
Route::get('politica-cookies', function () {
    return view('textosLegales.politica-cookies');
});
Route::get('terminos-condiciones', function () {
    return view('textosLegales.terminos-condiciones');
});



// Rutas de autorización para el Usuario
Auth::routes();

Route::middleware('auth')->group(function () {
// Ruta para el dashboard o página de inicio después de login
    Route::get('/menu', 'HomeController@index')->name('menu');
    Route::get('/albaranes', 'HomeController@albaranes')->name('albaranes');
    Route::get('/albaranes/{NUMERO}', 'HomeController@mostrarAlbaran')->name('mostrarAlbaran');
    Route::get('/movimientos/{codigo_proveedor}', 'HomeController@mostrarMovimientos')->name('movimientos.envase.palet');

    //En caso de que se quieran facturas
    // Route::get('/facturas', 'HomeController@facturas')->name('facturas');
    // Route::get('/facturas/{NUMERO}', 'HomeController@mostrarFactura')->name('mostrarFactura');

    //Previsiones de corte
    // Para ver las previsiones de corte
    Route::get('/previsiones', 'PrevisionController@misPrevisiones')->name('previsionesCorte')->middleware('auth');
    // Para mostrar el formulario de creación de una nueva previsión
    Route::get('/previsiones/crear', 'PrevisionController@crearPrevision')->name('previsionesCrear')->middleware('auth');
    // Para guardar una nueva previsión
    Route::post('/previsiones', 'PrevisionController@guardarPrevision')->name('previsionesGuardar')->middleware('auth');
    // Para editar una previsión existente
    Route::put('/previsiones/{linea}/editar', 'PrevisionController@editarPrevision')->name('previsionesEditar')->middleware('auth');
    // Para actualizar una previsión existente
    Route::put('/previsiones/{linea}', 'PrevisionController@actualizarPrevision')->name('previsionesActualizar')->middleware('auth');
    // Para eliminar una previsión

});    

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/clientes', 'ClienteController@index')->name('clientes.index');
    Route::get('/clientes/{id}/edit', 'ClienteController@edit')->name('clientes.edit');
    Route::post('/clientes/{id}', 'ClienteController@update')->name('clientes.update');
});