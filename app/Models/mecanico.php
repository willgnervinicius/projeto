<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mecanico extends Model
{
  protected $table = 'mecanico';
  protected $fillable =  ['nome', 'situacao', 'obs'];

}
