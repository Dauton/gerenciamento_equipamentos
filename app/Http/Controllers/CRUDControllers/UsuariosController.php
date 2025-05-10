<?php

namespace App\Http\Controllers\CRUDControllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ComponentesControllers\InputValidationsController;
use App\Models\Usuario;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UsuariosController extends Controller
{

    // CADASTRO DE USUÁRIO
    public function createUser(Request $request)
    {
        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsCreateUser($request);

        $nome = $request->input('nome');
        $usuario = $request->input('usuario');
        $email = $request->input('email');
        $site = $request->input('site');
        $perfil = $request->input('perfil') ?: 'OPERAÇÃO';
        $senha = $request->input('senha');
        $status = 'ATIVADO';
        $created_by = session('usuario.nome');

        Usuario::insert([
            'nome' => trim(mb_strtoupper($nome)),
            'usuario' => trim(mb_strtoupper($usuario)),
            'email' => trim(mb_strtoupper($email)),
            'site' => trim(mb_strtoupper($site)),
            'perfil' => trim(mb_strtoupper($perfil)),
            'senha' => trim(password_hash($senha, PASSWORD_ARGON2ID)),
            'status' => $status,
            'created_by' => $created_by
        ]);

        return redirect(route("create-usuario"))->with('alertSuccess', 'Usuário cadastrado com sucesso.');
    }

    // EDIÇÃO DE USUÁRIO
    public function updateUser(Request $request, $id)
    {

        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsUpdateUser($request, $id);

        $nome = $request->input('nome');
        $usuario = $request->input('usuario');
        $email = $request->input('email');
        $site = $request->input('site');
        $perfil = $request->input('perfil') ?: 'OPERAÇÃO';

        Usuario::where('id', $id)->update([
            'nome' => trim(mb_strtoupper($nome)),
            'usuario' => trim(mb_strtoupper($usuario)),
            'email' => trim(mb_strtoupper($email)),
            'site' => trim(mb_strtoupper($site)),
            'perfil' => trim(mb_strtoupper($perfil))
        ]);

        return redirect(route("create-usuario"))->with('alertSuccess', 'Usuário editado com sucesso.');
    }

    // EXCLUSÃO DE USUÁRIO
    public function deleteUsuario($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        Usuario::where('id', $id)->delete();
        return redirect(route("create-usuario"))->with('alertSuccess', 'Usuário excluído com sucesso.');
    }
}
