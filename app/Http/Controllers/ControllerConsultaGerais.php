<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;




class ControllerConsultaGerais extends Controller{

  public function consultarfornecedor(Request $request){
            $dados = $request->all();
            $CgcCpf = $dados['CgcCpf'];
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

                    
            $consultarFornecedor = DB::table('vfornecedor')
                                        ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CgcCpf','=',$CgcCpf]]) 
                                        ->get();

            
            if(count($consultarFornecedor )> 0){
                  foreach ($consultarFornecedor as $fornecedor){
                        $RazSoc = $fornecedor->RazSoc;
                        $SigUfs = $fornecedor->UfsFor;
                        $CodFor = $fornecedor->CodFor;

                        $consulaFilial = DB::table('e002cadfil')
                                             ->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil]])
                                             ->get();

                        if(count($consulaFilial)>0){
                              foreach($consulaFilial as $filial){
                                   $SigFil = $filial->UfsFil;
                              }
                        }

                        return response()->json([
                          'Status' => 'OK',
                          'RazSoc' =>$RazSoc,
                          'UfsFor' =>$SigUfs,
                          'UfsFil' =>$SigFil,
                          'CodFor' =>$CodFor
                        ]);
                  }
            } else {
              return response()->json([
                'Status' => 'ER',
                'Msg' => 'Fornecedor não Cadastrado',
              ]);

            }


  }


  public function consultarfornecedorcodigo(Request $request){
    $dados = $request->all();
    $CodFor = $dados['CodFor'];
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

            
    $consultarFornecedor = DB::table('vfornecedor')
                                ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodFor','=',$CodFor]]) 
                                ->get();

    
    if(count($consultarFornecedor )> 0){
          foreach ($consultarFornecedor as $fornecedor){
                $RazSoc = $fornecedor->RazSoc;
                $CgcCpf = $fornecedor->CgcCpf;
                $SigUfs = $fornecedor->UfsFor;
                
                $consulaFilial = DB::table('e002cadfil')
                                     ->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil]])
                                     ->get();

                if(count($consulaFilial)>0){
                      foreach($consulaFilial as $filial){
                           $SigFil = $filial->UfsFil;
                      }
                }

                return response()->json([
                  'Status' => 'OK',
                  'RazSoc' =>$RazSoc,
                  'CgcCpf' =>$CgcCpf,
                  'UfsFor' =>$SigUfs,
                  'UfsFil' =>$SigFil,
                  'CodFor' =>$CodFor
                ]);
          }
    } else {
      return response()->json([
        'Status' => 'ER',
        'Msg' => 'Fornecedor não Cadastrado',
      ]);

    }


}


public function consultarCliente(Request $request){
  $dados = $request->all();
  $CgcCpf = $dados['CgcCpf'];
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

          
  $consultarCliente = DB::table('vcliente')
                              ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CgcCpf','=',$CgcCpf]]) 
                              ->get();

  
  if(count($consultarCliente )> 0){
        foreach ($consultarCliente as $Cliente){
              $RazSoc = $Cliente->RazSoc;
              $SigUfs = $Cliente->UfsCli;
              $CodCli = $Cliente->CodCli;

              $consulaFilial = DB::table('e002cadfil')
                                   ->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil]])
                                   ->get();

              if(count($consulaFilial)>0){
                    foreach($consulaFilial as $filial){
                         $SigFil = $filial->UfsFil;
                    }
              }

              return response()->json([
                'Status' => 'OK',
                'RazSoc' =>$RazSoc,
                'UfsCli' =>$SigUfs,
                'UfsFil' =>$SigFil,
                'CodCli' =>$CodCli
              ]);
        }
  } else {
    return response()->json([
      'Status' => 'ER',
      'Msg' => 'Cliente não Cadastrado , ou Inativo.',
    ]);

  }


}


public function consultarclientecodigo(Request $request){
  $dados = $request->all();
  $CodCli = $dados['CodCli'];
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

          
  $consultarCliente = DB::table('vcliente')
                              ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli]]) 
                              ->get();

  
  if(count($consultarCliente )> 0){
        foreach ($consultarCliente as $Cliente){
              $RazSoc = $Cliente->RazSoc;
              $CgcCpf = $Cliente->CgcCpf;
              $SigUfs = $Cliente->UfsCli;
              
              $consulaFilial = DB::table('e002cadfil')
                                   ->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil]])
                                   ->get();

              if(count($consulaFilial)>0){
                    foreach($consulaFilial as $filial){
                         $SigFil = $filial->UfsFil;
                    }
              }

              return response()->json([
                'Status' => 'OK',
                'RazSoc' =>$RazSoc,
                'CgcCpf' =>$CgcCpf,
                'UfsCli' =>$SigUfs,
                'UfsFil' =>$SigFil,
                'CodCli' =>$CodCli
              ]);
        }
  } else {
    return response()->json([
      'Status' => 'ER',
      'Msg' => 'Cliente não Cadastrado , ou Inativo.',
    ]);

  }


}


  public function consultarbanco(){
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

            
    $consultarbanco = DB::table('e018cadban')
                                ->where ([['CodEmp','=',$CodEmp]]) 
                                ->get();

    if(count($consultarbanco )> 0){
          foreach ($consultarbanco as $banco){
                $NomFan = $banco->NomFan;
                $CodBan = $banco->CodBan;

                $bancos [] = array(
                  'Status' => 'OK',
                  'NomFan' =>$NomFan,
                  'CodBan' =>$CodBan
                );
               
          }
          return json_encode($bancos);
    } else {
      return response()->json([
        'Status' => 'ER',
        'Msg' => 'Banco não Cadastrado',
      ]);

    }


}



public function consultarportador(Request $request){
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

          
  $consultarportador = DB::table('e017cadpor')
                              ->where ([['CodEmp','=',$CodEmp],['CodPor','=',$CodPor],['SitPor','=','A']]) 
                              ->get();

  if(count($consultarportador )> 0){
        foreach ($consultarportador as $portador){
              $NomPor = $portador->DesPor;
              $CodBan = $portador->CodBan;

             

              return response()->json([
                'Status' => 'OK',
                'NomPor' =>$NomPor,
                'CodBan' =>$CodBan
              ]);
             
        }
        
  } else {
    return response()->json([
      'Status' => 'ER',
      'Msg' => 'Portador não Cadastrado',
    ]);

  }


}

public function consultarfavorecido(Request $request){
  $dados = $request->all();
  $CgcCpf = $dados['CgcCpf'];

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

            
    $consultarfavorecido = DB::table('vfavorecido')
                                ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CgcCpf','=',$CgcCpf]]) 
                                ->get();

    if(count($consultarfavorecido )> 0){
          foreach ($consultarfavorecido as $favorecido){
                $RazSoc = $favorecido->RazSoc;
                $CodBan = $favorecido->CodBan;
                $AgeCta = $favorecido->AgeCta;
                $NumCta = $favorecido->NumCta;


                return response()->json([
                  'Status' => 'OK',
                  'RazSoc' =>$RazSoc,
                  'CodBan' =>$CodBan,
                  'AgeCta' =>$AgeCta,
                  'NumCta' =>$NumCta
                ]);

                
               
          }
        
    } else {
      return response()->json([
        'Status' => 'ER',
        'Msg' => 'Dados do Favorecido não Cadastrado',
      ]);

    }

}




  public function consultarCfopEntrada(Request $request) {
        $dados = $request->all();
        $CodTns = $dados['CodTns'];



      $consultartransacao = DB::table('e008cadtns')
                          ->where([['CodTns', '=', $CodTns],['TipTns','=', 'E']])
                          ->get();

        if(count($consultartransacao) >0) {
              foreach ($consultartransacao as $consulta) {
                $DesTns = $consulta->DesTns;

                return response()->json([
                'Status' => 'Ok',
                'DesTns' =>$DesTns,

                  ]);
              }
        } else {
          return response()->json([
          'Status' => 'ER',
          'Msg' =>'CFOP não Cadastrada ou não é do Tipo de Entrada.',

            ]);
        }

  }


  public function consultarCfopSaida(Request $request){
          $dados = $request->all();
          $CodTns = $dados['CodTns'];



        $consultartransacao = DB::table('e008cadtns')
                            ->where([['CodTns', '=', $CodTns],['TipTns','=', 'S']])
                            ->get();

          if(count($consultartransacao) >0) {
                foreach ($consultartransacao as $consulta) {
                  $DesTns = $consulta->DesTns;

                  return response()->json([
                  'Status' => 'Ok',
                  'DesTns' =>$DesTns,

                    ]);
                }
          } else {
            return response()->json([
            'Status' => 'ER',
            'Msg' =>'CFOP não Cadastrada ou não é do Tipo de Saída.',

              ]);
          }

  }

  
public function consultartipoReceber(Request $request){
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

              
      $consultartiporeceber = DB::table('e019cadtip')
                                  ->where ([['CodEmp','=',$CodEmp],['ModTip','<>','P']]) 
                                  ->get();

      if(count($consultartiporeceber )> 0){
            foreach ($consultartiporeceber as $tipo){
                  $CodTip = $tipo->CodTip;
                  $NomTip = $tipo->NomTip;

                

                  $tipos [] = array(
                    'Status' => 'OK',
                    'CodTip' => $CodTip,
                    'NomTip' => $NomTip

                  );
                
            }

            return json_encode($tipos);
            
      } else {
        return response()->json([
          'Status' => 'ER',
          'Msg' => 'Tipo de Título não Cadastrado',
        ]);

      }
 }

  public function consultartipoPagar(Request $request){
    $dados = $request->all();
    
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
  
            
    $consultartipopagar = DB::table('e019cadtip')
                                ->where ([['CodEmp','=',$CodEmp],['ModTip','<>','R']]) 
                                ->get();
  
    if(count($consultartipopagar )> 0){
          foreach ($consultartipopagar as $tipo){
                $CodTip = $tipo->CodTip;
                $NomTip = $tipo->NomTip;
  
               
  
                $tipos [] = array(
                  'Status' => 'OK',
                  'CodTip' => $CodTip,
                  'NomTip' => $NomTip,
                );
                  
                
               
          }
          return json_encode($tipos);
    } else {
      return response()->json([
        'Status' => 'ER',
        'Msg' => 'Tipo de Título não Cadastrado',
      ]);
  
    }
  


}


public function consultartransportadora(Request $request){
              $dados = $request->all();
              
              
              
              $CodUsu = Auth::user()->CodUsu;

              if(isset( $dados['CodTra'])){
                $CodTra = $dados['CodTra'];
              }

              if(isset($dados['CgcCpf'])){
                $CgcCpf = $dados['CgcCpf'];
              }


              $EmpresaLogada = DB::table('e999usulog')
                                  ->where([['CodUsu', '=', $CodUsu]])
                                  ->get();

                      if(count($EmpresaLogada) >0) {
                            foreach ($EmpresaLogada as $consulta) {
                                    $CodEmp   = $consulta ->CodEmp;
                                    $CodFil   = $consulta ->CodFil;

                          }
                        }

              if((!empty($CgcCpf)) && (empty($CodTra))){
                      $consultartransportadora = DB::table('e004cadtra')
                                          ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CgcCpf','=',$CgcCpf]]) 
                                          ->get();
              } else if((empty($CgcCpf)) && (!empty($CodTra))){
                      $consultartransportadora = DB::table('e004cadtra')
                                              ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodTra','=',$CodTra]]) 
                                              ->get();
              }
                      
            

              if(count($consultartransportadora )> 0){
                    foreach ($consultartransportadora as $transportadora){
                          $CodTra = $transportadora->CodTra;
                          $RazSoc = $transportadora->RazSoc;
                          $CgcCpf = $transportadora->CgcCpf;

                        

                          return response()->json([
                            'Status' => 'OK',
                            'CodTra' => $CodTra,
                            'RazSoc' => $RazSoc,
                            'CgcCpf' => $CgcCpf,
                          ]);
                            
                          
                        
                    }
                   
              } else {
                return response()->json([
                  'Status' => 'ER',
                  'Msg' => 'Transportador não Cadastrada ou Inativa',
                ]);

              }
}

public function consultarproduto(Request $request){
  $dados = $request->all();
  
  
  
  $CodUsu = Auth::user()->CodUsu;
  $CodPro = $dados['CodPro'];

  


  $EmpresaLogada = DB::table('e999usulog')
                      ->where([['CodUsu', '=', $CodUsu]])
                      ->get();

          if(count($EmpresaLogada) >0) {
                foreach ($EmpresaLogada as $consulta) {
                        $CodEmp   = $consulta ->CodEmp;
                        $CodFil   = $consulta ->CodFil;

              }
            } else {
              return redirect('/');
            }

        $consultarproduto = DB::table('e008cadpro')
                                  ->where ([['CodEmp','=',$CodEmp],['CodPro','=',$CodPro]]) 
                                  ->get();
  
          


  if(count($consultarproduto )> 0){
        foreach ($consultarproduto as $produto){
              $DesNfe = strtoupper($produto->DesNfe);

              $consultartributos = DB::table('e008cadtri')
                                  ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodPro','=',$CodPro]]) 
                                  ->get();


              if(count($consultartributos)>0){
                 foreach($consultartributos as $tributos){
                        $CodTns = $tributos->CodTns;
                        $AliIcm = $tributos->AliIcm;
                        $AliIpi = $tributos->AliIpi;
                        $CodCst = $tributos->CodCst;


                        $consultarpreco = DB::table('e008prepro')
                                  ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodPro','=',$CodPro]]) 
                                  ->get();

                        if(count($consultarpreco)>0){
                           foreach ($consultarpreco as $preco) {
                                $VlrPro = $preco->VlrVen;
                           }
                        }

                 }

                 return response()->json([
                  'Status' => 'OK',
                  'DesNfe' => $DesNfe,
                  'CodTns' => $CodTns,
                  'AliIcm' => $AliIcm,
                  'AliIpi' => $AliIpi,
                  'CodCst' => $CodCst,
                  'VlrPro' => $VlrPro
                ]);
              }
              

              
                
              
            
        }
       
  } else {
    return response()->json([
      'Status' => 'ER',
      'Msg' => 'Transportador não Cadastrada ou Inativa',
    ]);

  }
}

public function listarclientes(){
  if (Auth::check()){
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


        $consultarclientes = DB::table('e003cadcli')
                                 ->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['SitCli','=','A']])
                                 ->get();

        if(count($consultarclientes)>0){
           foreach($consultarclientes as $clientes){
                $CodCli = $clientes->CodCli;
                $RazSoc = $clientes->RazSoc;
                $CgcCpf = $clientes->CgcCpf;

                $listacliente[] = array(
                  'Status' => 'OK',
                  'CodCli' => $CodCli ,
                  'RazSoc' => $RazSoc ,
                  'CgcCpf' => $CgcCpf ,
                );
           }

           return json_encode($listacliente);
        } else {
                $listacliente[] = array(
                  'Status' => 'OK',
                  'CodCli' => '0' ,
                  'RazSoc' => 'Nenhum cliente Localizado' ,
                  'CgcCpf' => '' ,
                );
                
                return json_encode($listacliente);
        }


  } else {
    return redirect('/');
  }

}

public function listarcfopsaida(Request $request){
  if (Auth::check()){
        $CodUsu = Auth::user()->CodUsu;
      
        $dados = $request->all();
        $CodCli = $dados['CodCli'];
        
      
      
        $EmpresaLogada = DB::table('e999usulog')
                            ->where([['CodUsu', '=', $CodUsu]])
                            ->get();
  
        if(count($EmpresaLogada) >0) {
          foreach ($EmpresaLogada as $consulta) {
                $CodEmp   = $consulta ->CodEmp;
                $CodFil   = $consulta ->CodFil;

                $FilialLogado = DB::table('e002cadfil')
                                  ->where([['CodEmp', '=', $CodEmp],['CodFil','=',$CodFil]])
                                  ->get();

                if(count($FilialLogado)>0){
                      foreach ($FilialLogado as $filial) {
                              $UfsFil = $filial->UfsFil;
                      }

                }
  
          }
        }else {
          return redirect('/');
        }

        $ConsultaCliente = DB::table('e003cadcli')
                            ->where([['CodEmp', '=', $CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli]])
                            ->get();

        if(count($ConsultaCliente)>0){
              foreach ($ConsultaCliente as $cliente) {
                  $UfsCli = $cliente->UfsCli;
              }

        }

        if($UfsCli == $UfsFil){
             $TipOpe = 'I';
        } else if($UfsCli <> $UfsFil){
          $TipOpe = 'E';
        } 


        $consultartransacao = DB::table('e008cadtns')
                                 ->where([['SitTns','=','A'],['TipTns','=','S'],['TipOpe','=',$TipOpe]])
                                 ->get();

        if(count($consultartransacao)>0){
           foreach($consultartransacao as $transacao){
                $CodTns = $transacao->CodTns;
                $DesTns = $transacao->DesTns;
                

                $listatransacoes[] = array(
                  'Status' => 'OK',
                  'CodTns' => $CodTns ,
                  'DesTns' => $DesTns ,
                );
           }

           return json_encode($listatransacoes);
        } 


  } else {
    return redirect('/');
  }

}

}