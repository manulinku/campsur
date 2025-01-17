<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunicado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ComunicadoController extends Controller
{
    public function index()
    {
        $comunicados = Comunicado::orderBy('fecha_publicacion', 'desc')->get();
        return view('comunicados.index', compact('comunicados'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('comunicados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagenes' => 'nullable|array', // Aceptar imágenes
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120', // Validación de las imágenes
        ]);

        // Crear el comunicado
        $comunicado = Comunicado::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'fecha_publicacion' => Carbon::now(),
            
        ]);
        $fecha = Carbon::parse($comunicado->fecha_publicacion);
        $fecha->setTimezone('Europe/Madrid');

        $imagenesRutas = [];

        // Subir imágenes si existen
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $image) {
                $imagePath = $image->store('comunicados', 'public', 'fecha'); // Guardar la imagen
                $imagenesRutas[] = $imagePath; // Agregar la ruta de la imagen al arreglo
            }
        }

        // Guardar las rutas de las imágenes en la columna 'imagenes' de la tabla 'comunicados'
        if (!empty($imagenesRutas)) {
            $comunicado->imagenes = json_encode($imagenesRutas); // Guardar como JSON
            $comunicado->save();
        }

        return redirect()->route('comunicados.index')->with('success', 'Comunicado creado con éxito.');
    }

    public function destroy($id)
    {
        // Verificar si el usuario es admin
        $this->authorizeAdmin();

        // Buscar el comunicado por su ID
        $comunicado = Comunicado::findOrFail($id);

        // Eliminar las imágenes asociadas
        $imagenes = json_decode($comunicado->imagenes, true);
        if ($imagenes) {
            foreach ($imagenes as $imagen) {
                // Eliminar las imágenes de la carpeta de almacenamiento
                Storage::disk('public')->delete($imagen);
            }
        }

        // Eliminar el comunicado
        $comunicado->delete();

        // Redirigir de nuevo con un mensaje de éxito
        return redirect()->route('comunicados.index')->with('success', 'Comunicado eliminado con éxito.');
    }

    private function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(404);
        }
    }
}
