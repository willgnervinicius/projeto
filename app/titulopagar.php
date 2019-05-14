<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class titulopagar extends Model
{
    protected  $table = 'e504titpag';
    protected $primaryKey = ['CodEmp','CodFil','CodFor','NumTit','TipTit'];
    public $timestamps = false;
    protected $fillable =  ['CodEmp', 'CodFil', 'CodFor','NumTit','TipTit','SitTit','TriDar'
    ,'CodCcu','DtaEnt','DtaVct','ProPag','DatApr','VlrOri','VlrJur','VlrMul','VlrDes','VlrPag'
    ,'CodPor','CodCar','CodBan','AgeCta','NumCta','CodBar','CtrInt','NumRem','OrdCom'
    ,'NumNfe','SerNfe','CodUsu','DtaCad','HorCad'
];
}
