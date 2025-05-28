<?php

namespace App\Http\Controllers\ComponentesControllers;

use App\Http\Controllers\Controller;
use PDO;

class SapiensController extends Controller
{

    // CONEXÃO SAPIENS
    private static function sapiensConn()
    {
        $host = "10.60.253.20";
        $database = "sapiens";
        $Uid = "consulta";
        $PWD = "@dM1324";

        return new PDO("odbc:DRIVER={SQL Server}; SERVER=$host; UID=$Uid; PWD=$PWD; DATABASE=$database");
    }

    // LISTAGEM DE COLABORADORES VIA SAPIENS
    public static function listaColaboradores()
    {
        // usu_numcad = matrícula
        // usu_nomfun = nome
        // usu_tcadfun = tabela
        // usu_dessup = turno
        // usu_dessit = situacao[ativo, demitido, ferias etc...]

        $sql = "SELECT DISTINCT funcionarios.usu_numcad, funcionarios.usu_nomfun, funcionarios.usu_dessup, CONVERT(NVARCHAR(100), departamentos.usu_secao) AS usu_secao
                FROM usu_tmotor departamentos
                JOIN usu_tcadfun funcionarios
                ON departamentos.usu_matfun = funcionarios.usu_numcad
                WHERE departamentos.usu_nomfun != ''
                AND funcionarios.usu_dessit = ?
                AND funcionarios.usu_nomfil = ?";

        $stmt = self::sapiensConn()->prepare($sql);
        $stmt->bindValue(1, 'Ativo');
        $stmt->bindValue(2, session('usuario.site'));
        $stmt->execute();
        return mb_convert_encoding($stmt->fetchAll(PDO::FETCH_ASSOC), 'UTF-8', 'ISO-8859-1');
    }

    // LISTAGEM DE SITES VIA SAPIENS
    public static function listaSites()
    {
        // usu_nomfil = filial ex: CDARCEX
        // usu_tcadfun = tabela
        $stmt = self::sapiensConn()->prepare("SELECT DISTINCT usu_nomfil FROM usu_tcadfun WHERE usu_nomfil != '' ORDER BY usu_nomfil");
        $stmt->execute();
        return mb_convert_encoding($stmt->fetchAll(PDO::FETCH_ASSOC), 'UTF-8', 'ISO-8859-1');
    }
}
