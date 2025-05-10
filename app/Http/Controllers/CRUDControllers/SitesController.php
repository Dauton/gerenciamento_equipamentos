<?php

namespace App\Http\Controllers\CRUDControllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ComponentesControllers\InputValidationsController;
use App\Models\Site;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SitesController extends Controller
{

    // CADASTRO DE SITE
    public function createSite(Request $request)
    {
        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsSite($request);

        $descricao = $request->input('descricao');
        $created_by = session('usuario.nome');

        Site::insert([
            'descricao' => trim(mb_strtoupper($descricao)),
            'created_by' => $created_by
        ]);

        return redirect(route('create-site'))->with('alertSuccess', 'Site cadastrado com sucesso.');
    }

    // EDIÇÃO DE SITE
    public function updateSite(Request $request, $id)
    {
        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsUpdateSite($request, $id);

        $descricao = $request->input('descricao');

        Site::where('id', $id)->update([
            'descricao' => trim(mb_strtoupper($descricao)),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect(route('create-site'))->with('alertSuccess', 'Site editado com sucesso.');
    }

    // EXCLUSÃO O SITE
    public function deleteSite($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        Site::where('id', $id)->delete();
        return redirect(route('create-site'))->with('alertSuccess', 'Site excluído com sucesso.');
    }
}
