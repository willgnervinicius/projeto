<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = ['CodEmp','CodDep','CodGru','NomGru','SitGru'
    ,'CodUsu','DtaCad','HorCad','UsuAtu','DtaAtu','HorAtu'];
    protected $table = 'e008cadgru';
    public $timestamps = false;
}
