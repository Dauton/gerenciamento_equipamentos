<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SenhaController extends Controller
{
    public function updateSenha(Request $request, $id)
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

        if($id == session('usuario.id')) {
            return redirect(route('homepage'))->with('alertSuccess', 'Senha resetada com sucesso.');
        }
            return redirect("update-usuario/" . Crypt::encrypt($id))->with('alertSuccess', 'Senha resetada com sucesso.');
    }
}
