<?php

namespace App\Http\Controllers\ViewsControllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ComponentesControllers\SapiensController;
use App\Http\Controllers\ComponentesControllers\DadosCadastrosController;
use App\Models\Avaria;
use App\Models\Colaborador;
use App\Models\Departamento;
use App\Models\Equipamento;
use App\Models\Relatorio;
use App\Models\RelatorioPermanente;
use App\Models\Site;
use App\Models\Turno;
use App\Models\Usuario;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class ShowPagesController extends Controller
{

    // LOGIN PAGE
    public function loginPage()
    {
        return view('login');
    }

    // HOMEPAGE PAGE
    public function entregaEquipamentoPage()
    {
        DadosCadastrosController::desativaColaboradorOnDate();

        $equipamentos = Equipamento::select('sde_inventory_number', 'sde_serial_number')->orderBy('sde_inventory_number', 'asc')->get();
        $colaboradores = SapiensController::listaColaboradores();
        $colaboradores_temporarios = Colaborador::where('site_colaborador', session('usuario.site'))->where('status', 'ATIVADO')->get();
        $turnos = Turno::all();
        $departamentos = Departamento::all();
        $relatorios = Relatorio::where('data_devolucao', null)->where('site', session('usuario.site'))->get();
        return view(
            'entregas/entrega-temporario',
            compact('equipamentos', 'colaboradores', 'colaboradores_temporarios', 'turnos', 'departamentos', 'relatorios')
        );
    }

    // DEVOLVE EQUIPAMENTO PAGE
    public function devolveEquipamentoPage($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->with('alertError', 'Ops!, algo deu errado');
        }

        $idRelatorio = Relatorio::where('id', $id)->first();
        $exibir = Relatorio::all()->where('id', $id);
        $avarias = Avaria::orderBy('tipo_avaria')->get();

        // CASO HAJA A TENTATIVA DE ACESSAR UM RELATÓRIO JÁ CONCLUÍDO
        if (!empty($exibir->first()->data_devolucao)) {
            return redirect()->back()->with('alertError', 'Esse equipamento já foi devolvido.');
        }

        return view('entregas/devolve-temporario', compact('idRelatorio', 'exibir', 'avarias'));
    }

    // RELATORIOS PAGE
    public function relatoriosPage()
    {
        $relatorios = Relatorio::limit(0)->get();
        $sites = SapiensController::listaSites();
        $equipamentos = Equipamento::select('sde_inventory_number', 'sde_serial_number')->orderBy('sde_inventory_number', 'asc')->get();
        return view('relatorios/temporarias', compact('relatorios', 'sites', 'equipamentos'));
    }

    // ENTREGA EQUIPAMENTO PERMANENTE PAGE
    public function entregaEquipamentoPermanentePage()
    {
        $equipamentos = Equipamento::select('sde_inventory_number', 'sde_serial_number')->orderBy('sde_inventory_number', 'asc')->get();
        $colaboradores = SapiensController::listaColaboradores();
        $turnos = Turno::all();
        $departamentos = Departamento::all();
        $sites = SapiensController::listaSites();
        $relatoriosPermanentes = RelatorioPermanente::where('site', session('usuario.site'))->where('data_devolucao', null)->get();
        return view(
            'entregas/entrega-permanente',
            compact('equipamentos', 'colaboradores', 'turnos', 'departamentos', 'sites', 'relatoriosPermanentes')
        );
    }

    // DEVOLVE EQUIPAMENTO PERMANENTE PAGE
    public function devolveEquipamentoPermanentePage($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->with('alertError', 'Ops!, algo deu errado');
        }

        $idRelatorio = RelatorioPermanente::where('id', $id)->first();
        $exibir = RelatorioPermanente::all()->where('id', $id);
        $avarias = Avaria::orderBy('tipo_avaria')->get();

        // CASO HAJA A TENTATIVA DE ACESSAR UM EQUIPAMENTO JÁ DEVOLVIDO
        if (!empty($exibir->first()->data_devolucao)) {
            return redirect()->back()->with('alertError', 'Esse equipamento já foi devolvido.');
        }

        return view('entregas/devolve-permanente', compact('idRelatorio', 'exibir', 'avarias'));
    }

    // RELATORIOS DE ENTREGAS PERMANENTES PAGE
    public function relatoriosPermanentesPage()
    {
        $relatoriosPermanentes = Relatorio::limit(0)->get();
        $sites = SapiensController::listaSites();
        $equipamentos = Equipamento::select('sde_inventory_number', 'sde_serial_number')->orderBy('sde_inventory_number', 'asc')->get();
        $colaboradores = SapiensController::listaColaboradores();
        return view('relatorios/permanentes', compact('relatoriosPermanentes', 'sites', 'equipamentos', 'colaboradores'));
    }


    // CADASTROS PAGE
    public function cadastrosPage()
    {
        $contagemUsuarios = DadosCadastrosController::contaUsuarios();
        $contagemSites = DadosCadastrosController::contaSites();
        $contagemDepartamentos = DadosCadastrosController::contaDepartamentos();
        $contagemTurnos = DadosCadastrosController::contaTurnos();
        $contagemAvarias = DadosCadastrosController::contaAvarias();
        $contagemEquipamentos = DadosCadastrosController::contaEquipamentos();
        $contagemColaboradores = DadosCadastrosController::contaColaboradores();

        $ultimoCadastroUsuario = DadosCadastrosController::ultimoCadastroUsuario();
        $ultimoCadastroSite = DadosCadastrosController::ultimoCadastroSite();
        $ultimoCadastroDepartamento = DadosCadastrosController::ultimoCadastroDepartamento();
        $ultimoCadastroTurno = DadosCadastrosController::ultimoCadastroTurno();
        //$ultimoCadastroEquipamento = DadosCadastrosController::ultimoCadastroEquipamento();
        $ultimoCadastroAvaria = DadosCadastrosController::ultimoCadastroAvaria();
        $ultimoCadastroColaborador = DadosCadastrosController::ultimoCadastroColaborador();

        return view('cadastros', compact(
            'contagemUsuarios',
            'contagemSites',
            'contagemDepartamentos',
            'contagemTurnos',
            'contagemEquipamentos',
            'contagemAvarias',
            'contagemColaboradores',

            'ultimoCadastroUsuario',
            'ultimoCadastroSite',
            'ultimoCadastroDepartamento',
            'ultimoCadastroTurno',
            //'ultimoCadastroEquipamento',
            'ultimoCadastroAvaria',
            'ultimoCadastroColaborador'
        ));
    }

    // USERS PAGE
    public function usuariosPage()
    {
        $perfil_usuario = session('usuario.perfil');
        $site_usuario = session('usuario.site');

        if ($perfil_usuario === 'ADMIN') {
            $exibir = Usuario::all();
        } else {
            $exibir = Usuario::where('site', $site_usuario)->get();
        }

        $sites = SapiensController::listaSites();
        return view('usuarios/create', compact('exibir', 'sites'));
    }

    // SITES PAGE
    public function sitesPage()
    {

        $exibir = Site::all();
        return view('sites/create', compact('exibir'));
    }

    // AVARIAS PAGE
    public function avariasPage()
    {
        $exibir = Avaria::all();
        return view('avarias/create', compact('exibir'));
    }

    // TURNOS PAGE
    public function turnosPage()
    {
        $exibir = Turno::all();
        return view('turnos/create', compact('exibir'));
    }

    // DEPARTAMENTOS PAGE
    public function departamentosPage()
    {
        $exibir = Departamento::all();
        return view('departamentos/create', compact('exibir'));
    }

    // EQUIPAMENTOS PAGES
    public function equipamentosPage()
    {
        $exibir = Equipamento::all();
        $sites = SapiensController::listaSites();
        return view('equipamentos/create', compact('exibir', 'sites'));
    }

    public function colaboradoresPage()
    {
        $colaboradores = Colaborador::all();
        $sites = SapiensController::listaSites();
        return view('colaboradores/create', compact('colaboradores', 'sites'));
    }

    // _________________________________________________________________________________________________________________


    // EDIT PASSWORD USER PAGE
    public function editPasswordPage($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        $exibir = Usuario::where('id', $id)->first();
        return view('senhas/edit', compact('exibir'));
    }

    // EDIT USER PAGE
    public function editUsuarioPage($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        $exibir = Usuario::where('id', $id)->first();
        $sites = SapiensController::listaSites();
        return view('usuarios/edit', compact('exibir', 'sites'));
    }

    // EDIT SITE PAGE
    public function editSitePage($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        $exibir = Site::where('id', $id)->first();
        return view('sites/edit', compact('exibir'));
    }

    // EDIT AVARIA PAGE
    public function editAvariaPage($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        $exibir = Avaria::where('id', $id)->first();
        return view('avarias/edit', compact('exibir'));
    }

    // EDIT TURNO PAGE
    public function editTurnoPage($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        $exibir = Turno::where('id', $id)->first();
        return view('turnos/edit', compact('exibir'));
    }

    // EDIT DEPARTAMENTO PAGE
    public function editDepartamentoPage($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        $exibir = Departamento::where('id', $id)->first();
        return view('departamentos/edit', compact('exibir'));
    }

    // EDIT EQUIPAMENTO PAGE
    public function editEquipamentoPage($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        $exibir = Equipamento::where('id', $id)->first();
        $sites = SapiensController::listaSites();
        return view('equipamentos/edit', compact('exibir', 'sites'));
    }

    // EDIT COLABORADOR PAGE
    public function editColaboradorPage($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        $exibir = Colaborador::where('id', $id)->first();
        $sites = SapiensController::listaSites();
        return view('colaboradores/edit', compact('exibir', 'sites'));
    }
}
