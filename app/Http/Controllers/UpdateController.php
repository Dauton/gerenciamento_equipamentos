<?php

namespace App\Http\Controllers;

use App\Models\Avaria;
use App\Models\Colaborador;
use App\Models\Departamento;
use App\Models\Equipamento;
use App\Models\Site;
use App\Models\Turno;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UpdateController extends Controller
{

    // UPDATE USUÁRIO
    public function updateUser(Request $request, $id)
    {

        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsUpdateUser($request, $id);

        $nome = $request->input('nome');
        $usuario = $request->input('usuario');
        $email = $request->input('email');
        $site = $request->input('site');
        $perfil = $request->input('perfil');

        Usuario::where('id', $id)->update([
            'nome' => trim(mb_strtoupper($nome)),
            'usuario' => trim(mb_strtoupper($usuario)),
            'email' => trim(mb_strtoupper($email)),
            'site' => trim(mb_strtoupper($site)),
            'perfil' => trim(mb_strtoupper($perfil))
        ]);

        return redirect('usuarios')->with('alertSuccess', 'Usuário editado com sucesso.');

    }

    // UPDATE SITE
    public function updateSite(Request $request, $id)
    {
        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsUpdateSite($request, $id);

        $descricao = $request->input('descricao');

        Site::where('id', $id)->update([
            'descricao' => trim(mb_strtoupper($descricao)),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect('sites')->with('alertSuccess', 'Site editado com sucesso.');
    }

    // UPDATE AVARIA
    public function updateAvaria(Request $request, $id)
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

        return redirect('avarias')->with('alertSuccess', 'Avaria editada com sucesso.');
    }

    // UPDATE TURNO
    public function updateTurno(Request $request, $id)
    {
        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsUpdateTurno($request, $id);

        $turno = $request->input('turno');
        $updated_at = date('Y-m-d H:i:s');

        Turno::where('id', $id)->update([
            'turno' => trim(mb_strtoupper($turno)),
            'updated_at' => $updated_at
        ]);

        return redirect('turnos')->with('alertSuccess', 'Turno editado com sucesso.');
    }

    // UPDATE DEPARTAMENTO
    public function updateDepartamento(Request $request, $id)
    {
        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsUpdateDepartamento($request, $id);

        $departamento = $request->input('departamento');
        $updated_at = date('Y-m-d H:i:s');

        Departamento::where('id', $id)->update([
            'departamento' => trim(mb_strtoupper($departamento)),
            'updated_at' => $updated_at
        ]);

        return redirect('departamentos')->with('alertSuccess', 'Departamento editado com sucesso.');
    }

    // UPDATE EQUIPAMENTO
    public function updateEquipamento(Request $request, $id)
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

        return redirect('equipamentos')->with('alertSuccess', 'Equipamento editado com sucesso.');
    }

    // UPDATE COLABORADOR
    public function updateColaborador(Request $request, $id)
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
            return redirect('colaboradores')->with('alertSuccess', 'Colaborador editado e ATIVADO com sucesso.');

        // DESATIVA COLABORADOR
        } elseif($dasativar_em < now()) {
            Colaborador::where('id', $id)->update([
                'status' => 'DESATIVADO'
            ]);
            return redirect('colaboradores')->with('alertSuccess', 'Colaborador editado e DESATIVADO com sucesso.');

        }
    }
}
