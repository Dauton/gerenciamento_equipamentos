<?php

namespace App\Http\Controllers;

use App\Models\Avaria;
use App\Models\Colaborador;
use App\Models\Departamento;
use App\Models\Equipamento;
use App\Models\Site;
use App\Models\Turno;
use App\Models\Usuario;

class DadosCadastrosController extends Controller
{

    // CONTAGEM DAS ÁREAS CADASTRADAS
    // CONTA USUÁRIOS CADASTRADOS
    public static function contaUsuarios()
    {
        $contagem = Usuario::count();
        return $contagem;
    }

    // CONTA SITES CADASTRADOS
    public static function contaSites()
    {
        $contagem = Site::count();
        return $contagem;
    }

    // CONTA DEPARTAMENTOS CADASTRADOS
    public static function contaDepartamentos()
    {
        $contagem = Departamento::count();
        return $contagem;
    }

    // CONTA TURNOS CADASTRADOS
    public static function contaTurnos()
    {
        $contagem = Turno::count();
        return $contagem;
    }

    // CONTA EQUIPAMENTOS CADASTRADOS
    public static function contaEquipamentos()
    {
        $contagem = Equipamento::count();
        return $contagem;
    }

    // CONTA AVARIAS CADASTRADOS
    public static function contaAvarias()
    {
        $contagem = Avaria::count();
        return $contagem;
    }

    // CONTA COLABORADORES CADASTRADOS
    public static function contaColaboradores()
    {
        $contagem = Colaborador::count();
        return $contagem;
    }

    //_________________________________________________________________________________________


    // ÚLTIMO CADASTRADO DAS ÁREAS

    // ÚLTIMO USUÁRIO CADASTRADO
    public static function ultimoCadastroUsuario()
    {
        $buscaItens = Usuario::get('usuario');
        $ultimo = $buscaItens->isEmpty() ? null : $buscaItens->last()->usuario;
        return $ultimo;
    }

    // ÚLTIMO SITE CADASTRADO
    public static function ultimoCadastroSite()
    {
        $buscaItens = Site::get('descricao');
        $ultimo = $buscaItens->isEmpty() ? null : $buscaItens->last()->descricao;
        return $ultimo;
    }

    // ÚLTIMO DEPARTAMENTO CADASTRADO
    public static function ultimoCadastroDepartamento()
    {
        $buscaItens = Departamento::get('departamento');
        $ultimo = $buscaItens->isEmpty() ? null : $buscaItens->last()->departamento;
        return $ultimo;
    }

    // ÚLTIMO TURNO CADASTRADO
    public static function ultimoCadastroTurno()
    {
        $buscaItens = Turno::get('turno');
        $ultimo = $buscaItens->isEmpty() ? null : $buscaItens->last()->turno;
        return $ultimo;
    }

    // ÚLTIMO EQUIPAMENTO CADASTRADO
    public static function ultimoCadastroEquipamento()
    {
        $buscaItens = Equipamento::get('patrimonio');
        $ultimo = $buscaItens->isEmpty() ? null : $buscaItens->last()->patrimonio;
        return $ultimo;
    }

    // ÚLTIMA AVARIA CADASTRADA
    public static function ultimoCadastroAvaria()
    {
        $buscaItens = Avaria::get('avaria');
        $ultimo = $buscaItens->isEmpty() ? null : $buscaItens->last()->avaria;
        return $ultimo;
    }

    // ÚLTIMO COLABORADOR CADASTRADO
    public static function ultimoCadastroColaborador()
    {
        $buscaItens = Colaborador::get('nome_colaborador');
        $ultimo = $buscaItens->isEmpty() ? null : $buscaItens->last()->nome_colaborador;
        return $ultimo;
    }

    // DESATIVA O COLABORADOR TEMPORÁRIO AUTOMATICAMENTE CONFORME DATA.
    public static function desativaColaboradorOnDate()
    {
        Colaborador::where('desativar_em', '<=', now())->update([
            'status' => 'DESATIVADO'
        ]);
    }
}
