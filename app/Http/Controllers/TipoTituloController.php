<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class TipoTituloController extends Controller
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
    
    
    
    
             return view('erp.zen.cadastros.gerais.financeiro.novotipotitulo')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);
    
         }else{
            return redirect('/');
         }
    
      }


      public function processar(Request $request){
                $dados = $request->all();
                $CodTip = $dados['CodTip'];
                $NomTip = $dados['NomTip'];
                $ModTip = $dados['ModTip'];
                $ForPgt = $dados['ForPgt'];
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

                  $consultarTipo = DB::table('e019cadtip')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodTip','=',$CodTip]])->get();

                  if(count($consultarTipo)>0){
                            $AtualizarTipo = DB::table('e019cadtip')->where([['CodEmp','=' , $CodEmp],['CodFil','=' , $CodFil],['CodTip','=',$CodTip]])->update(
                              [
                                      'NomTip' =>  $NomTip,
                                      'ModTip' =>  $ModTip,
                                      'ForPgt' =>  $ForPgt,
                                      'UsuAtu' =>  $CodUsu,
                                      'DtaAtu' =>  date('Y/m/d'),
                                      'HorAtu' =>  date("H:i:s")
                              ]);

                              return response()->json([
                                  'Status' => 'OK',
                                  'Msg' => 'Registro Atualizado com Sucesso!',
                              ]);
                  }else{
                          $Tipo = DB::table('e019cadtip')->insert(
                            [
                                'CodEmp' => $CodEmp,
                                'CodFil' => $CodFil,
                                'CodTip' => $CodTip,
                                'NomTip' => $NomTip,
                                'ModTip' => $ModTip,
                                'ForPgt' => $ForPgt,
                                'Codusu' => $CodUsu,
                                'DtaCad' =>  date('Y/m/d'),
                                'HorCad' =>  date("H:i:s")
                        ]
                        );

                        if($Tipo == true){

                            return response()->json([
                                'Status' => 'OK',
                                'Msg' => 'Registro salvo com Sucesso!',
                            ]);
                        } else {
                            return response()->json([
                                'Status' => 'Er',
                                'Msg' => 'Ocorreu um erro ao Tentar salvar o Registro . Tente Novamente ',
                            ]);
                        }


                  }

      }


      public function consultar(Request $request){
                $dados = $request->all();
                $CodTip = $dados['CodTip'];
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

                  $consultarTipo = DB::table('e019cadtip')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodTip','=',$CodTip]])->get();

                  if(count($consultarTipo)>0){
                        foreach($consultarTipo as $tipo){

                          return response()->json([
                                'Status' => 'OK',
                                'NomTip' => $tipo->NomTip,
                                'ModTip' => $tipo->ModTip,
                                'ForPgt' => $tipo->ForPgt
                                ]);
                        }
                      
                  } else {
                          return response()->json([
                            'Status' => 'Er',
                            'Msg' => 'Nenhum Registro Localizado ',
                        ]);

                  }

      }
}
