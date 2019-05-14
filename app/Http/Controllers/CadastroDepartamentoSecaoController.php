<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Empresa;
use App\Filial;
use App\Departamento;
use Auth;

class CadastroDepartamentoSecaoController extends Controller
{
  public function index(){

    if(Auth::check()){
        $CodUsu = Auth::user()->CodUsu;
        $dataAtual = date("Y/m/d");

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




          return view('erp.zen.cadastros.produto.novodepartamento')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);

       


       }else{
          return redirect('/');
       }


  }


  public function processar(Request $request)
  {
    $dados = $request->all();
    $CodDep = $dados['CodDep'];
    $NomDep = $dados['NomDep'];
    $SitDep = $dados['SitDep'];
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




     $consultadepartamento = Departamento::where('CodDep', '=', $CodDep)
                ->get();

    if(count($consultadepartamento) >0) {


      $Atualizadepartamento = Departamento::where([['CodEmp','=',$CodEmp],['CodDep', '=', $CodDep]])->update(
                [
                'NomDep' => $NomDep,
                'SitDep' => $SitDep,
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
          $CadastroDepartamento = Departamento::insert(
          [
            'CodEmp' => $CodEmp,
            'NomDep' => $NomDep,
            'SitDep' => $SitDep,
            'CodUsu' =>$CodUsu,
            'DatCad' =>  date('Y/m/d'),
            'HorCad' =>  date("H:i:s")
        ]
      );

      if ($CadastroDepartamento == 'true'){
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
