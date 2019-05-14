<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Mensagem;
use DB;
use App\Clientes;

class CadastroClienteController extends Controller
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




         return view('erp.zen.cadastros.cliente.novocliente')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);

     }else{
        return redirect('/');
     }

  }

  public function consultar($CgcFil){

    $contString = strlen($CgcFil);

      if ($contString ==14) {
        $consultarfilial = DB::table('e003cadcli')
                      ->where('CgcCpf', '=', $CgcFil)
                      ->first ();



      } else {
        $consultarfilial = DB::table('e003cadcli')
                      ->where('CodCli', '=', $CgcFil)
                      ->first ();
      }


    return view('erp.zen.cadastros.cliente.cadastrocliente',compact('consultarfilial'));






  }

  public function processar(Request $request){
            $dados = $request->all();
            $CodUsu = Auth::user()->CodUsu;

            $RazSoc = $dados['RazSoc'];
            $RamAtv = $dados['RamAtv'];
            $TriIcm = $dados['TriIcm'];
            $TipCli = $dados['TipoCliente'];
            $CgcCpf = $dados['CgcCpf'];
            $NumRge = $dados['NumRge'];
            $InsEst = $dados['InsEst'];
            $InsSuf = $dados['InsSuf'];
            $SitCli = $dados['SitCli'];

            $TelCli = $dados['TelCli'];
            $FaxCli = $dados['NumFax'];
            $IntNet = $dados['IntNet'];
            $IntNfe = $dados['IntNfe'];
            $IntFin = $dados['IntFin'];
            
            
            $CepCli = $dados['CepCli'];
            $EndCli = $dados['EndCli'];
            $NumCli = $dados['NumCli'];
            $CplCli = $dados['CplCli'];
            $BaiCli = $dados['BaiCli'];
            $CidCli = $dados['CidCli'];
            $UfsCli = $dados['UfsCli'];
            $PaiCli = $dados['PaiCli'];
            $MunCli = $dados['MunCli'];

            $CepEnt = $dados['CepEnt'];
            $EndEnt = $dados['EndEnt'];
            $NumEnt = $dados['NumEnt'];
            $CplEnt = $dados['CplEnt'];
            $BaiEnt = $dados['BaiEnt'];
            $CidEnt = $dados['CidEnt'];
            $UfsEnt = $dados['UfsEnt'];
            $PaiEnt = $dados['PaiEnt'];
            $MunEnt = $dados['MunEnt'];

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
                            'TriIcm' => $TriIcm,
                            'TipCli' => $TipCli,
                            'NumRge' => $NumRge,
                            'InsEst' => $InsEst,
                            'InsSuf' => $InsSuf,
                            'TelCli' => $TelCli,
                            'NumFax' => $FaxCli,
                            'IntNet' => $IntNet,
                            'IntNfe' => $IntNfe,
                            'IntFin' => $IntFin,
                            'CepCli' => $CepCli,
                            'EndCli' => $EndCli,
                            'NumCli' => $NumCli,
                            'CplCli' => $CplCli,
                            'BaiCli' => $BaiCli,
                            'CidCli' => $CidCli,
                            'UfsCli' => $UfsCli,
                            'PaiCli' => $PaiCli,
                            'MunCli' => $MunCli,
                            'CepEnt' => $CepEnt,
                            'EndEnt' => $EndEnt,
                            'NumEnt' => $NumEnt,
                            'CplEnt' => $CplEnt,
                            'BaiEnt' => $BaiEnt,
                            'CidEnt' => $CidEnt,
                            'UfsEnt' => $UfsEnt,
                            'PaiEnt' => $PaiEnt,
                            'MunEnt' => $MunEnt,
                            'SitCli' => $SitCli,
                            'UsuAtu' => $CodUsu,
                            'DtaAtu' =>  date('Y/m/d'),
                            'HorAtu' =>  date("H:i:s")
                    ]
                    );


                    $AtualizaFornecedor = DB::table('e003cadfor')->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])->update(
                      [
                            'RazSoc' => $RazSoc,
                            'RamAtv' => $RamAtv,
                            'TriIcm' => $TriIcm,
                            'TipFor' => $TipCli,
                            'NumRge' => $NumRge,
                            'InsEst' => $InsEst,
                            'InsSuf' => $InsSuf,
                            'TelFor' => $TelCli,
                            'NumFax' => $FaxCli,
                            'IntNet' => $IntNet,
                            'CepFor' => $CepCli,
                            'EndFor' => $EndCli,
                            'NumFor' => $NumCli,
                            'CplFor' => $CplCli,
                            'BaiFor' => $BaiCli,
                            'CidFor' => $CidCli,
                            'UfsFor' => $UfsCli,
                            'PaiFor' => $PaiCli,
                            'MunFor' => $MunCli,
                            'SitFor' => $SitCli,
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
                              'TriIcm' => $TriIcm,
                              'TipCli' => $TipCli,
                              'CgcCpf' => $CgcCpf,
                              'NumRge' => $NumRge,
                              'InsEst' => $InsEst,
                              'InsSuf' => $InsSuf,
                              'TelCli' => $TelCli,
                              'NumFax' => $FaxCli,
                              'IntNet' => $IntNet,
                              'IntNfe' => $IntNfe,
                              'IntFin' => $IntFin,
                              'CepCli' => $CepCli,
                              'EndCli' => $EndCli,
                              'NumCli' => $NumCli,
                              'CplCli' => $CplCli,
                              'BaiCli' => $BaiCli,
                              'CidCli' => $CidCli,
                              'UfsCli' => $UfsCli,
                              'PaiCli' => $PaiCli,
                              'MunCli' => $MunCli,
                              'CepEnt' => $CepEnt,
                              'EndEnt' => $EndEnt,
                              'NumEnt' => $NumEnt,
                              'CplEnt' => $CplEnt,
                              'BaiEnt' => $BaiEnt,
                              'CidEnt' => $CidEnt,
                              'UfsEnt' => $UfsEnt,
                              'PaiEnt' => $PaiEnt,
                              'MunEnt' => $MunEnt,
                              'SitCli' => $SitCli,
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
                                              'TriIcm' => $TriIcm,
                                              'TipFor' => $TipCli,
                                              'CodCli' => $CodCli,
                                              'CgcCpf' => $CgcCpf,
                                              'NumRge' => $NumRge,
                                              'InsEst' => $InsEst,
                                              'InsSuf' => $InsSuf,
                                              'TelFor' => $TelCli,
                                              'NumFax' => $FaxCli,
                                              'IntNet' => $IntNet,
                                              'CepFor' => $CepCli,
                                              'EndFor' => $EndCli,
                                              'NumFor' => $NumCli,
                                              'CplFor' => $CplCli,
                                              'BaiFor' => $BaiCli,
                                              'CidFor' => $CidCli,
                                              'UfsFor' => $UfsCli,
                                              'PaiFor' => $PaiCli,
                                              'MunFor' => $MunCli,
                                              'SitFor' => $SitCli,
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


  public function consultarclientecgc(Request $Request){
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

                    
            $consultarCliente = DB::table('e003cadcli')
                                        ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CgcCpf','=',$CgcCpf]]) 
                                        ->get();

            if(count($consultarCliente )> 0){
                  foreach ($consultarCliente as $cliente){
                        $CodFor = $cliente->CodFor;
                        $RazSoc = $cliente->RazSoc;
                        $TipCli = $cliente->TipCli;
                        $RamAtv = $cliente->RamAtv;
                        $TriIcm = $cliente->TriIcm;
                        $CodCli = $cliente->CodCli;
                        $NumRge = $cliente->NumRge;
                        $InsEst = $cliente->InsEst;
                        $InsSuf = $cliente->InsSuf;
                        $TelCli = $cliente->TelCli;
                        $NumFax = $cliente->NumFax;
                        $IntNet = $cliente->IntNet;
                        $IntNfe = $cliente->IntNfe;
                        $IntFin = $cliente->IntFin;
                        $CepCli = $cliente->CepCli;
                        $EndCli = $cliente->EndCli;
                        $NumCli = $cliente->NumCli;
                        $CplCli = $cliente->CplCli;
                        $BaiCli = $cliente->BaiCli;
                        $CidCli = $cliente->CidCli;
                        $UfsCli = $cliente->UfsCli;
                        $PaiCli = $cliente->PaiCli;
                        $MunCli = $cliente->MunCli;
                        $SitCli = $cliente->SitCli;
                        $CepEnt = $cliente->CepEnt;
                        $EndEnt = $cliente->EndEnt;
                        $NumEnt = $cliente->NumEnt;
                        $CplEnt = $cliente->CplEnt;
                        $BaiEnt = $cliente->BaiEnt;
                        $CidEnt = $cliente->CidEnt;
                        $UfsEnt = $cliente->UfsEnt;
                        $PaiEnt = $cliente->PaiEnt;
                        $MunEnt = $cliente->MunEnt;
                        

                  

                        return response()->json([
                          'Status' => 'Ok',
                          'CodFor' =>$CodFor,
                          'RazSoc' =>$RazSoc,
                          'TipCli' => $TipCli,
                          'RamAtv' => $RamAtv,
                          'TriIcm' => $TriIcm,
                          'CodCli' => $CodCli,
                          'NumRge' => $NumRge,
                          'InsEst' => $InsEst,
                          'InsSuf' => $InsSuf,
                          'TelCli' => $TelCli,
                          'NumFax' => $NumFax,
                          'IntNet' => $IntNet,
                          'IntNfe' => $IntNfe,
                          'IntFin' => $IntFin,
                          'SitCli' => $SitCli,
                          'CepCli' => $CepCli,
                          'EndCli' => $EndCli,
                          'NumCli' => $NumCli,
                          'CplCli' => $CplCli,
                          'BaiCli' => $BaiCli,
                          'CidCli' => $CidCli,
                          'UfsCli' => $UfsCli,
                          'PaiCli' => $PaiCli,
                          'MunCli' => $MunCli,
                          'CepEnt' => $CepEnt,
                          'EndEnt' => $EndEnt,
                          'NumEnt' => $NumEnt,
                          'CplEnt' => $CplEnt,
                          'BaiEnt' => $BaiEnt,
                          'CidEnt' => $CidEnt,
                          'UfsEnt' => $UfsEnt,
                          'PaiEnt' => $PaiEnt,
                          'MunEnt' => $MunEnt,
                        ]);
                  }
            } else {
              return response()->json([
                'Status' => 'NL',
              ]);

            }

  }


  public function consultarclientecodigo(Request $Request){
    $dados = $Request->all();
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

                    
            $consultarCliente = DB::table('e003cadcli')
                                        ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli]]) 
                                        ->get();

            if(count($consultarCliente )> 0){
                  foreach ($consultarCliente as $cliente){
                        $CodFor = $cliente->CodFor;
                        $RazSoc = $cliente->RazSoc;
                        $CgcCpf = $cliente->CgcCpf;
                        $TipCli = $cliente->TipCli;
                        $RamAtv = $cliente->RamAtv;
                        $TriIcm = $cliente->TriIcm;
                        $CodCli = $cliente->CodCli;
                        $NumRge = $cliente->NumRge;
                        $InsEst = $cliente->InsEst;
                        $InsSuf = $cliente->InsSuf;
                        $TelCli = $cliente->TelCli;
                        $NumFax = $cliente->NumFax;
                        $IntNet = $cliente->IntNet;
                        $IntNfe = $cliente->IntNfe;
                        $IntFin = $cliente->IntFin;
                        $CepCli = $cliente->CepCli;
                        $EndCli = $cliente->EndCli;
                        $NumCli = $cliente->NumCli;
                        $CplCli = $cliente->CplCli;
                        $BaiCli = $cliente->BaiCli;
                        $CidCli = $cliente->CidCli;
                        $UfsCli = $cliente->UfsCli;
                        $PaiCli = $cliente->PaiCli;
                        $MunCli = $cliente->MunCli;
                        $SitCli = $cliente->SitCli;
                        $CepEnt = $cliente->CepEnt;
                        $EndEnt = $cliente->EndEnt;
                        $NumEnt = $cliente->NumEnt;
                        $CplEnt = $cliente->CplEnt;
                        $BaiEnt = $cliente->BaiEnt;
                        $CidEnt = $cliente->CidEnt;
                        $UfsEnt = $cliente->UfsEnt;
                        $PaiEnt = $cliente->PaiEnt;
                        $MunEnt = $cliente->MunEnt;
                        

                  

                        return response()->json([
                          'Status' => 'Ok',
                          'CodFor' => $CodFor,
                          'RazSoc' => $RazSoc,
                          'CgcCpf' => $CgcCpf,
                          'TipCli' => $TipCli,
                          'RamAtv' => $RamAtv,
                          'TriIcm' => $TriIcm,
                          'CodCli' => $CodCli,
                          'NumRge' => $NumRge,
                          'InsEst' => $InsEst,
                          'InsSuf' => $InsSuf,
                          'TelCli' => $TelCli,
                          'NumFax' => $NumFax,
                          'IntNet' => $IntNet,
                          'IntNfe' => $IntNfe,
                          'IntFin' => $IntFin,
                          'SitCli' => $SitCli,
                          'CepCli' => $CepCli,
                          'EndCli' => $EndCli,
                          'NumCli' => $NumCli,
                          'CplCli' => $CplCli,
                          'BaiCli' => $BaiCli,
                          'CidCli' => $CidCli,
                          'UfsCli' => $UfsCli,
                          'PaiCli' => $PaiCli,
                          'MunCli' => $MunCli,
                          'CepEnt' => $CepEnt,
                          'EndEnt' => $EndEnt,
                          'NumEnt' => $NumEnt,
                          'CplEnt' => $CplEnt,
                          'BaiEnt' => $BaiEnt,
                          'CidEnt' => $CidEnt,
                          'UfsEnt' => $UfsEnt,
                          'PaiEnt' => $PaiEnt,
                          'MunEnt' => $MunEnt,
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




         return view('erp.zen.cadastros.cliente.consultacliente')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);

     }else{
        return redirect('/');
     }

  }

  public function buscarcliente(Request $request){
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


            if((isset($dados['CodCli'])) && (!isset($dados['RazSoc'])) && (!isset($dados['CgcCpf']))){
                    $CodCli = $dados['CodCli'];
                    $consultarCliente = DB::table('e003cadcli')
                    ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli]]) 
                    ->get();

                    if(count($consultarCliente )> 0){
                                foreach ($consultarCliente as $cliente){
                                        $CodCli = $cliente->CodCli;
                                        $RazSoc = $cliente->RazSoc;
                                        $CgcCpf = $cliente->CgcCpf;
                                        $TelCli = $cliente->TelCli;
                                        $IntNet = $cliente->IntNet;
                                        $SitCli = $cliente->SitCli;

                                        if($SitCli =='A'){
                                           $Situacao = 'Ativo';
                                        } else if($SitCli =='I'){
                                          $Situacao = 'Inativo';
                                       }


                                       if(isset($TelCli)){
                                          $TelCli = 'Não Informado';
                                       }

                                       if($TelCli == null){
                                        $TelCli = 'Não Informado';
                                       }

                                          $Clientes [] = array(
                                            'Status' => 'OK',
                                            'CodCli' => $CodCli,
                                            'RazSoc' => $RazSoc,
                                            'CgcCpf' => $CgcCpf,
                                            'TelCli' => $TelCli,
                                            'IntNet' => $IntNet,
                                            'SitCli' => $Situacao
                                            
                                        );

                  
                                   }

                                   return json_encode($Clientes);
                    } else {
                                return response()->json([
                                'Status' => 'NL',
                                ]);

                   }
            } else if((!isset($dados['CodCli'])) && (isset($dados['RazSoc'])) && (!isset($dados['CgcCpf']))){
                    $RazSoc = $dados['RazSoc'];
                    $consultarCliente = DB::table('e003cadcli')
                    ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['RazSoc','LIKE','%'.$RazSoc.'%']]) 
                    ->get();

                    if(count($consultarCliente )> 0){
                                foreach ($consultarCliente as $cliente){
                                        $CodCli = $cliente->CodCli;
                                        $RazSoc = $cliente->RazSoc;
                                        $CgcCpf = $cliente->CgcCpf;
                                        $TelCli = $cliente->TelCli;
                                        $IntNet = $cliente->IntNet;
                                        $SitCli = $cliente->SitCli;

                                        if($SitCli =='A'){
                                           $Situacao = 'Ativo';
                                        } else if($SitCli =='I'){
                                          $Situacao = 'Inativo';
                                       }


                                       if(isset($TelCli)){
                                          $TelCli = 'Não Informado';
                                       }

                                       if($TelCli == null){
                                        $TelCli = 'Não Informado';
                                       }

                                          $Clientes [] = array(
                                            'Status' => 'OK',
                                            'CodCli' => $CodCli,
                                            'RazSoc' => $RazSoc,
                                            'CgcCpf' => $CgcCpf,
                                            'TelCli' => $TelCli,
                                            'IntNet' => $IntNet,
                                            'SitCli' => $Situacao
                                            
                                        );

                  
                                   }

                                   return json_encode($Clientes);
                    } else {
                                return response()->json([
                                'Status' => 'NL',
                                ]);

                   }
            
            } else if((!isset($dados['CodCli'])) &&  (!isset($dados['RazSoc'])) && (isset($dados['CgcCpf']))){
                      $CgcCpf = $dados['CgcCpf'];
                      $consultarCliente = DB::table('e003cadcli')
                      ->where ([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CgcCpf','=',$CgcCpf]]) 
                      ->get();

                      if(count($consultarCliente )> 0){
                                  foreach ($consultarCliente as $cliente){
                                          $CodCli = $cliente->CodCli;
                                          $RazSoc = $cliente->RazSoc;
                                          $CgcCpf = $cliente->CgcCpf;
                                          $TelCli = $cliente->TelCli;
                                          $IntNet = $cliente->IntNet;
                                          $SitCli = $cliente->SitCli;

                                          if($SitCli =='A'){
                                            $Situacao = 'Ativo';
                                          } else if($SitCli =='I'){
                                            $Situacao = 'Inativo';
                                        }


                                        if(isset($TelCli)){
                                            $TelCli = 'Não Informado';
                                        }

                                        if($TelCli == null){
                                          $TelCli = 'Não Informado';
                                        }

                                            $Clientes [] = array(
                                              'Status' => 'OK',
                                              'CodCli' => $CodCli,
                                              'RazSoc' => $RazSoc,
                                              'CgcCpf' => $CgcCpf,
                                              'TelCli' => $TelCli,
                                              'IntNet' => $IntNet,
                                              'SitCli' => $Situacao
                                              
                                          );

                    
                                    }

                                    return json_encode($Clientes);
                      } else {
                                  return response()->json([
                                  'Status' => 'NL',
                                  ]);

                    }
            } else {
              return response()->json([
                'Status' => 'NL',
                'Msg' => 'Nenhum Cliente Localizado com os parâmetros informado.'
                ]);

            }


            

  }

 



}
