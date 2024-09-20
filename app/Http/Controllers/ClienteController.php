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
            'NOMBRE' => 'string|max:200',
            'PAIS' => 'numeric|digits_between:1,11',
            'TIPOPROV' => 'numeric|digits_between:1,11',
            'PUNTOVENTA' => 'numeric|digits_between:1,11',
            'COD_UN' => 'numeric|digits_between:1,11',
            'CIF' => 'string|max:20',
            'COD_UN2' => 'numeric|digits_between:1,11',
            'KMTOTAL' => 'numeric|regex:/^\d{1,10}(\.\d{1,4})?$/',
            'KMFRONTERA' => 'numeric|regex:/^\d{1,10}(\.\d{1,4})?$/',
            'PRKMINT' => 'numeric|regex:/^\d{1,10}(\.\d{1,4})?$/',
            'PASSWORD' => 'string|min:9',
            'role' => 'string|max:141',
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
