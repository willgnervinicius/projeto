<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    
    protected $fillable = ['NomFan','CgcMat','GruEmp','SitEmp','CodUsu','DtaCad','HorCad','UsuAtu','DtaAtu','HorAtu'];
    protected $guarded = ['CodEmp'];
    protected $table = 'e001cademp';
    public $timestamps = false;
}
