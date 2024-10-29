<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prevision;
use App\Articulo; // Asumiendo que tienes un modelo Articulo
use Auth;

    class PrevisionController extends Controller
{
    // Mostrar las previsiones del proveedor logueado
    public function misPrevisiones()
    {
        $user = auth()->user();
        $rol = $user->role;

        // Obtener la fecha actual y restar 15 días
        $fechaLimite = now()->subDays(15);

        if ($rol === 'admin') {
            // Obtener todas las previsiones de los últimos 15 días, excluyendo las que tienen NOTAS = 'B' o están vacías
            $previsiones = Prevision::with('articulo', 'proveedor')
                ->where('FECHA', '>=', $fechaLimite)
                ->where(function ($query) {
                    $query->where('NOTAS', '!=', 'B')
                        ->orWhereNull('NOTAS') // También incluye registros donde NOTAS está vacía
                        ->orWhere('NOTAS', ''); // Incluye registros donde NOTAS es una cadena vacía
                })
                ->get()
                ->groupBy('COD_PROV');
        } else {
            // Obtener previsiones del usuario sin las que tienen NOTAS = 'B' o están vacías
            $previsiones = Prevision::where('COD_PROV', $user->CODIGO)
                ->where('FECHA', '>=', $fechaLimite)
                ->where(function ($query) {
                    $query->where('NOTAS', '!=', 'B')
                        ->orWhereNull('NOTAS')
                        ->orWhere('NOTAS', '');
                })
                ->with('articulo')
                ->get();
        }
        return view('previsiones.index', compact('previsiones'));
    }



    // Mostrar formulario para añadir previsión
    public function crearPrevision()
    {
        $articulos = Articulo::pluck('DESCRIPCION', 'CODIGO'); // Para el desplegable de artículos
        return view('previsiones.create', compact('articulos'));
    }

    // Guardar nueva previsión en la base de datos
    public function guardarPrevision(Request $request)
    {
        $validated = $request->validate([
            'FECHA' => 'required|date',
            'COD_ART' => 'required|exists:ARTICULOS,CODIGO',
            'CANTIDAD' => 'required|numeric|min:1',
        ]);

        Prevision::create([
            'FECHA' => $request->FECHA,
            'COD_PROV' => Auth::user()->CODIGO,
            'COD_ART' => $request->COD_ART,
            'CANTIDAD' => $request->CANTIDAD,
        ]);

        return redirect()->route('previsionesCorte')->with('success', 'Previsión creada correctamente');
    }

    // Editar previsión existente
    public function editarPrevision($id)
    {
        $prevision = Prevision::findOrFail($id);

        // Verificar si el proveedor autenticado es el propietario de la previsión
        if ($prevision->COD_PROV !== auth()->user()->CODIGO) {
            return redirect()->route('previsionesCorte')->with('error', 'No tienes permiso para editar esta previsión.');
        }

        // Lógica para obtener los artículos y mostrar la vista de edición
        $articulos = Articulo::all();
        return view('previsiones.edit', compact('prevision', 'articulos'));
    }



    // Actualizar previsión existente en la base de datos
    // Realmente hace un update, lo que conseguimos con esto es un borrado suave
    public function borrarPrevision($linea)
    {
        // Buscar la previsión por LINEA
        $prevision = Prevision::where('LINEA', $linea)->firstOrFail();

        // Modificar solo el campo NOTAS
        $prevision->NOTAS = 'B';
        
        // Guardar los cambios
        $prevision->save();

        return redirect()->route('previsionesCorte')->with('success', 'Campo NOTAS actualizado correctamente.');
    }



    // Eliminar previsión 
    //#### NO LO USAMOS PORQUE SE HA DE UTILIZAR UN BORRADO SUAVE EN LA BASE DE DATOS ###
    //### CUANDO SE QUIERA BORRAR UN REGISTRO SE MODIFICARÁ EL CAMPO NOTAS DE LA TABLA DE PREVISIONES A UNA "B" ###
//     public function eliminarPrevision($id)
// {
//     $prevision = Prevision::findOrFail($id);

//     // Verificar si el proveedor autenticado es el propietario de la previsión
//     if ($prevision->COD_PROV !== auth()->user()->CODIGO) {
//         return redirect()->route('previsionesCorte')->with('error', 'No tienes permiso para eliminar esta previsión.');
//     }

//     // Eliminar la previsión
//     $prevision->delete();
//     return redirect()->route('previsionesCorte')->with('success', 'Previsión eliminada correctamente.');
// }


}

