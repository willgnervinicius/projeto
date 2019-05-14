<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $fillable = ['CodEmp','CodBan','NomFan','CgcCpf','CodUsu','DtaCad','HorCad','UsuAtu','DtaAtu','HorAtu'];
    protected $table = 'e018cadban';
    public $timestamps = false;
}
