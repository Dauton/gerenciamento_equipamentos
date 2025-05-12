<?php

namespace App\Http\Controllers\CRUDControllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ComponentesControllers\InputValidationsController;
use App\Models\Departamento;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DepartamentosController extends Controller
{
    // CADASTRO DE DEPARTAMENTO
    public function createDepartamento(Request $request)
    {
        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsDepartamento($request);

        $departamento = $request->input('departamento');
        $created_by = session('usuario.nome');

        Departamento::insert([
            'departamento' => trim(mb_strtoupper($departamento)),
            'created_by' => $created_by
        ]);

        return redirect(route('create-departamento'))->with('alertSuccess', 'Departamento cadastrado com sucesso.');
    }

    // EDIÇÃO DEPARTAMENTO
    public function editDepartamento(Request $request, $id)
    {
        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsUpdateDepartamento($request, $id);

        $departamento = $request->input('departamento');
        $updated_at = date('Y-m-d H:i:s');

        Departamento::where('id', $id)->update([
            'departamento' => trim(mb_strtoupper($departamento)),
            'updated_at' => $updated_at
        ]);

        return redirect(route('create-departamento'))->with('alertSuccess', 'Departamento editado com sucesso.');
    }

    // EXCLUSÃO DE DEPARTAMENTO
    public function deleteDepartamento($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        Departamento::where('id', $id)->delete();
        return redirect(route('create-departamento'))->with('alertSuccess', 'Departamento excluído com sucesso.');
    }
}
