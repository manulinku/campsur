<?php

use Illuminate\Support\Facades\Route;

// Página de inicio
Route::get('/', function () {
    return view('auth.login');
});

// Otras rutas de la aplicación
Route::get('sobre-nosotros', function () {
    return view('sobre-nosotros');
});
Route::get('contacto', function () {
    return view('contacto');
});

// Rutas de autorización para el Usuario
Auth::routes();

Route::middleware('auth')->group(function () {
// Ruta para el dashboard o página de inicio después de login
    Route::get('/menu', 'HomeController@index')->name('menu');
    Route::get('/albaranes', 'HomeController@albaranes')->name('albaranes');
    Route::get('/albaranes/{NUMERO}/{SERIE}', 'HomeController@mostrarAlbaran')->name('mostrarAlbaran');
    Route::get('/movimientos/{codigo_proveedor}', 'HomeController@mostrarMovimientos')->name('movimientos.envase.palet');
    Route::get('/product-graph', 'HomeController@showProductGraph')->name('product.graph');
    Route::get('/modelo-347', 'HomeController@mostrarModelo347')->name('modelo-347');
    //En caso de que se quieran facturas #####-actualización 08/01/2025 si se quieren facturas hay que modificarlo para que coja la serie al igual que hace con los albaranes###
    // Route::get('/facturas', 'HomeController@facturas')->name('facturas');
    // Route::get('/facturas/{NUMERO}', 'HomeController@mostrarFactura')->name('mostrarFactura');

    //Previsiones de corte
    // Para ver las previsiones de corte
    Route::get('/previsiones', 'PrevisionController@misPrevisiones')->name('previsionesCorte')->middleware('auth');
    // Para mostrar el formulario de creación de una nueva previsión
    Route::get('/previsiones/crear', 'PrevisionController@crearPrevision')->name('previsionesCrear')->middleware('auth');
    // Para guardar una nueva previsión
    Route::post('/previsiones', 'PrevisionController@guardarPrevision')->name('previsionesGuardar')->middleware('auth');
    // Para Eliminar una previsión existente
    Route::get('/previsiones/{linea}/editar', 'PrevisionController@borrarPrevision')->name('previsionesEliminar')->middleware('auth');
    // Para actualizar una previsión existente
    Route::put('/previsiones/{linea}', 'PrevisionController@actualizarPrevision')->name('previsionesActualizar')->middleware('auth');
    // Para eliminar una previsión

    //Rutas para las comunicaciones
    Route::get('/notificaciones', 'NotificacionController@index')->name('notificaciones.index');
    Route::get('/notificaciones/create', 'NotificacionController@create')->name('notificaciones.create');
    Route::get('/clientes/autocomplete', 'NotificacionController@autocomplete')->name('clientes.autocomplete');
    Route::post('/notificaciones', 'NotificacionController@store')->name('notificaciones.store');
    Route::patch('/notificaciones/{id}/read', 'NotificacionController@markAsRead')->name('notificaciones.read');

    //Rutas para los comunicados
    Route::get('/comunicados', 'ComunicadoController@index')->name('comunicados.index');
    Route::get('/comunicados/create', 'ComunicadoController@create')->name('comunicados.create');
    Route::post('/comunicados', 'ComunicadoController@store')->name('comunicados.store');
    Route::delete('comunicados/{id}', 'ComunicadoController@destroy')->name('comunicados.destroy');

});    

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/clientes', 'ClienteController@index')->name('clientes.index');
    Route::get('/clientes/{id}/edit', 'ClienteController@edit')->name('clientes.edit');
    Route::post('/clientes/{id}', 'ClienteController@update')->name('clientes.update');
});