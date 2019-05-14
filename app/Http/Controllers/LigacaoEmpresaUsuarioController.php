<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class LigacaoEmpresaUsuarioController extends Controller
{
    public function index(){
        if(Auth::check()){
            $CodUsu = Auth::user()->CodUsu;
            
      
      
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
      
      
      
      
             return view('erp.zen.cadastros.usuario.ligacaoempresausuario')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);
      
      
           
           }else{
              return redirect('/');
           }
      
      

    }

    public function consultaFilial(Request $request){
        $CodUsu = Auth::user()->CodUsu;
        $dados  = $request->all();
        $CodFil  = $dados['CodFil'];
            
        $EmpresaLogada = DB::table('e999usulog')
                            ->where([['CodUsu', '=', $CodUsu]])
                            ->get();
      
        if(count($EmpresaLogada)>0){
            foreach($EmpresaLogada as $Empresa){
                $CodEmp = $Empresa->CodEmp;
            }
        }

        $ConsultaFilial = DB::table('e002cadfil')
                        ->where([['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])
                        ->get();
        
        if(count($ConsultaFilial) > 0){
            foreach($ConsultaFilial as $Filial){
                $NomFan = $Filial->NomFan ;
            }

            return response()->json([
                'Status' => 'OK',
                'NomFan' => $NomFan
            ]);
        } else {
            return response()->json([
                'Status' => 'Er',
                'Msg' => 'Filial não Localizada na Empresa ' . $CodEmp 
            ]);
        }


      
    }

    public function consultaUsuario(Request $request){
        $CodUsu = Auth::user()->CodUsu;
        $dados  = $request->all();
        $CgcCpf  = $dados['CgcCpf'];
        $CodFil  = $dados['CodFil'];

        $EmpresaLogada = DB::table('e999usulog')
                            ->where([['CodUsu', '=', $CodUsu]])
                            ->get();
      
        if(count($EmpresaLogada)>0){
            foreach($EmpresaLogada as $Empresa){
                $CodEmp = $Empresa->CodEmp;
            }
        }



        $ConsultaUsuario = DB::table('e999cadusu')
                            ->where([['CgcCpf', '=', $CgcCpf]])
                            ->get();
      
        if(count($ConsultaUsuario)>0){
            foreach($ConsultaUsuario as $Usuario){
                $NomUsu = $Usuario->NomUsu;
                $CodUsu = $Usuario->CodUsu;

                $FiliaisLiberadas = DB::table('e999empfil')
                                        ->where([['CodEmp','=',$CodEmp],['CodUsu','=',$CodUsu]])
                                        ->get();

                if(count($FiliaisLiberadas)>0){
                    foreach($FiliaisLiberadas as $liberadas){
                                $EmpLib = $liberadas->CodEmp;
                                $FilLib = $liberadas->CodFil;

                                $Empresa = DB::table('e001cademp')
                                                ->where([['CodEmp', '=', $EmpLib]])
                                                ->get();
                                                    
                                if(count($Empresa) >0) {
                                    foreach ($Empresa as $consultar) {
                                            $NomEmp = $consultar ->NomFan;
                                    }
                                }
            
                                $Filial = DB::table('e002cadfil')
                                            ->where([['CodEmp', '=', $EmpLib],['CodFil','=',$FilLib]])
                                            ->get();
            
                                                    
                                if(count($Filial) >0) {
                                    foreach ($Filial as $resultado) {
                                        $NomFil = $resultado ->NomFan;
                                    }
                                }

                                $Retorno [] = array(
                                        'Status' => 'OK',
                                        'CodEmp' => $EmpLib ,
                                        'CodFil' => $FilLib,
                                        'NomEmp' => $NomEmp ,
                                        'NomFil' => $NomFil ,
                                        'CodUsu' => $CodUsu,
                                        'NomUsu' => $NomUsu,
                                        'CgcCpf' => $CgcCpf


                                );


                    }
                    return json_encode($Retorno); 
                }



            }
           
        }

    
    }


    public function excluir(Request $request){
        $dados   = $request->all();
        $CodUsu  = $dados['CodUsu'];
        $CodFil  = $dados['CodFil'];
        $CodEmp  = $dados['CodEmp'];

        DB::table('e999empfil')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodUsu', '=', $CodUsu]])->delete();

        return response()->json([
            'Status' => 'OK',
            'Msg' => 'Ligação excluida com Sucesso!'  
        ]);
    }

    
    public function adicionar(Request $request){
        $dados   = $request->all();
        $CodUsu = Auth::user()->CodUsu;
        $CodFil  = $dados['CodFil'];
        $CgcCpf  = $dados['CgcCpf'];



        $EmpresaLogada = DB::table('e999usulog')
                            ->where([['CodUsu', '=', $CodUsu]])
                            ->get();
      
        if(count($EmpresaLogada)>0){
            foreach($EmpresaLogada as $Empresa){
                $CodEmp = $Empresa->CodEmp;
            }
        }

        $ConsultaUsuario = DB::table('e999cadusu')
                            ->where([['CgcCpf', '=', $CgcCpf]])
                            ->get();
      
        if(count($ConsultaUsuario)>0){
                foreach($ConsultaUsuario as $Usuario){
                    $CodigoUsuario = $Usuario->CodUsu;

                    $consultaligacao = DB::table('e999empfil')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodUsu', '=', $CodigoUsuario]])->get();

                    if(count($consultaligacao) > 0){
                        return response()->json([
                            'Status' => 'OK',
                            'Msg' => 'Filial x Usuário já esta Ligado'  
                        ]);
                    } else {
                        $Ligar = DB::table('e999empfil')->insert(
                            [
                             'CodEmp' => $CodEmp,
                             'CodFil' => $CodFil,
                             'CodUsu' => $CodigoUsuario,
                             'UsuLig' => $CodUsu,
                             'DtaCad' =>  date('Y/m/d'),
                             'HorCad' =>  date("H:i:s")
                          ]
                        );

                        if($Ligar == 'true'){
                            return response()->json([
                                'Status' => 'OK',
                                'Msg' => 'Usuário x Filial Ligado'  
                            ]);
                        } else {
                            return response()->json([
                                'Status' => 'Er',
                                'Msg' => 'Ocorreu um erro ao tentar realizar o Cadastro . Tente Novamente.'  
                            ]);
                        }

                    }



                }
        }


    }

}
