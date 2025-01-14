<?php

// app/Http/Controllers/NotificacionController.php
namespace App\Http\Controllers;

use App\Notificacion;
use App\User;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
        public function create()
    {
        $this->authorizeAdmin(); // Asegurarse de que el usuario sea admin

        // Obtén los clientes con role 'user' y ordénalos alfabéticamente por 'NOMBRE'
        $clientes = User::where('role', 'user')
                        ->orderBy('NOMBRE', 'asc') // Ordenar alfabéticamente
                        ->get();

        // Obtén el mensaje de sesión si existe
        $message = session('success'); 

        // Pasa los datos a la vista
        return view('notificaciones.create', compact('clientes', 'message'));
    }



    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'titulo' => 'required|max:255',
            'mensaje' => 'required',
            'user_id' => 'required|exists:PROVEEDORES,CODIGO',
        ]);

        Notificacion::create($request->all());

        return redirect()->route('notificaciones.create')->with('success', 'Notificación creada exitosamente');
    }

    public function index()
    {
        $user = auth()->user();
        $notificaciones = Notificacion::where('user_id', $user->CODIGO)->get();
        return view('notificaciones.index', compact('notificaciones'));
    }

    public function markAsRead($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        if ($notificacion->user_id === auth()->user()->CODIGO) {
            $notificacion->update(['visto' => true]);
        }
        return redirect()->route('notificaciones.index');
    }

    private function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(404);
        }
    }
}
