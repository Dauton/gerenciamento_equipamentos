<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    // EXECUÇÃO DE VALIDAÇÃO DE LOGIN
    public function submitLogin(Request $request)
    {

        InputValidationsController::validationsLogin($request);

        $usuario = $request->input('usuario');
        $senha = $request->input('senha');

        $error = redirect()->back()->withInput()->with('loginError', 'Credenciais inválidas.');

        $buscaUsuario = Usuario::where('usuario', $usuario)->first();

        if(!$buscaUsuario) {
            return $error;
        }

        if(!password_verify($senha, $buscaUsuario->senha)) {
            return $error;
        }

        session([
            'usuario' => [
                'id' => $buscaUsuario->id,
                'nome' => $buscaUsuario->nome,
                'usuario' => $buscaUsuario->usuario,
                'email' => $buscaUsuario->email,
                'site' => $buscaUsuario->site,
                'perfil' => $buscaUsuario->perfil,
                'status' => $buscaUsuario->status
            ]
        ]);

        $buscaUsuario->ultimo_login = date('Y-m-d H:i:s');
        $buscaUsuario->save();

        return redirect(route('homepage'));
    }

    // EXECUÇÃO DE LOGOUT
    public function logout()
    {
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/')->with('alertSuccess', 'Você saiu do sistema com sucesso.');
    }
}
