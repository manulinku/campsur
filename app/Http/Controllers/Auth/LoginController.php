<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/menu';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Definir que el campo de usuario es 'CODIGO'
    protected function username()
    {
        return 'CODIGO';
    }

    // Modificar el método de autenticación para omitir el hash
    protected function credentials(Request $request)
    {
        // Recuperar el usuario por el código
        $user = User::where('CODIGO', $request->input('CODIGO'))->first();

        // Si el usuario existe y la contraseña coincide (sin hash)
        if ($user && $user->PASSWORD === $request->input('PASSWORD')) {
            return $request->only('CODIGO', 'PASSWORD');
        }

        // Si las credenciales no coinciden, devolvemos un array vacío
        return [];
    }

    // Modificar la respuesta en caso de fallo de login
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only('CODIGO', 'remember'))
            ->withErrors([
                'CODIGO' => 'Las credenciales no son correctas.',  // Mensaje personalizado
            ]);
    }

    // Iniciar sesión manualmente (puedes usar este método si no funciona el anterior)
    public function login(Request $request)
    {
        $credentials = $request->only('CODIGO', 'PASSWORD');

        // Buscar usuario por código y verificar contraseña sin hash
        $user = User::where('CODIGO', $credentials['CODIGO'])->first();
        
        if ($user && Hash::check($credentials['PASSWORD'], $user->PASSWORD)) {
            Auth::login($user);
            return redirect()->intended($this->redirectTo);
            
        }
        return $this->sendFailedLoginResponse($request);
    }
}
