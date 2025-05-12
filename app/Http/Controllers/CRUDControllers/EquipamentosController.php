<?php

namespace App\Http\Controllers\CRUDControllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ComponentesControllers\InputValidationsController;
use App\Models\Equipamento;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class EquipamentosController extends Controller
{
    // CADASTRO DE EQUIPAMENTO
    public function createEquipamento(Request $request)
    {

        InputValidationsController::validationsEquipamento($request);

        $marca = $request->input('marca');
        $modelo = $request->input('modelo');
        $serial = $request->input('serial');
        $patrimonio = $request->input('patrimonio');
        $site_equipamento = $request->input('site_equipamento');
        $status = $request->input('status');
        $situacao = 'LIVRE';
        $created_by = session('usuario.nome');

        Equipamento::insert([
            'marca' => trim(mb_strtoupper($marca)),
            'modelo' => trim(mb_strtoupper($modelo)),
            'serial' => trim(mb_strtoupper($serial)),
            'patrimonio' => trim(mb_strtoupper($patrimonio)),
            'site_equipamento' => trim(mb_strtoupper($site_equipamento)),
            'status' => trim(mb_strtoupper($status)),
            'situacao' => $situacao,
            'created_by' => $created_by
        ]);

        return redirect(route('create-equipamento'))->with('alertSuccess', 'Equipamento cadastrado com sucesso.');
    }

    // EDIÇÃO EQUIPAMENTO
    public function editEquipamento(Request $request, $id)
    {
        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsUpdateEquipamento($request, $id);

        $marca = $request->input('marca');
        $modelo = $request->input('modelo');
        $serial = $request->input('serial');
        $patrimonio = $request->input('patrimonio');
        $site_equipamento = $request->input('site_equipamento');
        $status = $request->input('status');
        $updated_at = now();

        Equipamento::where('id', $id)->update([
            'marca' => trim(mb_strtoupper($marca)),
            'modelo' => trim(mb_strtoupper($modelo)),
            'serial' => trim(mb_strtoupper($serial)),
            'patrimonio' => trim(mb_strtoupper($patrimonio)),
            'site_equipamento' => trim(mb_strtoupper($site_equipamento)),
            'status' => trim(mb_strtoupper($status)),
            'updated_at' => $updated_at
        ]);

        return redirect(route('create-equipamento'))->with('alertSuccess', 'Equipamento editado com sucesso.');
    }

    // EXCLUSÃO DE EQUIPAMENTO
    public function deleteEquipamento($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        Equipamento::where('id', $id)->delete();
        return redirect(route('create-equipamento'))->with('alertSuccess', 'Equipamento excluído com sucesso.');
    }
}
