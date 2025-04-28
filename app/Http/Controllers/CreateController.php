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

class CreateController extends Controller
{

    // CADASTRO DE USUÁRIO
    public function createUser(Request $request)
    {
        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsCreateUser($request);

        $nome = $request->input('nome');
        $usuario = $request->input('usuario');
        $email = $request->input('email');
        $site = $request->input('site');
        $perfil = $request->input('perfil');
        $senha = $request->input('senha');
        $status = 'ATIVADO';
        $created_by = session('usuario.nome');

        Usuario::insert([
            'nome' => trim(mb_strtoupper($nome)),
            'usuario' => trim(mb_strtoupper($usuario)),
            'email' => trim(mb_strtoupper($email)),
            'site' => trim(mb_strtoupper($site)),
            'perfil' => trim(mb_strtoupper($perfil)),
            'senha' => trim(password_hash($senha, PASSWORD_ARGON2ID)),
            'status' => $status,
            'created_by' => $created_by
        ]);

        return redirect('usuarios')->with('alertSuccess', 'Usuário cadastrado com sucesso.');

    }

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

        return redirect('sites')->with('alertSuccess', 'Site cadastrado com sucesso.');

    }

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

        return redirect('avarias')->with('alertSuccess', 'Avaria cadastrada com sucesso.');
    }

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

        return redirect('turnos')->with('alertSuccess', 'Turno cadastrado com sucesso.');
    }

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

        return redirect('departamentos')->with('alertSuccess', 'Departamento cadastrado com sucesso.');
    }

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

        return redirect('equipamentos')->with('alertSuccess', 'Equipamento cadastrado com sucesso.');
    }

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

        return redirect('colaboradores')->with('alertSuccess', 'Colaborador cadastrado com sucesso.');

    }
}
