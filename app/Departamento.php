<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = ['CodEmp','CodDep','NomDep','SitDep'
    ,'CodUsu','DtaCad','HorCad','UsuAtu','DtaAtu','HorAtu'];
    protected $table = 'e008caddep';
    public $timestamps = false;
}
