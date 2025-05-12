<?php

namespace App\Http\Controllers\CRUDControllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ComponentesControllers\InputValidationsController;
use App\Models\Avaria;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AvariasController extends Controller
{
    // CADASTRO DE AVARIA
    public function createAvaria(Request $request)
    {
        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsAvaria($request);

        $avaria = $request->input('avaria');
        $tipo_avaria = $request->input('tipo_avaria');
        $created_by = session('usuario.nome');

        Avaria::insert([
            'avaria' => trim(mb_strtoupper($avaria)),
            'tipo_avaria' => trim(mb_strtoupper($tipo_avaria)),
            'created_by' => $created_by
        ]);

        return redirect(route('create-avaria'))->with('alertSuccess', 'Avaria cadastrada com sucesso.');
    }

    // EDIÇÃO DE AVARIA
    public function editAvaria(Request $request, $id)
    {

        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsUpdateAvaria($request, $id);

        $avaria = $request->input('avaria');
        $tipo_avaria = $request->input('tipo_avaria');

        Avaria::where('id', $id)->update([
            'avaria' => trim(mb_strtoupper($avaria)),
            'tipo_avaria' => trim(mb_strtoupper($tipo_avaria)),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect(route('create-avaria'))->with('alertSuccess', 'Avaria editada com sucesso.');
    }

    // EXCUSÃO DE AVARIA
    public function deleteAvaria($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        Avaria::where('id', $id)->delete();
        return redirect(route("create-avaria"))->with('alertSuccess', 'Avaria excluída com sucesso.');
    }
}
