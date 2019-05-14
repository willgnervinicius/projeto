<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Mensagem;
use DB;

class CadastroFornecedorController extends Controller
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




       return view('erp.zen.cadastros.fornecedor.novofornecedor')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);




      

       }else{
          return redirect('/');
       }


  }

  public function processar(Request $request){
    $dados = $request->all();
    $CodUsu = Auth::user()->CodUsu;

    $RazSoc = $dados['RazSoc'];
    $TipFor = $dados['TipoFornecedor'];
    $RamAtv = $dados['RamAtv'];
    $TriIcm = $dados['TriIcm'];
    $CgcCpf = $dados['CgcCpf'];
    $NumRge = $dados['NumRge'];
    $InsEst = $dados['InsEst'];
    $InsSuf = $dados['InsSuf'];
    $SitFor = $dados['SitFor'];

    $TelFor = $dados['TelFor'];
    $NumFax = $dados['NumFax'];
    $IntNet = $dados['IntNet'];
    
    
    
    $CepFor = $dados['CepFor'];
    $EndFor = $dados['EndFor'];
    $NumFor = $dados['NumFor'];
    $CplFor = $dados['CplFor'];
    $BaiFor = $dados['BaiFor'];
    $CidFor = $dados['CidFor'];
    $UfsFor = $dados['UfsFor'];
    $PaiFor = $dados['PaiFor'];
    $MunFor = $dados['MunFor'];

    $RazSoc= strtoupper($RazSoc);

    

    

    $EmpresaLogada = DB::table('e999usulog')
                ->where([['CodUsu', '=', $CodUsu]])
                ->get();

     if(count($EmpresaLogada) >0) {
          foreach ($EmpresaLogada as $consulta) {
                  $CodEmp   = $consulta ->CodEmp;
                  $CodFil   = $consulta ->CodFil;

         }
      }

    
    $consultarCliente = DB::table('e003cadcli')
                        ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CgcCpf','=',$CgcCpf]]) 
                        ->get();

    if(count($consultarCliente )> 0){
                $AtualizaCliente = DB::table('e003cadcli')->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])->update(
                  [
                        'RazSoc' => $RazSoc,
                        'RamAtv' => $RamAtv,
                        'TipCli' => $TipFor,
                        'TriIcm' => $TriIcm,
                        'NumRge' => $NumRge,
                        'InsEst' => $InsEst,
                        'InsSuf' => $InsSuf,
                        'TelCli' => $TelFor,
                        'NumFax' => $NumFax,
                        'IntNet' => $IntNet,
                        'CepCli' => $CepFor,
                        'EndCli' => $EndFor,
                        'NumCli' => $NumFor,
                        'CplCli' => $CplFor,
                        'BaiCli' => $BaiFor,
                        'CidCli' => $CidFor,
                        'UfsCli' => $UfsFor,
                        'PaiCli' => $PaiFor,
                        'MunCli' => $MunFor,
                        'CepEnt' => $CepFor,
                        'EndEnt' => $EndFor,
                        'NumEnt' => $NumFor,
                        'CplEnt' => $CplFor,
                        'BaiEnt' => $BaiFor,
                        'CidEnt' => $CidFor,
                        'UfsEnt' => $UfsFor,
                        'PaiEnt' => $PaiFor,
                        'MunEnt' => $MunFor,
                        'SitCli' => $SitFor,
                        'UsuAtu' => $CodUsu,
                        'DtaAtu' =>  date('Y/m/d'),
                        'HorAtu' =>  date("H:i:s")
                ]
                );


                $AtualizaFornecedor = DB::table('e003cadfor')->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])->update(
                  [
                        'RazSoc' => $RazSoc,
                        'RamAtv' => $RamAtv,
                        'TipFor' => $TipFor,
                        'TriIcm' => $TriIcm,
                        'NumRge' => $NumRge,
                        'InsEst' => $InsEst,
                        'InsSuf' => $InsSuf,
                        'TelFor' => $TelFor,
                        'NumFax' => $NumFax,
                        'IntNet' => $IntNet,
                        'CepFor' => $CepFor,
                        'EndFor' => $EndFor,
                        'NumFor' => $NumFor,
                        'CplFor' => $CplFor,
                        'BaiFor' => $BaiFor,
                        'CidFor' => $CidFor,
                        'UfsFor' => $UfsFor,
                        'PaiFor' => $PaiFor,
                        'MunFor' => $MunFor,
                        'SitFor' => $SitFor,
                        'UsuAtu' => $CodUsu,
                        'DtaAtu' =>  date('Y/m/d'),
                        'HorAtu' =>  date("H:i:s")
                ]
                );

              return response()->json([
                'Status' => 'OK',
                'Mensagem' => 'Registro Atualizado.'
             ]);
    }else {
                $CadastroCliente = DB::table('e003cadcli')->insert(
                  [
                      'CodEmp' => $CodEmp,
                      'CodFil' => $CodFil,
                      'RazSoc' => $RazSoc,
                      'RamAtv' => $RamAtv,
                      'TipCli' => $TipFor,
                      'TriIcm' => $TriIcm,
                      'CgcCpf' => $CgcCpf,
                      'NumRge' => $NumRge,
                      'InsEst' => $InsEst,
                      'InsSuf' => $InsSuf,
                      'TelCli' => $TelFor,
                      'NumFax' => $NumFax,
                      'IntNet' => $IntNet,
                      'CepCli' => $CepFor,
                      'EndCli' => $EndFor,
                      'NumCli' => $NumFor,
                      'CplCli' => $CplFor,
                      'BaiCli' => $BaiFor,
                      'CidCli' => $CidFor,
                      'UfsCli' => $UfsFor,
                      'PaiCli' => $PaiFor,
                      'MunCli' => $MunFor,
                      'CepEnt' => $CepFor,
                      'EndEnt' => $EndFor,
                      'NumEnt' => $NumFor,
                      'CplEnt' => $CplFor,
                      'BaiEnt' => $BaiFor,
                      'CidEnt' => $CidFor,
                      'UfsEnt' => $UfsFor,
                      'PaiEnt' => $PaiFor,
                      'MunEnt' => $MunFor,
                      'SitCli' => $SitFor,
                      'Codusu' => $CodUsu,
                      'DtaCad' =>  date('Y/m/d'),
                      'HorCad' =>  date("H:i:s")
                ]
              );
        
              if ($CadastroCliente == 'true'){
                        $consultarClienteCadastrado = DB::table('e003cadcli')
                        ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CgcCpf','=',$CgcCpf]]) 
                        ->get();

                        if(count($consultarClienteCadastrado) > 0){
                           foreach ($consultarClienteCadastrado as $Cliente ){
                                       $CodCli = $Cliente->CodCli;
                           }
                        }
                 
                                $CadastroFornecedor = DB::table('e003cadfor')->insert(
                                  [
                                      'CodEmp' => $CodEmp,
                                      'CodFil' => $CodFil,
                                      'CodFor' => $CodCli,
                                      'RazSoc' => $RazSoc,
                                      'RamAtv' => $RamAtv,
                                      'TipFor' => $TipFor,
                                      'TriIcm' => $TriIcm,
                                      'CodCli' => $CodCli,
                                      'CgcCpf' => $CgcCpf,
                                      'NumRge' => $NumRge,
                                      'InsEst' => $InsEst,
                                      'InsSuf' => $InsSuf,
                                      'TelFor' => $TelFor,
                                      'NumFax' => $NumFax,
                                      'IntNet' => $IntNet,
                                      'CepFor' => $CepFor,
                                      'EndFor' => $EndFor,
                                      'NumFor' => $NumFor,
                                      'CplFor' => $CplFor,
                                      'BaiFor' => $BaiFor,
                                      'CidFor' => $CidFor,
                                      'UfsFor' => $UfsFor,
                                      'PaiFor' => $PaiFor,
                                      'MunFor' => $MunFor,
                                      'SitFor' => $SitFor,
                                      'Codusu' => $CodUsu,
                                      'DtaCad' =>  date('Y/m/d'),
                                      'HorCad' =>  date("H:i:s")
                                ]
                              );
        
                              if ($CadastroFornecedor == 'true'){

                                        $AtualizaCliente = DB::table('e003cadcli')->where([['CodCli', '=', $CodCli],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])->update(
                                          [
                                            'CodFor' => $CodCli,
                                            'UsuAtu' => $CodUsu,
                                            'DtaAtu' =>  date('Y/m/d'),
                                            'HorAtu' =>  date("H:i:s")
                                        ] );


                                      return response()->json([
                                        'Status' => 'OK',
                                        'Mensagem' => 'Registro Incluido com Sucesso!'
                                    ]);
                              }
              }else{
                    return response()->json([
                    'Status' => 'Erro',
                    'Mensagem' => 'Ocorreu um erro ao inserir o Registro . Tente Novamente'
                      ]);
              }   

    }

}


  public function consultarfornecedorcgc(Request $Request){
    $dados = $Request->all();
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

                    
            $consultarFornecedor = DB::table('e003cadfor')
                                        ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CgcCpf','=',$CgcCpf]]) 
                                        ->get();

            if(count($consultarFornecedor )> 0){
                  foreach ($consultarFornecedor as $fornecedor){
                        $CodFor = $fornecedor->CodFor;
                        $RazSoc = $fornecedor->RazSoc;
                        $TipFor = $fornecedor->TipFor;
                        $RamAtv = $fornecedor->RamAtv;
                        $TriIcm = $fornecedor->TriIcm;
                        $CodCli = $fornecedor->CodCli;
                        $NumRge = $fornecedor->NumRge;
                        $InsEst = $fornecedor->InsEst;
                        $InsSuf = $fornecedor->InsSuf;
                        $TelFor = $fornecedor->TelFor;
                        $NumFax = $fornecedor->NumFax;
                        $IntNet = $fornecedor->IntNet;
                        $CepFor = $fornecedor->CepFor;
                        $EndFor = $fornecedor->EndFor;
                        $NumFor = $fornecedor->NumFor;
                        $CplFor = $fornecedor->CplFor;
                        $BaiFor = $fornecedor->BaiFor;
                        $CidFor = $fornecedor->CidFor;
                        $UfsFor = $fornecedor->UfsFor;
                        $PaiFor = $fornecedor->PaiFor;
                        $MunFor = $fornecedor->MunFor;
                        $SitFor = $fornecedor->SitFor;

                  

                        return response()->json([
                          'Status' => 'Ok',
                          'CodFor' =>$CodFor,
                          'RazSoc' =>$RazSoc,
                          'TipFor' => $TipFor,
                          'RamAtv' => $RamAtv,
                          'TriIcm' => $TriIcm,
                          'CodCli' => $CodCli,
                          'NumRge' => $NumRge,
                          'InsEst' => $InsEst,
                          'InsSuf' => $InsSuf,
                          'TelFor' => $TelFor,
                          'NumFax' => $NumFax,
                          'IntNet' => $IntNet,
                          'SitFor' => $SitFor,
                          'CepFor' => $CepFor,
                          'EndFor' => $EndFor,
                          'NumFor' => $NumFor,
                          'CplFor' => $CplFor,
                          'BaiFor' => $BaiFor,
                          'CidFor' => $CidFor,
                          'UfsFor' => $UfsFor,
                          'PaiFor' => $PaiFor,
                          'MunFor' => $MunFor,
                        ]);
                  }
            } else {
              return response()->json([
                'Status' => 'NL',
              ]);

            }

  }

  public function consultarfornecedorcodigo(Request $Request){
    $dados = $Request->all();
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

                    
            $consultarFornecedor = DB::table('e003cadfor')
                                        ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodFor','=',$CodFor]]) 
                                        ->get();

            if(count($consultarFornecedor )> 0){
                  foreach ($consultarFornecedor as $fornecedor){
                        $CodFor = $fornecedor->CodFor;
                        $RazSoc = $fornecedor->RazSoc;
                        $CgcCpf = $fornecedor->CgcCpf;
                        $TipFor = $fornecedor->TipFor;
                        $RamAtv = $fornecedor->RamAtv;
                        $TriIcm = $fornecedor->TriIcm;
                        $CodCli = $fornecedor->CodCli;
                        $NumRge = $fornecedor->NumRge;
                        $InsEst = $fornecedor->InsEst;
                        $InsSuf = $fornecedor->InsSuf;
                        $TelFor = $fornecedor->TelFor;
                        $NumFax = $fornecedor->NumFax;
                        $IntNet = $fornecedor->IntNet;
                        $CepFor = $fornecedor->CepFor;
                        $EndFor = $fornecedor->EndFor;
                        $NumFor = $fornecedor->NumFor;
                        $CplFor = $fornecedor->CplFor;
                        $BaiFor = $fornecedor->BaiFor;
                        $CidFor = $fornecedor->CidFor;
                        $UfsFor = $fornecedor->UfsFor;
                        $PaiFor = $fornecedor->PaiFor;
                        $MunFor = $fornecedor->MunFor;
                        $SitFor = $fornecedor->SitFor;

                  

                        return response()->json([
                          'Status' => 'Ok',
                          'CodFor' => $CodFor,
                          'RazSoc' => $RazSoc,
                          'CgcCpf' => $CgcCpf,
                          'TipFor' => $TipFor,
                          'RamAtv' => $RamAtv,
                          'TriIcm' => $TriIcm,
                          'CodCli' => $CodCli,
                          'NumRge' => $NumRge,
                          'InsEst' => $InsEst,
                          'InsSuf' => $InsSuf,
                          'TelFor' => $TelFor,
                          'NumFax' => $NumFax,
                          'IntNet' => $IntNet,
                          'SitFor' => $SitFor,
                          'CepFor' => $CepFor,
                          'EndFor' => $EndFor,
                          'NumFor' => $NumFor,
                          'CplFor' => $CplFor,
                          'BaiFor' => $BaiFor,
                          'CidFor' => $CidFor,
                          'UfsFor' => $UfsFor,
                          'PaiFor' => $PaiFor,
                          'MunFor' => $MunFor,
                        ]);
                  }
            } else {
              return response()->json([
                'Status' => 'NL',
              ]);

            }

  }

  public function indexConsulta(){

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




         return view('erp.zen.cadastros.fornecedor.consultafornecedor')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);

     }else{
        return redirect('/');
     }

  }

  public function buscarfornecedor(Request $request){
        $dados = $request->all();
        $CodUsu = Auth::user()->CodUsu;
                
        $EmpresaLogada = DB::table('e999usulog')
            -> where([['CodUsu','=' , $CodUsu]])
            ->get();


            if(count($EmpresaLogada)>0){
                    foreach($EmpresaLogada as $consulta){
                            $CodEmp = $consulta->CodEmp;
                            $CodFil = $consulta->CodFil;

                            $ConsultaFilial = DB::table('e002cadfil')
                                        -> where([['CodEmp','=' , $CodEmp],['CodFil','=',$CodFil]])
                                        ->get();

                            if(count($ConsultaFilial)>0){
                                foreach($ConsultaFilial as $Filial){
                                     $NomFan = $Filial->NomFan;
                                }

                            }

                    }
            } 


            if((isset($dados['CodFor'])) && (!isset($dados['RazSoc'])) && (!isset($dados['CgcCpf']))){
                    $CodFor = $dados['CodFor'];
                    $consultarFornecedor = DB::table('e003cadfor')
                    ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodFor','=',$CodFor]]) 
                    ->get();

                    if(count($consultarFornecedor )> 0){
                                foreach ($consultarFornecedor as $fornecedor){
                                        $CodFor = $fornecedor->CodFor;
                                        $RazSoc = $fornecedor->RazSoc;
                                        $CgcCpf = $fornecedor->CgcCpf;
                                        $TelFor = $fornecedor->TelFor;
                                        $IntNet = $fornecedor->IntNet;
                                        $SitFor = $fornecedor->SitFor;

                                        if($SitFor =='A'){
                                           $Situacao = 'Ativo';
                                        } else if($SitFor =='I'){
                                          $Situacao = 'Inativo';
                                       }


                                       if(isset($TelFor)){
                                          $TelFor = 'Não Informado';
                                       }

                                       if($TelFor == null){
                                        $TelFor = 'Não Informado';
                                       }

                                          $fornecedores [] = array(
                                            'Status' => 'OK',
                                            'CodFor' => $CodFor,
                                            'RazSoc' => $RazSoc,
                                            'CgcCpf' => $CgcCpf,
                                            'TelFor' => $TelFor,
                                            'IntNet' => $IntNet,
                                            'SitFor' => $Situacao
                                            
                                        );

                  
                                   }

                                   return json_encode($fornecedores);
                    } else {
                                return response()->json([
                                'Status' => 'NL',
                                ]);

                   }
            } else if((!isset($dados['CodFor'])) && (isset($dados['RazSoc'])) && (!isset($dados['CgcCpf']))){
                    $RazSoc = $dados['RazSoc'];
                    $consultarFornecedor = DB::table('e003cadfor')
                    ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['RazSoc','LIKE','%'.$RazSoc.'%']]) 
                    ->get();

                    if(count($consultarFornecedor )> 0){
                                foreach ($consultarFornecedor as $cliente){
                                        $CodFor = $cliente->CodFor;
                                        $RazSoc = $cliente->RazSoc;
                                        $CgcCpf = $cliente->CgcCpf;
                                        $TelFor = $cliente->TelFor;
                                        $IntNet = $cliente->IntNet;
                                        $SitFor = $cliente->SitFor;

                                        if($SitFor =='A'){
                                           $Situacao = 'Ativo';
                                        } else if($SitFor =='I'){
                                          $Situacao = 'Inativo';
                                       }


                                       if(isset($TelFor)){
                                          $TelFor = 'Não Informado';
                                       }

                                       if($TelFor == null){
                                        $TelFor = 'Não Informado';
                                       }

                                          $fornecedores [] = array(
                                            'Status' => 'OK',
                                            'CodFor' => $CodFor,
                                            'RazSoc' => $RazSoc,
                                            'CgcCpf' => $CgcCpf,
                                            'TelFor' => $TelFor,
                                            'IntNet' => $IntNet,
                                            'SitFor' => $Situacao
                                            
                                        );

                  
                                   }

                                   return json_encode($fornecedores);
                    } else {
                                return response()->json([
                                'Status' => 'NL',
                                ]);

                   }
            
            } else if((!isset($dados['CodFor'])) &&  (!isset($dados['RazSoc'])) && (isset($dados['CgcCpf']))){
                      $CgcCpf = $dados['CgcCpf'];
                      $consultarFornecedor = DB::table('e003cadfor')
                      ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CgcCpf','=',$CgcCpf]]) 
                      ->get();

                      if(count($consultarFornecedor )> 0){
                                  foreach ($consultarFornecedor as $fornecedor){
                                          $CodFor = $fornecedor->CodFor;
                                          $RazSoc = $fornecedor->RazSoc;
                                          $CgcCpf = $fornecedor->CgcCpf;
                                          $TelFor = $fornecedor->TelFor;
                                          $IntNet = $fornecedor->IntNet;
                                          $SitFor = $fornecedor->SitFor;

                                          if($SitFor =='A'){
                                            $Situacao = 'Ativo';
                                          } else if($SitFor =='I'){
                                            $Situacao = 'Inativo';
                                        }


                                        if(isset($TelFor)){
                                            $TelFor = 'Não Informado';
                                        }

                                        if($TelFor == null){
                                          $TelFor = 'Não Informado';
                                        }

                                            $fornecedores [] = array(
                                              'Status' => 'OK',
                                              'CodFor' => $CodFor,
                                              'RazSoc' => $RazSoc,
                                              'CgcCpf' => $CgcCpf,
                                              'TelFor' => $TelFor,
                                              'IntNet' => $IntNet,
                                              'SitFor' => $Situacao
                                              
                                          );

                    
                                    }

                                    return json_encode($fornecedores);
                      } else {
                                  return response()->json([
                                  'Status' => 'NL',
                                  ]);

                    }
            } else {
              return response()->json([
                'Status' => 'NL',
                'Msg' => 'Nenhum Fornecedor Localizado com o parâmetro informado.'
                ]);

            }


            

  }


}
