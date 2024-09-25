<?php

namespace App\Http\Controllers;

use App\User;
use App\Albaran;
use App\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('menu');
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
}
