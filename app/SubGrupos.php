<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubGrupos extends Model
{
    protected $fillable = ['CodEmp','CodGru','NomSub','SitSub'
    ,'CodUsu','DtaCad','HorCad','UsuAtu','DtaAtu','HorAtu'];
    protected $table = 'e008cadsub';
    public $timestamps = false;
}
