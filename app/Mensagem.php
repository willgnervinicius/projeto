<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
  protected $table = 'E999CadMsg';
  protected $fillable =  ['CodMsg', 'GruEmp', 'UsuRem','CabMsg','DesMsg','DatCad','DatExc'];
}
