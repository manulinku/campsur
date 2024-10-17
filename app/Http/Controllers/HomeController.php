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
    $proveedor = User::where('CODIGO', $codigo_proveedor)->first();

    // Primero, agrupamos los datos de LIN_ENV_PROV para obtener los retiros y entregas
    $movimientos = DB::table('LIN_ENV_PROV as lep')
        ->select(
            'lep.TE', // Agregamos TE aquí para usarlo en el mapeo
            'lep.CODIGO', // Agregamos CODIGO aquí
            DB::raw("CASE WHEN lep.TE = 'E' THEN e.DESCRIPCION ELSE p.DESCRIPCION END AS DESCRIPCION"),
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
        // Unimos con ENVASES_PROV para obtener COD_PROV
        ->join('ENVASES_PROV as ep', 'lep.NUMERO', '=', 'ep.NUMERO')
        ->where('ep.COD_PROV', $codigo_proveedor) // Filtrar por el proveedor
        ->groupBy('lep.TE', 'lep.CODIGO', 'DESCRIPCION') // Aseguramos que agrupamos por TE y CODIGO
        ->get();

    // Ahora hacemos un segundo paso para obtener los datos de LIN_ALB_PROV
    $movimientos->map(function ($item) use ($codigo_proveedor) {
        // Hacemos la suma de bultos o palets según el tipo
        $totalEntregaAdicional = DB::table('LIN_ALB_PROV as lap')
            ->where(function ($query) use ($item) {
                if ($item->TE === 'E') {
                    $query->where('lap.COD_ENV', '=', $item->CODIGO);
                } else if ($item->TE === 'P') {
                    $query->where('lap.COD_PAL', '=', $item->CODIGO);
                }
            })
            ->sum(DB::raw('CASE WHEN ' . ($item->TE === 'E' ? 'lap.BULTOS' : 'lap.PALETS') . ' IS NOT NULL THEN ' . ($item->TE === 'E' ? 'lap.BULTOS' : 'lap.PALETS') . ' ELSE 0 END'));

        $item->TOTAL_ENTREGA += $totalEntregaAdicional; // Sumar entrega adicional
        return $item;
    });

    return view('movimientos_envase_palet', compact('movimientos', 'proveedor'));
}





}
