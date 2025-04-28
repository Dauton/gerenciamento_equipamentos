<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'sys_db_equipment';
}
