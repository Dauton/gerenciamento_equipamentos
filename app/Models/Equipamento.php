<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'sys_db_equipment';

    public static function listaEquipamentos()
    {

        return self::from('sys_db_equipment AS equipamentos')->
                     select('sde_inventory_number AS patrimonio', 'sde_serial_number AS serialnumber', 'sdet_name AS nome_tipo')->

                     join('sys_db_equipment_type AS tipos', 'equipamentos.sde_sdet_id', '=', 'tipos.sdet_id')->
                     join('sys_db_unit AS sites', 'equipamentos.sde_sdu_id', '=', 'sites.sdu_id')->
                     
                     where('sdu_name', session('usuario.site'))->
                     whereNotIn('sdet_name', [
                        'ACCSESS POINT',
                        'ADAPTADOR WIRELESS',
                        'BASE DE CARREGAMENTO',
                        'TV',
                        'PROJETOR',
                        'SWITCH',
                        'NOBREAK',
                        'SERVIDOR',
                        'FIREWALL'
                        ])->
                     where('sdet_name', 'NOT LIKE', '%IMPRESSORA%')->
                     orderBy('nome_tipo', 'asc')->
                     get();
    }
}
