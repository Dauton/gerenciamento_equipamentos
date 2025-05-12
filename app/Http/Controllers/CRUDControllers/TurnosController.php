<?php

namespace App\Http\Controllers\CRUDControllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ComponentesControllers\InputValidationsController;
use App\Models\Turno;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TurnosController extends Controller
{

    // CADASTRO DE TURNO
    public function createTurno(Request $request)
    {
        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsTurno($request);

        $turno = $request->input('turno');
        $created_by = session('usuario.nome');

        Turno::insert([
            'turno' => trim(mb_strtoupper($turno)),
            'created_by' => $created_by
        ]);

        return redirect(route('create-turno'))->with('alertSuccess', 'Turno cadastrado com sucesso.');
    }

    // EDIÇÃO DE TURNO
    public function editTurno(Request $request, $id)
    {
        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsUpdateTurno($request, $id);

        $turno = $request->input('turno');
        $updated_at = date('Y-m-d H:i:s');

        Turno::where('id', $id)->update([
            'turno' => trim(mb_strtoupper($turno)),
            'updated_at' => $updated_at
        ]);

        return redirect(route('create-turno'))->with('alertSuccess', 'Turno editado com sucesso.');
    }

    // EXCLUSÃO DE TURNO
    public function deleteTurno($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        Turno::where('id', $id)->delete();
        return redirect(route('create-turno'))->with('alertSuccess', 'Turno excluído com sucesso.');
    }
}
