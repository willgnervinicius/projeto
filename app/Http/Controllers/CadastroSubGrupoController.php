<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\SubGrupos;
use Auth;

class CadastroSubGrupoController extends Controller
{
  public function index(){

    if(Auth::check()){
        $CodUsu = Auth::user()->CodUsu;
        $listaGrupo = DB::table('e008cadgru')
                          ->where('SitGru', '=', 'A')
                          ->get();

                          $EmpresaLogada = DB::table('e999usulog')
                          ->where([['CodUsu', '=', $CodUsu]])
                          ->get();
  
                                   if(count($EmpresaLogada) >0) {
                                         foreach ($EmpresaLogada as $consulta) {
  
                                           $CodEmp   = $consulta ->CodEmp;
                                           $CodFil   = $consulta ->CodFil;
  
                                           $Empresa = DB::table('e001cademp')
                                                                   ->where([['CodEmp', '=', $CodEmp]])
                                                                     ->get();
                                           if(count($Empresa) >0) {
                                                 foreach ($Empresa as $consultar) {
                                                     $NomEmp = $consultar ->NomFan;
                                                 }
                                           }
  
                                           $Filial = DB::table('e002cadfil')
                                           ->where([['CodEmp', '=', $CodEmp],['CodFil','=',$CodFil]])
                                             ->get();
  
                                            
                                            if(count($Filial) >0) {
                                                  foreach ($Filial as $resultado) {
                                                      $NomFil = $resultado ->NomFan;
                                                  }
                                            }
  
  
  
                                     }
                                   }
  
  
  
  
           return view('erp.zen.cadastros.produto.novosubgrupo',compact('listaGrupo'))->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);
  


       }else{
          return redirect('/');
       }


  }

  public function processar(Request $request)
  {
    $CodSub = $request->input('CodSub');
    $CodGru = $request->input('CodGru');
    $NomSub = $request->input('NomSub');
    $SitSub = $request->input('SitSub');
    $CodUsu = Auth::user()->CodUsu;


    $EmpresaLogada = DB::table('e999usulog')
                        ->where([['CodUsu', '=', $CodUsu]])
                        ->get();

             if(count($EmpresaLogada) >0) {
                   foreach ($EmpresaLogada as $consulta) {

                     $CodEmp   = $consulta ->CodEmp;
                     $CodFil   = $consulta ->CodFil;
                   }
                  }



      $Cadastrosubgrupo = SubGrupos::insert(
      [
        'CodGru' => $CodGru,
        'NomSub' => $NomSub,
        'SitSub' => $SitSub,
        'CodUsu' =>$CodUsu,
        'DatCad' =>  date('Y/m/d'),
        'HorCad' =>  date("H:i:s")
    ]
     );

      if ($Cadastrosubgrupo == 'true'){
        return response()->json([
              'Status' => 'OK',
              'Mensagem' => 'Registro Incluido com Sucesso!'
          ]);
      }else{
            return response()->json([
            'Status' => 'Erro'
              ]);
      }








  }






}
