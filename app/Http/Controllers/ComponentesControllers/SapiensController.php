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
        // usu_dessit = status[ativo, demitido, ferias etc...]
        $stmt = self::sapiensConn()->prepare("SELECT DISTINCT usu_numcad, usu_nomfun FROM usu_tcadfun WHERE usu_dessit = ? AND usu_nomfil = ? ORDER BY usu_nomfun");
        $stmt->bindValue(1, 'Ativo');
        $stmt->bindValue(2, session('usuario.site'));
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // LISTAGEM DE SITES VIA SAPIENS
    public static function listaSites()
    {
        // usu_nomfil = filial ex: CDARCEX
        // usu_tcadfun = tabela
        $stmt = self::sapiensConn()->prepare("SELECT DISTINCT usu_nomfil FROM usu_tcadfun WHERE usu_nomfil != '' ORDER BY usu_nomfil");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
