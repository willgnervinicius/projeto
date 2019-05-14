<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filial extends Model
{
    protected $fillable = ['CodEmp','CodFil','RazSoc','NomFan','CodCli','CodFor','CgcFil','RamAtv',
                            'InsEst','InsMun','InsSuf','NumTel','NumFax','IntNet','FilMat','SitFil',
                            'CepFil','EndFil','NumFil','CplFil','BaiFil','CidFil','UfsFil','CodPai','MunIbg',
                            'CodUsu','DtaCad','HorCad','UsuAtu','DtaAtu','HorAtu'];
    
    protected $table = 'e002cadfil';
    public $timestamps = false;
}
