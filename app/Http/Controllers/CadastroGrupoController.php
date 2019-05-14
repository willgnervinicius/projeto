<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Grupo;
use Auth;

class CadastroGrupoController extends Controller
{
  public function index(){

    if(Auth::check()){
        $CodUsu = Auth::user()->CodUsu;
        $dataAtual = date("Y/m/d");




        $listaDept = DB::table('e008caddep')
                          ->where('SitDep', '=', 'A')
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




       return view('erp.zen.cadastros.produto.novogrupo',compact('listaDept'))->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);




       }else{
          return redirect('/');
       }


  }


  public function processar(Request $request)
  {
    $CodGru = $request->input('CodGru');
    $CodDep = $request->input('CodDep');
    $NomGru = $request->input('NomGru');
    $SitGru = $request->input('SitGru');
    $CodUsu = $request->input('CodUsu');


    $EmpresaLogada = DB::table('e999usulog')
                        ->where([['CodUsu', '=', $CodUsu]])
                        ->get();

             if(count($EmpresaLogada) >0) {
                   foreach ($EmpresaLogada as $consulta) {

                     $CodEmp   = $consulta ->CodEmp;
                     $CodFil   = $consulta ->CodFil;
                   }
                  }




     $consultagrupo = Grupo::where('CodGru', '=', $CodGru)
                ->get();

    if(count($consultagrupo) >0) {


      $AtualizaGrupo = Grupo::where(['CodGru', '=', $CodGru])->update(
                [
                'CodDep' => $CodDep,
                'NomGru' => $NomGru,
                'SitGru' => $SitGru,
                'UsuAtu' => $CodUsu,
                'DatAtu' =>  date('Y/m/d'),
                'HorAtu' =>  date("H:i:s")
              ]
      );



            return response()->json([
            'Status' => 'OK',
            'Mensagem' => 'Registro Atualizado com Sucesso!'
          ]);




    }else {
          $CadastroGrupo = Grupo::insert(
          [
            'CodEmp' => $CodEmp,
            'CodDep' => $CodDep,
            'NomGru' => $NomGru,
            'SitGru' => $SitGru,
            'CodUsu' =>$CodUsu,
            'DatCad' =>  date('Y/m/d'),
            'HorCad' =>  date("H:i:s")
        ]
      );

      if ($CadastroGrupo == 'true'){
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


}
