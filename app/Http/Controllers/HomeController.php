<?php

namespace App\Http\Controllers;

use App\User;
use App\Albaran;
use App\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
{
    $user = Auth::user(); // Obtiene el usuario logueado

    // Si el usuario tiene un rol de 'user', obtener el proveedor correspondiente
    if ($user->role === 'user') {
        $codigo_proveedor = $user->CODIGO; // Asigna el código del proveedor
    } else {
        $codigo_proveedor = null; // O puedes asignar un valor por defecto o null
    }

    return view('menu', compact('codigo_proveedor'));
}

    public function albaranes()
    {
        $usuario = Auth::user();

        if ($usuario && $usuario->role === 'admin') {
            $albaranes = Albaran::with('proveedor')->get();
        } else {
            $proveedor_codigo = $usuario->CODIGO;
            $albaranes = Albaran::with('proveedor')->where('COD_PROV', $proveedor_codigo)->get();
        }

        $albaranesPorProveedor = $albaranes->groupBy('COD_PROV');

        return view('albaranes', [
            'albaranesPorProveedor' => $albaranesPorProveedor,
            'user' => $usuario
        ]);
    }

    public function mostrarAlbaran($NUMERO)
    {
        $usuario = Auth::user();
        $albaran = Albaran::with('proveedor')->findOrFail($NUMERO);
        $lineas = $albaran->lineas;

        return view('detalle_albaran', [
            'albaran' => $albaran,
            'lineas' => $lineas,
            'user' => $usuario,
        ]);
    }

    public function facturas()
    {
        $usuario = Auth::user();

        if ($usuario && $usuario->role === 'admin') {
            $facturas = Factura::with('proveedor')->get(); // Cambié Factura por FacturaProv
        } else {
            $proveedor_codigo = $usuario->CODIGO;
            $facturas = Factura::with('proveedor')->where('COD_PROV', $proveedor_codigo)->get();
        }

        $facturasPorProveedor = $facturas->groupBy('COD_PROV');

        return view('facturas', [
            'facturasPorProveedor' => $facturasPorProveedor,
            'user' => $usuario
        ]);
    }

    public function mostrarFactura($NUMERO)
    {
    $usuario = Auth::user();

    // Encuentra la factura por su NUMFAC
    $factura = Albaran::where('NUMFAC', $NUMERO)->firstOrFail(); // Asegúrate de que el campo sea correcto

    $bruto = $factura->BRUTO;
    $tasa_dto = $factura->TDTO;
    $dto = $factura->DTO;
    $base = $factura->BASE;
    $tasa_irpf = $factura->TRET;
    $irpf = $factura->RET;
    $iva = $factura->IVA;
    $total = $factura->TOTALEUR;

    // Cargar las líneas del albarán asociado a la factura
    $lineas = $factura->lineas; // O la relación que hayas definido para las líneas

    return view('detalle_factura', [
        'factura' => $factura,
        'lineas' => $lineas,
        'bruto'=> $bruto,
        'tasa_dto'=> $tasa_dto ,
        'dto'=> $dto ,
        'base'=>$base ,
        'tasa_irpf'=> $tasa_irpf,
        'irpf' => $irpf, 
        'iva'=> $iva ,
        'total' => $total,
        'user' => $usuario
    ]);
    }

        public function mostrarMovimientos($codigo_proveedor)
    {
        // Obtener el proveedor autenticado
        $proveedorAutenticado = Auth::user();

        // Verificar que el proveedor autenticado tiene acceso a este código
        if ($proveedorAutenticado->CODIGO != $codigo_proveedor) {
            return view('movimientos_envase_palet', [
                'movimientos' => [], // Pasar un array vacío para evitar errores en la tabla
                'error' => 'No tienes permisos para ver los movimientos de este proveedor.',
            ]);
        }

        // Continúa con el código existente si pasa la validación
        $proveedor = User::where('CODIGO', $codigo_proveedor)->first();

        // Obtener todos los proveedores relacionados
        $proveedoresRelacionados = User::where('COD_UN', $proveedor->CODIGO)
            ->orWhere('CODIGO', $proveedor->COD_UN)
            ->pluck('CODIGO')
            ->push($proveedor->CODIGO); // Aseguramos que el proveedor logueado también esté en la lista

        // Obtener los movimientos de envases (TE = 'E')
        $movimientosEnvases = DB::table('LIN_ENV_PROV as lep')
            ->select(
                'lep.TE',
                DB::raw("CASE WHEN lep.TE = 'E' THEN e.COD_UN ELSE p.COD_UN END AS COD_UN"),
                DB::raw("CASE 
                            WHEN lep.TE = 'E' THEN e.DESCRIPCION 
                            ELSE p.DESCRIPCION 
                        END AS DESCRIPCION_PADRE"),
                DB::raw('SUM(COALESCE(lep.RETIRA, 0)) as TOTAL_RETIRA'),
                DB::raw('SUM(COALESCE(lep.ENTREGA, 0)) as TOTAL_ENTREGA')
            )
            ->leftJoin('ENVASES as e', function ($join) {
                $join->on('lep.CODIGO', '=', 'e.CODIGO')
                    ->where('lep.TE', '=', 'E');
            })
            ->leftJoin('PALETS as p', function ($join) {
                $join->on('lep.CODIGO', '=', 'p.CODIGO')
                    ->where('lep.TE', '=', 'P');
            })
            ->join('ENVASES_PROV as ep', 'lep.NUMERO', '=', 'ep.NUMERO')
            ->whereIn('ep.COD_PROV', $proveedoresRelacionados)
            ->where('lep.TE', '=', 'E')  // Filtrar solo envases
            ->groupBy('lep.TE', 'COD_UN', 'DESCRIPCION_PADRE')
            ->get();

        // Obtener los movimientos de palets (TE = 'P')
        $movimientosPalets = DB::table('LIN_ENV_PROV as lep')
            ->select(
                'lep.TE',
                DB::raw("CASE WHEN lep.TE = 'P' THEN p.COD_UN ELSE e.COD_UN END AS COD_UN"),
                DB::raw("CASE 
                            WHEN lep.TE = 'P' THEN p.DESCRIPCION 
                            ELSE e.DESCRIPCION 
                        END AS DESCRIPCION_PADRE"),
                DB::raw('SUM(COALESCE(lep.RETIRA, 0)) as TOTAL_RETIRA'),
                DB::raw('SUM(COALESCE(lep.ENTREGA, 0)) as TOTAL_ENTREGA')
            )
            ->leftJoin('ENVASES as e', function ($join) {
                $join->on('lep.CODIGO', '=', 'e.CODIGO')
                    ->where('lep.TE', '=', 'E');
            })
            ->leftJoin('PALETS as p', function ($join) {
                $join->on('lep.CODIGO', '=', 'p.CODIGO')
                    ->where('lep.TE', '=', 'P');
            })
            ->join('ENVASES_PROV as ep', 'lep.NUMERO', '=', 'ep.NUMERO')
            ->whereIn('ep.COD_PROV', $proveedoresRelacionados)
            ->where('lep.TE', '=', 'P')  // Filtrar solo palets
            ->groupBy('lep.TE', 'COD_UN', 'DESCRIPCION_PADRE')
            ->get();

        // Obtener los movimientos adicionales de entregas desde LIN_ALB_PROV para envases
        $movimientosAdicionalesEnvases = DB::table('LIN_ALB_PROV as lap')
            ->select(
                DB::raw("'E' as TE"), // Tipo de envase
                DB::raw("COALESCE(e.COD_UN, lap.COD_ENV) as COD_UN"), 
                'ep.DESCRIPCION as DESCRIPCION_PADRE',
                DB::raw('0 as TOTAL_RETIRA'), // No hay retiradas en este caso
                DB::raw('SUM(COALESCE(lap.BULTOS, 0)) as TOTAL_ENTREGA')
            )
            ->leftJoin('ENVASES as e', 'lap.COD_ENV', '=', 'e.CODIGO')
            ->leftJoin('ENVASES as ep', 'e.COD_UN', '=', 'ep.CODIGO')
            ->whereIn('lap.NUMERO', function ($query) use ($proveedoresRelacionados) {
                $query->select('NUMERO')
                    ->from('ALBARAN_PROV')
                    ->whereIn('COD_PROV', $proveedoresRelacionados);
            })
            ->groupBy('lap.COD_ENV', 'ep.DESCRIPCION', 'e.COD_UN')
            ->get();

        // Obtener los movimientos adicionales de entregas desde LIN_ALB_PROV para palets
        $movimientosAdicionalesPalets = DB::table('LIN_ALB_PROV as lap')
            ->select(
                DB::raw("'P' as TE"), // Tipo de palet
                DB::raw("COALESCE(p.COD_UN, lap.COD_PAL) as COD_UN"),
                'pp.DESCRIPCION as DESCRIPCION_PADRE',
                DB::raw('0 as TOTAL_RETIRA'),
                DB::raw('SUM(COALESCE(lap.PALETS, 0)) as TOTAL_ENTREGA')
            )
            ->leftJoin('PALETS as p', 'lap.COD_PAL', '=', 'p.CODIGO')
            ->leftJoin('PALETS as pp', 'p.COD_UN', '=', 'pp.CODIGO')
            ->whereIn('lap.NUMERO', function ($query) use ($proveedoresRelacionados) {
                $query->select('NUMERO')
                    ->from('ALBARAN_PROV')
                    ->whereIn('COD_PROV', $proveedoresRelacionados);
            })
            ->groupBy('lap.COD_PAL', 'pp.DESCRIPCION', 'p.COD_UN')
            ->get();

        // Combinar los movimientos de envases
        $movimientosEnvasesCombinados = collect($movimientosEnvases)
            ->merge($movimientosAdicionalesEnvases)
            ->groupBy('COD_UN')
            ->map(function ($items) {
                return (object)[
                    'TE' => 'E',
                    'DESCRIPCION_PADRE' => $items[0]->DESCRIPCION_PADRE,
                    'TOTAL_RETIRA' => $items->sum('TOTAL_RETIRA'),
                    'TOTAL_ENTREGA' => $items->sum('TOTAL_ENTREGA'),
                ];
            })
            ->values(); // Reindexar la colección

        // Combinar los movimientos de palets
        $movimientosPaletsCombinados = collect($movimientosPalets)
            ->merge($movimientosAdicionalesPalets)
            ->groupBy('COD_UN')
            ->map(function ($items) {
                return (object)[
                    'TE' => 'P',
                    'DESCRIPCION_PADRE' => $items[0]->DESCRIPCION_PADRE,
                    'TOTAL_RETIRA' => $items->sum('TOTAL_RETIRA'),
                    'TOTAL_ENTREGA' => $items->sum('TOTAL_ENTREGA'),
                ];
            })
            ->values(); // Reindexar la colección

        // Combinar los movimientos de envases y palets
        $movimientos = $movimientosEnvasesCombinados->merge($movimientosPaletsCombinados);

        // Retornar la vista con los movimientos combinados
        return view('movimientos_envase_palet', compact('movimientos', 'proveedorAutenticado'));
    }
}
