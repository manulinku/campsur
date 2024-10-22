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
    Route::get('/previsiones/{linea}/editar', 'PrevisionController@editarPrevision')->name('previsionesEditar')->middleware('auth');
    // Para actualizar una previsión existente
    Route::put('/previsiones/{linea}', 'PrevisionController@actualizarPrevision')->name('previsionesActualizar')->middleware('auth');
    // Para eliminar una previsión
    Route::delete('/previsiones/{linea}', 'PrevisionController@eliminarPrevision')->name('previsionesEliminar')->middleware('auth');

});    

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/clientes', 'ClienteController@index')->name('clientes.index');
    Route::get('/clientes/{id}/edit', 'ClienteController@edit')->name('clientes.edit');
    Route::post('/clientes/{id}', 'ClienteController@update')->name('clientes.update');
});