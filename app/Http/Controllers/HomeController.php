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

//     public function mostrarMovimientos($codigo_proveedor)
// {
//     // Obtener el proveedor
//     $proveedor = User::where('CODIGO', $codigo_proveedor)->first();

//     // Obtener movimientos de envases
//     $movimientosEnvases = DB::table('ENVASES as e')
//         ->leftJoin('LIN_ENV_PROV as lep', 'e.CODIGO', '=', 'lep.CODIGO')
//         ->leftJoin('ALBARAN_PROV as ap', 'lep.NUMERO', '=', 'ap.NUMERO')
//         ->select(
//             'e.CODIGO',
//             'e.DESCRIPCION',
//             DB::raw('SUM(CASE WHEN lep.ENTREGA = 1 THEN lep.CANTIDAD ELSE 0 END) as TOTAL_ENTREGA'),
//             DB::raw('SUM(CASE WHEN lep.RETIRA = 1 THEN lep.CANTIDAD ELSE 0 END) as TOTAL_RETIRA')
//         )
//         ->where('ap.COD_PROV', $codigo_proveedor)
//         ->groupBy('e.CODIGO', 'e.DESCRIPCION')
//         ->get();

//     // Obtener movimientos de palets
//     $movimientosPalets = DB::table('PALETS as p')
//         ->leftJoin('LIN_ENV_PROV as lep', 'p.CODIGO', '=', 'lep.CODIGO')
//         ->leftJoin('ALBARAN_PROV as ap', 'lep.NUMERO', '=', 'ap.NUMERO')
//         ->select(
//             'p.CODIGO',
//             'p.DESCRIPCION',
//             DB::raw('SUM(CASE WHEN lep.ENTREGA = 1 THEN lep.CANTIDAD ELSE 0 END) as TOTAL_ENTREGA'),
//             DB::raw('SUM(CASE WHEN lep.RETIRA = 1 THEN lep.CANTIDAD ELSE 0 END) as TOTAL_RETIRA')
//         )
//         ->where('ap.COD_PROV', $codigo_proveedor)
//         ->groupBy('p.CODIGO', 'p.DESCRIPCION')
//         ->get();

//     return view('movimientos_envase_palet', compact('movimientosEnvases', 'movimientosPalets', 'proveedor'));
// }

//     public function PrevisionesCorte(){
        
//     }

}
