<?php

namespace App\Http\Controllers\CRUDControllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ComponentesControllers\InputValidationsController;
use App\Models\Colaborador;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ColaboradoresController extends Controller
{
    // CADASTRO DE COLABORADOR
    public function createColaborador(Request $request)
    {
        InputValidationsController::validationsColaborador($request);

        $nome_colaborador = $request->input('nome_colaborador');
        $matricula_colaborador = $request->input('matricula_colaborador');
        $desativar_em = $request->input('desativar_em');
        $site_colaborador = $request->input('site_colaborador');

        Colaborador::insert([
            'nome_colaborador' => trim(mb_strtoupper($nome_colaborador)) . ' - TEMP',
            'matricula_colaborador' => trim(mb_strtoupper($matricula_colaborador)),
            'site_colaborador' => trim(mb_strtoupper($site_colaborador)),
            'desativar_em' => $desativar_em,
            'status' => 'ATIVADO',
            'created_by' => session('usuario.nome')
        ]);

        return redirect(route('create-colaborador'))->with('alertSuccess', 'Colaborador cadastrado com sucesso.');

    }

    // EDIÇÃO DE COLABORADOR
    public function editColaborador(Request $request, $id)
    {
        // VALIDAÇÕES DOS CAMPOS
        InputValidationsController::validationsUpdateColaborador($request, $id);

        $nome_colaborador = $request->input('nome_colaborador');
        $matricula_colaborador = $request->input('matricula_colaborador');
        $site_colaborador = $request->input('site_colaborador');
        $dasativar_em = $request->input('desativar_em');
        $updated_at = now();

        Colaborador::where('id', $id)->update([
            'nome_colaborador' => trim(mb_strtoupper($nome_colaborador)),
            'matricula_colaborador' => trim(mb_strtoupper($matricula_colaborador)),
            'site_colaborador' => trim(mb_strtoupper($site_colaborador)),
            'desativar_em' => trim(mb_strtoupper($dasativar_em)),
            'updated_at' => $updated_at
        ]);

        // ATIVA COLABORADOR
        if($dasativar_em > now()) {
            Colaborador::where('id', $id)->update([
                'status' => 'ATIVADO'
            ]);
            return redirect(route('create-colaborador'))->with('alertSuccess', 'Colaborador editado e ATIVADO com sucesso.');

        // DESATIVA COLABORADOR
        } elseif($dasativar_em < now()) {
            Colaborador::where('id', $id)->update([
                'status' => 'DESATIVADO'
            ]);
            return redirect(route('create-colaborador'))->with('alertSuccess', 'Colaborador editado e DESATIVADO com sucesso.');

        }
    }

    // EXCLUSÃO DE COLABORADOR
    public function deleteColaborador($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        Colaborador::where('id', $id)->delete();
        return redirect(route('create-colaborador'))->with('alertSuccess', 'Colaborador excluído com sucesso.');
    }
}
