<?php

namespace App\Http\Controllers;

use App\User;
use App\Albaran;
use App\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\LinAlbProv;
use App\Articulo;

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
        $proveedor_codigo = $usuario->CODIGO;
        $albaranes = Albaran::with('proveedor')
        ->where('COD_PROV', $proveedor_codigo)
        ->orderBy('FECHA', 'desc') // Ordenar por FECHA en orden ascendente
        ->get();

        // Agrupar los albaranes por proveedor
        $albaranesPorProveedor = $albaranes->groupBy('COD_PROV');

        return view('albaranes', [
            'albaranesPorProveedor' => $albaranesPorProveedor,
            'user' => $usuario
        ]);
    }

    public function mostrarAlbaran($NUMERO, $SERIE)
    {
        $usuario = Auth::user();

        // Definir las series permitidas
        $permitidas = ['155', '128', '40'];

        // Buscar el albarán con el número y la serie específica
        $albaran = Albaran::with(['proveedor', 'lineas' => function ($query) use ($NUMERO, $SERIE) {
            // Filtrar las líneas del albarán por el número y la serie
            $query->where('NUMERO', $NUMERO)
                ->where('SERIE', $SERIE);  // Asegurarse de que las líneas sean de la serie correcta
        }])
        ->where('NUMERO', $NUMERO)
        ->where('SERIE', $SERIE)
        ->whereIn('SERIE', $permitidas)  // Filtrar las series permitidas
        ->firstOrFail();

        // Obtener las líneas del albarán
        $lineas = $albaran->lineas;

        // Retornar la vista con los detalles
        return view('detalle_albaran', [
            'albaran' => $albaran,
            'lineas' => $lineas,
            'user' => $usuario,
        ]);
    }

    public function facturas()
    {
        $usuario = Auth::user();

        //Si en algún momento se ponen facturas hacer que campsur no vea todas, sino que vea solo las suyas como un proveedor más
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
                'lep.NUMERO',
                'lep.SERIE',
                'ep.COD_PROV',
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
            ->join('ENVASES_PROV as ep', function ($join) {
                $join->on('lep.NUMERO', '=', 'ep.NUMERO')
                    ->on('lep.SERIE', '=', 'ep.SERIE');
            })
            ->whereIn('ep.COD_PROV', $proveedoresRelacionados)
            ->where('lep.TE', '=', 'E')  // Filtrar solo envases
            ->groupBy('lep.TE', 'COD_UN', 'DESCRIPCION_PADRE', 'lep.NUMERO', 'lep.SERIE', 'ep.COD_PROV')
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
                'lep.NUMERO',
                'lep.SERIE',
                'ep.COD_PROV',
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
            ->join('ENVASES_PROV as ep', function ($join) {
                $join->on('lep.NUMERO', '=', 'ep.NUMERO')
                    ->on('lep.SERIE', '=', 'ep.SERIE');
            })
            ->whereIn('ep.COD_PROV', $proveedoresRelacionados)
            ->where('lep.TE', '=', 'P')  // Filtrar solo palets
            ->groupBy('lep.TE', 'COD_UN', 'DESCRIPCION_PADRE', 'lep.NUMERO', 'lep.SERIE', 'ep.COD_PROV')
            ->get();

        // Obtener los movimientos adicionales de entregas desde LIN_ALB_PROV para envases
        $movimientosAdicionalesEnvases = DB::table('LIN_ALB_PROV as lap')
            ->select(
                DB::raw("'E' as TE"), // Tipo de envase
                DB::raw("COALESCE(e.COD_UN, lap.COD_ENV) as COD_UN"),
                'ep.DESCRIPCION as DESCRIPCION_PADRE',
                'lap.SERIE',
                'lap.NUMERO',
                DB::raw('0 as TOTAL_RETIRA'), // No hay retiradas en este caso
                DB::raw('SUM(COALESCE(lap.BULTOS, 0)) as TOTAL_ENTREGA')
            )
            ->leftJoin('ENVASES as e', 'lap.COD_ENV', '=', 'e.CODIGO')
            ->leftJoin('ENVASES as ep', 'e.COD_UN', '=', 'ep.CODIGO')
            ->join('ALBARAN_PROV as ap', function ($join) {
                $join->on('lap.NUMERO', '=', 'ap.NUMERO')
                    ->on('lap.SERIE', '=', 'ap.SERIE');
            })
            ->whereIn('ap.COD_PROV', $proveedoresRelacionados) // Asegurar que el albarán pertenece a un proveedor relacionado
            ->groupBy('lap.COD_ENV', 'ep.DESCRIPCION', 'e.COD_UN', 'lap.SERIE', 'lap.NUMERO')
            ->get();

        // Obtener los movimientos adicionales de entregas desde LIN_ALB_PROV para palets
        $movimientosAdicionalesPalets = DB::table('LIN_ALB_PROV as lap')
            ->select(
                DB::raw("'P' as TE"), // Tipo de palet
                DB::raw("COALESCE(p.COD_UN, lap.COD_PAL) as COD_UN"),
                'pp.DESCRIPCION as DESCRIPCION_PADRE',
                'lap.SERIE',
                'lap.NUMERO',
                DB::raw('0 as TOTAL_RETIRA'), // No hay retiradas en este caso
                DB::raw('SUM(COALESCE(lap.PALETS, 0)) as TOTAL_ENTREGA')
            )
            ->leftJoin('PALETS as p', 'lap.COD_PAL', '=', 'p.CODIGO')
            ->leftJoin('PALETS as pp', 'p.COD_UN', '=', 'pp.CODIGO')
            ->join('ALBARAN_PROV as ap', function ($join) {
                $join->on('lap.NUMERO', '=', 'ap.NUMERO')
                    ->on('lap.SERIE', '=', 'ap.SERIE');
            })
            ->whereIn('ap.COD_PROV', $proveedoresRelacionados) // Filtrar por proveedores relacionados
            ->groupBy('lap.COD_PAL', 'pp.DESCRIPCION', 'p.COD_UN', 'lap.SERIE', 'lap.NUMERO')
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

        public function showProductGraph(Request $request)
    {
        $proveedorId = Auth::user()->CODIGO;

        // Obtener solo los productos relacionados con los albaranes del cliente logueado
        $productos = Articulo::whereIn('CODIGO', function ($query) use ($proveedorId) {
            $query->select('LIN_ALB_PROV.COD_ART')
                ->from('LIN_ALB_PROV')
                ->join('ALBARAN_PROV', 'LIN_ALB_PROV.NUMERO', '=', 'ALBARAN_PROV.NUMERO')
                ->where('ALBARAN_PROV.COD_PROV', $proveedorId)
                ->distinct();
        })->pluck('DESCRIPCION', 'CODIGO');

        // Producto seleccionado (opcional)
        $productoSeleccionado = $request->input('producto');

        // Consultar datos solo si se selecciona un producto
        $data = [];
        $dataPrecioMedio = [];
        $totales = ['kg' => 0, 'importe' => 0, 'precio_medio' => 0];

        if ($productoSeleccionado) {
            $query = LinAlbProv::join('ALBARAN_PROV', 'LIN_ALB_PROV.NUMERO', '=', 'ALBARAN_PROV.NUMERO')
                ->where('ALBARAN_PROV.COD_PROV', $proveedorId)
                ->where('LIN_ALB_PROV.COD_ART', $productoSeleccionado)
                ->selectRaw('MONTH(ALBARAN_PROV.FECHA) as mes, YEAR(ALBARAN_PROV.FECHA) as año, 
                            SUM(LIN_ALB_PROV.CANTIDAD) as total_cantidad, 
                            SUM(LIN_ALB_PROV.IMPORTE) as total_importe')
                ->groupBy('mes', 'año')
                ->orderBy('año')
                ->orderBy('mes')
                ->get();

            // Procesar datos para el primer gráfico
            $data = $query->groupBy('año')->map(function ($items) {
                $resultado = array_fill(1, 12, 0); // Asegura 12 meses con valores por defecto
                foreach ($items as $item) {
                    $resultado[$item->mes] = $item->total_cantidad;
                }
                return $resultado;
            });

            // Procesar datos para el segundo gráfico (precio medio)
            $dataPrecioMedio = $query->groupBy('año')->map(function ($items) {
                $resultado = array_fill(1, 12, 0); // Asegura 12 meses con valores por defecto
                foreach ($items as $item) {
                    $resultado[$item->mes] = $item->total_cantidad > 0
                        ? $item->total_importe / $item->total_cantidad
                        : 0; // Calcular precio medio
                }
                return $resultado;
            });

            // Calcular totales (kg, importe, precio medio)
            $totales['kg'] = $query->sum('total_cantidad');
            $totales['importe'] = $query->sum('total_importe');
            if ($totales['kg'] > 0) {
                $totales['precio_medio'] = $totales['importe'] / $totales['kg'];
            }
        }

        return view('product_graph', compact('productos', 'data', 'dataPrecioMedio', 'productoSeleccionado', 'totales'));
    }



    public function mostrarModelo347()
    {
        $filePath = storage_path('app/public/modelo_347.csv'); // Ajusta la ruta según la ubicación de tu CSV
        $nifCliente = Auth::user()->CIF; // Cambia esto según el nombre del campo del cliente logueado
    
        $datos = [];
        if (($handle = fopen($filePath, 'r')) != false) {
            $header = fgetcsv($handle, 1000, ';'); // Leer la cabecera del archivo CSV

            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                if ($data[0] == $nifCliente) { // Verifica si el NIF coincide
                    $datos[] = [
                        'tipoiva' => $data[1],
                        'titulo' => $data[2],
                        'cpcli' => $data[3],
                        'provincia' => $data[4],
                        'importe' => $data[5],
                        'q1' => $data[6],
                        'q2' => $data[7],
                        'q3' => $data[8],
                        'q4' => $data[9],
                    ];
                }
            }

            fclose($handle);
        }

        return view('modelo_347', compact('datos'));
    }
}
