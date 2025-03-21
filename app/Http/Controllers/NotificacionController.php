<?php

// app/Http/Controllers/NotificacionController.php
namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Notificacion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function destroy($id)
    {
        // Verificar si el usuario es admin
        $this->authorizeAdmin();

        // Buscar la notificación por su ID
        $notificacion = Notificacion::findOrFail($id);

        // Eliminar las imágenes asociadas
        $imagenes = json_decode($notificacion->imagenes, true);
        if ($imagenes) {
            foreach ($imagenes as $imagen) {
                // Eliminar las imágenes de la carpeta de almacenamiento
                Storage::disk('public')->delete($imagen);
            }
        }

        // Eliminar la notificación
        $notificacion->delete();

        // Redirigir de nuevo con un mensaje de éxito
        return redirect()->route('notificaciones.index')->with('success', 'Notificación eliminado con éxito.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'imagenes' => 'nullable|array', // Aceptar imágenes
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120', // Validación de las imágenes
        ]);

        // Crear la notificación
        $notificacion = Notificacion::create([
            'titulo' => $request->titulo,
            'mensaje' => $request->mensaje,
            'user_id' => $request->user_id, // Asumiendo que el campo user_id es necesario
        ]);

        $imagenesRutas = [];

        // Subir imágenes si existen
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $image) {
                $imagePath = $image->store('notificaciones', 'public'); // Guardar la imagen
                $imagenesRutas[] = $imagePath; // Agregar la ruta de la imagen al arreglo
            }
        }

        // Guardar las rutas de las imágenes en la columna 'imagenes' de la tabla 'notificaciones'
        if (!empty($imagenesRutas)) {
            $notificacion->imagenes = json_encode($imagenesRutas); // Guardar como JSON
            $notificacion->save();
        }

        return redirect()->route('notificaciones.index')->with('success', 'Notificación creada con éxito.');
    }



        public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // Si es admin, obtener todas las notificaciones y ordenarlas por usuario
            $notificaciones = Notificacion::with('user') // Asegurar que tenga la relación con el usuario
                ->orderBy('user_id', 'asc') // Ordenar por proveedor (usuario que la creó)
                ->get();
        } else {
            // Si es un proveedor, solo mostrar sus notificaciones
            $notificaciones = Notificacion::where('user_id', $user->CODIGO)->get();
        }

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

    public function autocomplete(Request $request)
    {
        // Busca los clientes por nombre que coincidan con el término proporcionado
        $term = $request->get('term');
        $clientes = User::where('role', 'user')
                        ->where('NOMBRE', 'like', '%' . $term . '%')
                        ->limit(10) // Limita la cantidad de resultados
                        ->get();

        $output = '';
        foreach ($clientes as $cliente) {
            $output .= '<div class="autocomplete-item" data-id="' . $cliente->CODIGO . '">' . $cliente->NOMBRE . '</div>';
        }

        return response()->json($output);
    }

    private function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(404);
        }
    }
}
