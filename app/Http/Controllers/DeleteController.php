<?php

namespace App\Http\Controllers;

use App\Models\Avaria;
use App\Models\Colaborador;
use App\Models\Departamento;
use App\Models\Equipamento;
use App\Models\Site;
use App\Models\Turno;
use App\Models\Usuario;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class DeleteController extends Controller
{
    // EXCLUI O USUÁRIO
    public function deleteUsuario($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        Usuario::where('id', $id)->delete();
        return redirect('/usuarios')->with('alertSuccess', 'Usuário excluído com sucesso.');
    }

    // EXCLUI O SITE
    public function deleteSite($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        Site::where('id', $id)->delete();
        return redirect('/sites')->with('alertSuccess', 'Site excluído com sucesso.');
    }

    // EXCLUI A AVARIA
    public function deleteAvaria($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        Avaria::where('id', $id)->delete();
        return redirect('/avarias')->with('alertSuccess', 'Avaria excluída com sucesso.');
    }

    // EXCLUI O TURNO
    public function deleteTurno($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        Turno::where('id', $id)->delete();
        return redirect('/turnos')->with('alertSuccess', 'Turno excluído com sucesso.');
    }

    // EXCLUI O DEPARTAMENTO
    public function deleteDepartamento($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        Departamento::where('id', $id)->delete();
        return redirect('/departamentos')->with('alertSuccess', 'Departamento excluído com sucesso.');
    }

    // EXCLUI O EQUIPAMENTO
    public function deleteEquipamento($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        Equipamento::where('id', $id)->delete();
        return redirect('/equipamentos')->with('alertSuccess', 'Equipamento excluído com sucesso.');
    }

    // EXLCUI COLABORADOR
    public function deleteColaborador($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException) {
            return redirect()->back()->with('alertError', 'Ops! algo deu errado.');
        }

        Colaborador::where('id', $id)->delete();
        return redirect('/colaboradores')->with('alertSuccess', 'Colaborador excluído com sucesso.');
    }
}
