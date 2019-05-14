<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'e003cadcli';
    protected $primaryKey = ['CodEmp', 'CodFil','CodCli','CgcCpf'];
    public $timestamps = false;
    protected $fillable =  ['CodEmp', 'CodFil', 'CodCli','RazSoc','TipCli','RamAtv','TriIcm','CgcCpf'];
}
