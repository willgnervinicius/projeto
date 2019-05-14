<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Auth;
Use DB;
use App\Filial;
use App\Empresa;
use App\Portador;


class PortadorController extends Controller
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
    
    
    
    
             return view('erp.zen.cadastros.gerais.financeiro.novoportador')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);
    
         }else{
            return redirect('/');
         }
    
      }

      public function processar(Request $request){
                $dados = $request->all();
                $CodPor = $dados['CodPor'];
                $DesPor = $dados['NomPor'];
                $CodBan = $dados['CodBan'];
                $AgeCta = $dados['AgeCta'];
                $NumCta = $dados['NumCta'];
                $SitPor = $dados['SitPor'];
                $GerRem = $dados['GerRem'];
                $CtlRem = $dados['CtlRem'];
                $ModRem = $dados['ModRem'];

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
                  
                  
                  $ConsultarPortador = Portador::where([['CodEmp','=',$CodEmp],['CodPor','=',$CodPor]])->get();

                  if(count($ConsultarPortador)>0){
                           if($CodPor <> '9999'){
                                    $AtualizarPortador = Portador::where([['CodEmp','=' , $CodEmp],['CodPor','=',$CodPor]])->update(
                                        [
                                                'DesPor' => $DesPor,
                                                'CodBan' => $CodBan,
                                                'AgeCta' => $AgeCta,
                                                'NumCta' => $NumCta,
                                                'GerRem' => $GerRem,
                                                'CtlRem' => $CtlRem,
                                                'ModRem' => $ModRem,
                                                'SitPor' => $SitPor,
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
                                        'Msg' => 'Não é permitido atualizar Portador Empresa',
                                    ]);
                           }

                  } else {
                            $Portador = Portador::insert(
                                [
                                    'CodEmp' => $CodEmp,
                                    'CodPor' => $CodPor,
                                    'DesPor' => $DesPor,
                                    'CodBan' => $CodBan,
                                    'AgeCta' => $AgeCta,
                                    'NumCta' => $NumCta,
                                    'GerRem' => $GerRem,
                                    'CtlRem' => $CtlRem,
                                    'ModRem' => $ModRem,
                                    'SitPor' => $SitPor,
                                    'Codusu' => $CodUsu,
                                    'DtaCad' =>  date('Y/m/d'),
                                    'HorCad' =>  date("H:i:s")
                            ]
                            );

                            if($Portador == true){

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


      public function consultarPortador(Request $request){
                $dados = $request->all();
                $CodPor = $dados['CodPor'];
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


              $ConsultarPortador = Portador::where([['CodEmp','=',$CodEmp],['CodPor','=',$CodPor]])->get();

              if(count($ConsultarPortador)>0){
                        foreach($ConsultarPortador as $Portador){
                                $DesPor = $Portador->DesPor;
                                $CodBan = $Portador->CodBan;
                                $AgeCta = $Portador->AgeCta;
                                $NumCta = $Portador->NumCta;
                                $SitPor = $Portador->SitPor;
                                $GerRem = $Portador->GerRem;
                                $CtlRem = $Portador->CtlRem;
                                $ModRem = $Portador->ModRem;

                                return response()->json([
                                    'Status' => 'OK',
                                    'DesPor' => $DesPor,
                                    'CodBan' => $CodBan,
                                    'AgeCta' => $AgeCta,
                                    'NumCta' => $NumCta,
                                    'SitPor' => $SitPor,
                                    'GerRem' => $GerRem,
                                    'CtlRem' => $CtlRem,
                                    'ModRem' => $ModRem,
                                    
                                ]);

                        }

              } 

      }
}
