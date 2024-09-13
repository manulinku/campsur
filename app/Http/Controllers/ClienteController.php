<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    // Mostrar la lista de clientes
    public function index()
    {
        $clientes = User::all();
        return view('clientes.index', compact('clientes'));
    }

    // Mostrar el formulario para editar un cliente
    public function edit($id)
    {
        $cliente = User::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    // Actualizar los datos del cliente
    public function update(Request $request, $id)
    {
        $cliente = User::findOrFail($id);

        $validatedData = $request->validate([
            'NOMBRE' => 'required|string|max:35',
            'PAIS' => 'required|numeric|digits_between:1,4',
            'TIPOCLI' => 'required|numeric|digits_between:1,4',
            'PUNTOVENTA' => 'required|numeric|digits_between:1,4',
            'AGENTE' => 'required|numeric|digits_between:1,4',
            'CODSEGURO' => 'nullable|numeric',
            'SOLVENCIA' => 'nullable|numeric',
            'RSOLICITADO' => 'nullable|numeric',
            'RCONCEDIDO' => 'nullable|numeric',
            'COD_UN' => 'required|numeric|digits_between:1,4',
            'CIF' => 'required|string|max:9',
            'KMTOTAL' => 'required|numeric|digits_between:1,4',
            'KMFRONTERA' => 'required|numeric|digits_between:1,4',
            'PRKMINT' => 'required|numeric|digits_between:1,4',
            'PASSWORD' => 'string|min:9',
        ]);

        if (!empty($request->PASSWORD)) {
            $validatedData['PASSWORD'] = Hash::make($request->PASSWORD); // Cifrar la nueva contraseña
        } else {
            unset($validatedData['PASSWORD']); // No actualizar el campo si no se proporciona una nueva contraseña
        }

        $cliente->update($validatedData);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }
}
