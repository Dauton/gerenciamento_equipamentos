<?php

namespace App\Http\Controllers\ComponentesControllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AlterarSiteController extends Controller
{

    // ALTERAR O SITE DE VISUALIZAÇÃO
    public function alterarSiteSessao(Request $request)
    {

        InputValidationsController::validationsAlterarSite($request);

        $site = $request->input('site');

        Usuario::where('id', session('usuario.id'))->update(
            [
                'site' => $site
            ]
        );

        $atualizado = Usuario::where('id', session('usuario.id'))->first();

        session()->forget('usuario');
        session()->regenerate();

        session([
            'usuario' => [
                'id' => $atualizado->id,
                'nome' => $atualizado->nome,
                'usuario' => $atualizado->usuario,
                'email' => $atualizado->email,
                'site' => $atualizado->site,
                'perfil' => $atualizado->perfil,
                'status' => $atualizado->status
            ]
        ]);

        return redirect(route('homepage'))->with('alertSuccess', "Site alterado para $site com sucesso.");
    }
}
