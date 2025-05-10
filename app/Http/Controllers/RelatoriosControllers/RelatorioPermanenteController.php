<?php

namespace App\Http\Controllers\RelatoriosControllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ComponentesControllers\InputValidationsController;
use App\Http\Controllers\ComponentesControllers\SapiensController;
use App\Models\Equipamento;
use App\Models\RelatorioPermanente;
use Illuminate\Http\Request;

class RelatorioPermanenteController extends Controller
{
    public function entregaEquipamentoPermanente(Request $request)
    {

        InputValidationsController::validationsEntregaEquipamentoPermanente($request);

        $site = session('usuario.site');
        $equipamento = $request->input('equipamento');
        $colaborador = $request->input('colaborador');
        $departamento = $request->input('departamento');
        $turno = $request->input('turno');
        $agente_entrega = session('usuario.nome');

        // LÓGICA DO TERMO DE RESPONSABILIDADE
        $arquivo_gravado = null;

        if (isset($_FILES['termo_responsabilidade']) && $_FILES['termo_responsabilidade']['error'] === UPLOAD_ERR_OK) {
            $termo_responsabilidade = $_FILES['termo_responsabilidade'];
            $nome = $termo_responsabilidade['name'];
            $tmp_name = $termo_responsabilidade['tmp_name'];

            $extensao = pathinfo($nome, PATHINFO_EXTENSION);
            $novo_nome = 'TERMO_' . date('d-m-Y-') . uniqid() . '.' . $extensao;

            move_uploaded_file($tmp_name, "assets/uploads/docs/$novo_nome");
            $arquivo_gravado = "assets/uploads/docs/$novo_nome";
        }

        // VERIFICA SE O EQUIPAMENTO ESTÁ LIVRE
        $verifica_disponibilidade = RelatorioPermanente::where('equipamento', $equipamento)->where('data_devolucao', null)->first();
        if (!empty($verifica_disponibilidade)) {
            return redirect('entrega-permanente')->withInput()->with('alertError', 'Esse equipamento já foi entregue a um colaborador.');
        }

        RelatorioPermanente::insert([
            'site' => $site,
            'equipamento' => $equipamento,
            'colaborador' => $colaborador,
            'departamento' => $departamento,
            'turno' => $turno,
            'agente_entrega' => $agente_entrega,
            'termo_responsabilidade' => $arquivo_gravado
        ]);

        return redirect('entrega-permanente')->with('alertSuccess', "Equipamento entregue para $colaborador.");
    }


    public function devolveEquipamentoPermanente(Request $request, $id)
    {

        // VALIDAÇÃO DOS CAMPOS
        InputValidationsController::validationsDevolveEquipamento($request);

        $agente_devolucao = session('usuario.nome');
        $avaria = $request->input('avaria');

        // LÓGICA DA FOTO DA AVARIA
        $foto_avaria = $_FILES['foto_avaria'];
        $nome = $foto_avaria['name'];
        $tmp_name = $foto_avaria['tmp_name'];

        $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        $novo_nome = date('d-m-Y-') . uniqid() . '.' . $extensao;
        move_uploaded_file($tmp_name, "assets/uploads/images/$novo_nome");
        $arquivo_gravado = "assets/uploads/images/$novo_nome";

        // CASO NÃO HOUVER AVARIA
        if ($request->input('ha_avaria') === 'NÃO') {
            $avaria = 'NÃO';
            $arquivo_gravado = null;
        }

        RelatorioPermanente::where('id', $id)->update([
            'agente_devolucao' => $agente_devolucao,
            'data_devolucao' => now(),
            'avaria' => $avaria,
            'foto_avaria' => $arquivo_gravado
        ]);

        return redirect('entrega-permanente')->with('alertSuccess', "Equipamento devolvido com sucesso.");
    }

    // BUSCA RELATÓRIOS DE ENTREGAS PERMANENTES
    public function buscaRelatorioPermanente(Request $request)
    {
        $site = $request->input('site');
        $equipamento = $request->input('equipamento');
        $colaborador = $request->input('colaborador');

        $query = RelatorioPermanente::query()->limit(200);
        if ($site) {
            $query->where('site', $site);
        }
        if ($equipamento) {
            $query->where('equipamento', $equipamento);
        }
        if ($colaborador) {
            $query->where('colaborador', $colaborador);
        }

        $relatoriosPermanentes = $query->orderBy('data_devolucao')->get();
        $sites = SapiensController::listaSites();
        $equipamentos = Equipamento::select('sde_inventory_number', 'sde_serial_number')->orderBy('sde_inventory_number', 'asc')->get();
        $colaboradores = SapiensController::listaColaboradores();

        if (count($relatoriosPermanentes) < 1) {
            return view('relatorios/permanentes', [
                'relatoriosPermanentes' => $relatoriosPermanentes,
                'sites' => $sites,
                'equipamentos' => $equipamentos,
                'colaboradores' => $colaboradores,
                'alertError' => 'Nenhum valor encontrado para os dados buscados.'
            ]);
        }
        return view('relatorios/permanentes', [
            'relatoriosPermanentes' => $relatoriosPermanentes,
            'sites' => $sites,
            'equipamentos' => $equipamentos,
            'colaboradores' => $colaboradores,
            'alertInfo' => 'Exibindo relatório conforme dados buscados.'
        ]);
    }
}
