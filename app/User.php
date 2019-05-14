<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected  $table = 'E999CadUsu';
    protected $primaryKey = 'CodUsu';
    public $timestamps = false;
    use Notifiable;

    public function getAuthPassword() {
      return $this->SenUsu;
    }

     public function setPasswordAttribute($value) {
        $this->attributes['SenUsu'] = Hash::make($value);
     }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'CodUsu',
        'NomUsu',
        'CgcCpf',
        'SenUsu',
        'IntNet',
        'SitUsu',
        'DatCad',
        'UsuCad',
        'FotUsu',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'SenUsu', 'remember_token',
    ];
}
