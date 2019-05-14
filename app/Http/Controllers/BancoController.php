<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Empresa;
use App\Filial;
use App\Banco;

class BancoController extends Controller
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
    
                                             $Empresa = Empresa::where([['CodEmp', '=', $CodEmp]])
                                                                       ->get();
                                             if(count($Empresa) >0) {
                                                   foreach ($Empresa as $consultar) {
                                                       $NomEmp = $consultar ->NomFan;
                                                   }
                                             }
    
                                             $Filial = Filial::where([['CodEmp', '=', $CodEmp],['CodFil','=',$CodFil]])
                                               ->get();
    
                                              
                                              if(count($Filial) >0) {
                                                    foreach ($Filial as $resultado) {
                                                        $NomFil = $resultado ->NomFan;
                                                    }
                                              }
    
    
    
                                       }
                                     }
    
    
    
    
             return view('erp.zen.cadastros.gerais.financeiro.novobanco')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);
    
         }else{
            return redirect('/');
         }
    
      }

      public function processar(Request $request){
                $dados = $request->all();
                $CodBan = $dados['CodBan'];
                $NomFan = $dados['NomFan'];
                $CgcCpf = $dados['CgcBan'];
                
                

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
                  
                  
                  $ConsultarBanco = Banco::where([['CodEmp','=',$CodEmp],['CodBan','=',$CodBan]])->get();

                  if(count($ConsultarBanco)>0){
                           if($CodBan <> '9999'){
                                    $AtualizarBanco = Banco::where([['CodEmp','=' , $CodEmp],['CodBan','=',$CodBan]])->update(
                                        [
                                                'NomFan' => $NomFan,
                                                'CgcCpf' => $CgcCpf,
                                                'UsuAtu' => $CodUsu,
                                                'DtaAtu' =>  date('Y/m/d'),
                                                'HorAtu' =>  date("H:i:s")
                                        ]);

                                        return response()->json([
                                            'Status' => 'OK',
                                            'Msg' => 'Registro Atualizado com Sucesso!',
                                        ]);
                           } else {
                                    return response()->json([
                                        'Status' => 'Er',
                                        'Msg' => 'Não é permitido atualizar Banco Interno Empresa',
                                    ]);
                           }

                  } else {
                            $Banco = Banco::insert(
                                [
                                    'CodEmp' => $CodEmp,
                                    'CodBan' => $CodBan,
                                    'NomFan' => $NomFan,
                                    'CgcCpf' => $CgcCpf,
                                    'Codusu' => $CodUsu,
                                    'DtaCad' =>  date('Y/m/d'),
                                    'HorCad' =>  date("H:i:s")
                            ]
                            );

                            if($Banco == true){

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


      public function consultarBanco(Request $request){
                $dados = $request->all();
                $CodBan = $dados['CodBan'];
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


              $ConsultarBanco = Banco::where([['CodEmp','=',$CodEmp],['CodBan','=',$CodBan]])->get();

              if(count($ConsultarBanco)>0){
                        foreach($ConsultarBanco as $Banco){
                                $NomFan = $Banco->NomFan;
                                $CgcCpf = $Banco->CgcCpf;
                                

                                return response()->json([
                                    'Status' => 'OK',
                                    'NomFan' => $NomFan,
                                    'CgcBan' => $CgcCpf,
                                    
                                ]);

                        }

              } 

      }
}
