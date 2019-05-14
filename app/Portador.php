<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portador extends Model
{
    protected $fillable = ['CodEmp','CodPor','DesPor','CodBan','AgeCta','NumCta','ArqRem','CtlRem','ModRem','SitPor','GerRem'
    ,'CodUsu','DtaCad','HorCad','UsuAtu','DtaAtu','HorAtu'];
    protected $table = 'e017cadpor';
    public $timestamps = false;
}
