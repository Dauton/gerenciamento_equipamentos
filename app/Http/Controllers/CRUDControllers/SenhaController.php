<?php

namespace App\Http\Controllers\CRUDControllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ComponentesControllers\InputValidationsController;
use App\Models\Usuario;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SenhaController extends Controller
{

    // EDIÇÃO DE SENHA
    public function editSenha(Request $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->with('alertError', 'Ops! algo deu errado.');
        }

        InputValidationsController::validationsUpdateSenha($request);

        $senha = $request->input('senha');
        $updated_at = now();

        Usuario::where('id', $id)->update([
            'senha' => password_hash($senha, PASSWORD_ARGON2ID),
            'updated_at' => $updated_at
        ]);

        if ($id == session('usuario.id')) {
            return redirect(route('homepage'))->with('alertSuccess', 'Senha resetada com sucesso.');
        }
        return redirect(route("edit-usuario", Crypt::encrypt($id)))->with('alertSuccess', 'Senha resetada com sucesso.');
    }
}
