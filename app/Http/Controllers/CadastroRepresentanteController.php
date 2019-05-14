<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Mensagem;
use DB;


class CadastroRepresentanteController extends Controller
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




return view('erp.zen.cadastros.representante.novorepresentante')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);

       }else{
          return redirect('/');
       }


  }


  public function processar(Request $request){
    $dados = $request->all();
    $CodEmp = $dados['CodEmp'];
    $CodFil = $dados['CodFil'];
    $CodUsu = Auth::user()->CodUsu;
    $CgcCpf = $dados['CgcCpf'];
    $RazSoc = $dados['RazSoc'];
    $InsEst = $dados['InsEst'];
    $CepRep = $dados['CepRep'];
    $EndRep = $dados['EndRep'];
    $NumRep = $dados['NumRep'];
    $CplRep = $dados['CplRep'];
    $BaiRep = $dados['BaiRep'];
    $CidRep = $dados['CidRep'];
    $UfsRep = $dados['UfsRep'];
    $SitRep = $dados['SitRep'];
    $IntNet = $dados['IntNet'];


    $lengthCnpj = strlen($CgcCpf); 

    if($lengthCnpj == 14 ){
       $TipCli = 'F';
    }else if($lengthCnpj == 18){
       $TipCli = 'J';
    }

    $consultaEmpresaFilialLogado = DB::table('e999usulog')
                                  ->where([['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil],['CodUsu', '=', $CodUsu]])
                                  ->get();
    if(count($consultaEmpresaFilialLogado) < 0){

      $consulta = DB::table('e999usulog')
                                  ->where([['CodUsu', '=', $CodUsu]])
                                  ->get();
        if(count($consulta)>0){
          $CodEmp = $consulta ->CodEmp;
          $CodFil = $consulta ->CodFil;
        }
           

    }

    $consultaRepresentante = DB::table('e005cadrep')
                ->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])
                ->get();

    if(count($consultaRepresentante) >0) {


      $AtualizaRepresentante = DB::table('e005cadrep')->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])->update(
                [
                  'RazSoc' => $RazSoc,
                  'InsEst' => $InsEst,
                  'IntNet' => $IntNet,
                  'CepRep' => $CepRep,
                  'EndRep' => $EndRep,
                  'NumRep' => $NumRep,
                  'CplRep' => $CplRep,
                  'BaiRep' => $BaiRep,
                  'CidRep' => $CidRep,
                  'UfsRep' => $UfsRep,
                  'SitRep' => $SitRep,
                  'UsuAtu' => $CodUsu,
                  'DtaAtu' =>  date('Y/m/d'),
                  'HorAtu' =>  date("H:i:s")
              ]
            );


            $AtualizaCliente = DB::table('e003cadcli')->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])->update(
              [
                    'RazSoc' => $RazSoc,
                    'InsEst' => $InsEst,
                    'RamAtv' => 'S',
                    'TriIcm' => 'N',
                    'TipCli' => $TipCli,
                    'IntNet' => $IntNet,
                    'CepCli' => $CepRep,
                    'EndCli' => $EndRep,
                    'NumCli' => $NumRep,
                    'CplCli' => $CplRep,
                    'BaiCli' => $BaiRep,
                    'CidCli' => $CidRep,
                    'UfsCli' => $UfsRep,
                    'CepEnt' => $CepRep,
                    'EndEnt' => $EndRep,
                    'NumEnt' => $NumRep,
                    'CplEnt' => $CplRep,
                    'BaiEnt' => $BaiRep,
                    'CidEnt' => $CidRep,
                    'UfsEnt' => $UfsRep,
                    'SitCli' => $SitRep,
                    'UsuAtu' => $CodUsu,
                    'DtaAtu' =>  date('Y/m/d'),
                    'HorAtu' =>  date("H:i:s")
            ]
            );


            $AtualizaFornecedor = DB::table('e003cadfor')->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])->update(
              [
                       'RazSoc' => $RazSoc,
                       'InsEst' => $InsEst,
                       'RamAtv' => 'S',
                       'TriIcm' => 'N',
                       'TipFor' => $TipCli,
                       'IntNet' => $IntNet,
                       'CepFor' => $CepRep,
                       'EndFor' => $EndRep,
                       'NumFor' => $NumRep,
                       'CplFor' => $CplRep,
                       'BaiFor' => $BaiRep,
                       'CidFor' => $CidRep,
                       'UfsFor' => $UfsRep,
                       'SitFor' => $SitRep,
                       'UsuAtu' => $CodUsu,
                       'DtaAtu' =>  date('Y/m/d'),
                       'HorAtu' =>  date("H:i:s")
            ]
            );




            return response()->json([
            'Status' => 'OK',
            'Mensagem' => 'Registro Atualizado com Sucesso!'
          ]);




    }else {
          $CadastroRepresentante = DB::table('e005cadrep')->insert(
          [
              'CodEmp' => $CodEmp,
              'CodFil' => $CodFil,
              'RazSoc' => $RazSoc,
              'InsEst' => $InsEst,
              'CgcCpf' => $CgcCpf,
              'IntNet' => $IntNet,
              'CepRep' => $CepRep,
              'EndRep' => $EndRep,
              'NumRep' => $NumRep,
              'CplRep' => $CplRep,
              'BaiRep' => $BaiRep,
              'CidRep' => $CidRep,
              'UfsRep' => $UfsRep,
              'SitRep' => $SitRep,
              'Codusu' => $CodUsu,
              'DtaCad' =>  date('Y/m/d'),
              'HorCad' =>  date("H:i:s")
        ]
      );

      if ($CadastroRepresentante == 'true'){
                $consultaCliente = DB::table('e003cadcli')
                ->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])
                ->get();

                if(count($consultaCliente)==0){
                          $CadastroCliente = DB::table('e003cadcli')->insert(
                            [
                                'CodEmp' => $CodEmp,
                                'CodFil' => $CodFil,
                                'RazSoc' => $RazSoc,
                                'InsEst' => $InsEst,
                                'CgcCpf' => $CgcCpf,
                                'RamAtv' => 'S',
                                'TriIcm' => 'N',
                                'TipCli' => $TipCli,
                                'IntNet' => $IntNet,
                                'CepCli' => $CepRep,
                                'EndCli' => $EndRep,
                                'NumCli' => $NumRep,
                                'CplCli' => $CplRep,
                                'BaiCli' => $BaiRep,
                                'CidCli' => $CidRep,
                                'UfsCli' => $UfsRep,
                                'CepEnt' => $CepRep,
                                'EndEnt' => $EndRep,
                                'NumEnt' => $NumRep,
                                'CplEnt' => $CplRep,
                                'BaiEnt' => $BaiRep,
                                'CidEnt' => $CidRep,
                                'UfsEnt' => $UfsRep,
                                'SitCli' => $SitRep,
                                'Codusu' => $CodUsu,
                                'DtaCad' =>  date('Y/m/d'),
                                'HorCad' =>  date("H:i:s")
                          ]
                        );

                        if($CadastroCliente =="true"){

                                  $consultaCliente = DB::table('e003cadcli')
                                                    ->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])
                                                    ->get();

                                  if(count($consultaCliente)>0){
                                          foreach($consultaCliente as $cliente ){
                                                  $CodCli = $cliente->CodCli;
                                                  $CadastroFornecedor = DB::table('e003cadfor')->insert(
                                                    [
                                                        'CodEmp' => $CodEmp,
                                                        'CodFil' => $CodFil,
                                                        'CodFor' => $CodCli,
                                                        'RazSoc' => $RazSoc,
                                                        'RamAtv' => 'S',
                                                        'TriIcm' => 'N',
                                                        'TipFor' => $TipCli,
                                                        'IntNet' => $IntNet,
                                                        'CodCli' => $CodCli,
                                                        'InsEst' => $InsEst,
                                                        'CgcCpf' => $CgcCpf,
                                                        'CepFor' => $CepRep,
                                                        'EndFor' => $EndRep,
                                                        'NumFor' => $NumRep,
                                                        'CplFor' => $CplRep,
                                                        'BaiFor' => $BaiRep,
                                                        'CidFor' => $CidRep,
                                                        'UfsFor' => $UfsRep,
                                                        'SitFor' => $SitRep,
                                                        'Codusu' => $CodUsu,
                                                        'DtaCad' =>  date('Y/m/d'),
                                                        'HorCad' =>  date("H:i:s")
                                                  ]
                                                 );

                                                 if($CadastroFornecedor=="true"){
                                                        $consultaFornecedor = DB::table('e003cadfor')
                                                                              ->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])
                                                                              ->get();

                                                        if(count($consultaFornecedor)>0){
                                                              foreach($consultaFornecedor as $Fornecedor){
                                                                            $CodFor = $Fornecedor ->CodFor;

                                                                            $AtualizaCliente = DB::table('e003cadcli')->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])->update(
                                                                              [
                                                                                'CodFor' => $CodFor,
                                                                                'UsuAtu' => $CodUsu,
                                                                                'DtaAtu' =>  date('Y/m/d'),
                                                                                'HorAtu' =>  date("H:i:s")
                                                                            ]
                                                                            );
                                        
                                                                            
                                                                            $AtualizaRepresentante = DB::table('e005cadrep')->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])->update(
                                                                              [
                                                                                'CodFor' => $CodFor,
                                                                                'CodCli' => $CodCli,
                                                                                'UsuAtu' => $CodUsu,
                                                                                'DtaAtu' =>  date('Y/m/d'),
                                                                                'HorAtu' =>  date("H:i:s")
                                                                            ]
                                                                            );

                                                                            
                                                              }
                                                        }
                                                 }
                                          }
                                    }
                          } 
                }else {
                  $consultaCliente = DB::table('e003cadcli')
                  ->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])
                  ->get();

                  if(count($consultaCliente)>0){
                          foreach($consultaCliente as $cliente ){
                                  $CodCli = $cliente->CodCli;
                                }
                  }

                  $consultaFornecedor = DB::table('e003cadfor')
                  ->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])
                  ->get();

                  if(count($consultaFornecedor)>0){
                          foreach($consultaFornecedor as $fornecedor ){
                                  $CodFor = $fornecedor->CodFor;
                                }
                  }


                  $AtualizaRepresentante = DB::table('e005cadrep')->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])->update(
                    [
                      'CodFor' => $CodFor,
                      'CodCli' => $CodCli,
                      'UsuAtu' => $CodUsu,
                      'DtaAtu' =>  date('Y/m/d'),
                      'HorAtu' =>  date("H:i:s")
                  ]
                  );



                  $AtualizaCliente = DB::table('e003cadcli')->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])->update(
                    [
                          'RazSoc' => $RazSoc,
                          'InsEst' => $InsEst,
                          'RamAtv' => 'S',
                          'TriIcm' => 'N',
                          'TipCli' => $TipCli,
                          'IntNet' => $IntNet,
                          'CepCli' => $CepRep,
                          'EndCli' => $EndRep,
                          'NumCli' => $NumRep,
                          'CplCli' => $CplRep,
                          'BaiCli' => $BaiRep,
                          'CidCli' => $CidRep,
                          'UfsCli' => $UfsRep,
                          'CepEnt' => $CepRep,
                          'EndEnt' => $EndRep,
                          'NumEnt' => $NumRep,
                          'CplEnt' => $CplRep,
                          'BaiEnt' => $BaiRep,
                          'CidEnt' => $CidRep,
                          'UfsEnt' => $UfsRep,
                          'SitCli' => $SitRep,
                          'UsuAtu' => $CodUsu,
                          'DtaAtu' =>  date('Y/m/d'),
                          'HorAtu' =>  date("H:i:s")
                  ]
                  );


                  $AtualizaFornecedor = DB::table('e003cadfor')->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])->update(
                    [
                             'RazSoc' => $RazSoc,
                             'InsEst' => $InsEst,
                             'RamAtv' => 'S',
                             'TriIcm' => 'N',
                             'TipFor' => $TipCli,
                             'IntNet' => $IntNet,
                             'CepFor' => $CepRep,
                             'EndFor' => $EndRep,
                             'NumFor' => $NumRep,
                             'CplFor' => $CplRep,
                             'BaiFor' => $BaiRep,
                             'CidFor' => $CidRep,
                             'UfsFor' => $UfsRep,
                             'SitFor' => $SitRep,
                             'UsuAtu' => $CodUsu,
                             'DtaAtu' =>  date('Y/m/d'),
                             'HorAtu' =>  date("H:i:s")
                  ]
                  );

                }
                return response()->json([
                  'Status' => 'OK',
                  'Mensagem' => 'Registro Incluido com Sucesso!'
              ]);

      }else{
            return response()->json([
            'Status' => 'Erro',
            'Mensagem' => 'Ocorreu um erro ao inserir o Registro . Tente Novamente'
              ]);
      }



    }
}

public function consultarcgccpf(Request $request){
    $dados = $request->all();
    $CodEmp = $dados['CodEmp'];
    $CodFil = $dados['CodFil'];
    $CgcCpf = $dados['CgcCpf'];
    $CodUsu = Auth::user()->CodUsu;

    $consultaEmpresaFilialLogado = DB::table('e999usulog')
          ->where([['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil],['CodUsu', '=', $CodUsu]])
          ->get();
      if(count($consultaEmpresaFilialLogado) < 0){

              $consulta = DB::table('e999usulog')
                  ->where([['CodUsu', '=', $CodUsu]])
                  ->get();
              if(count($consulta)>0){
              $CodEmp = $consulta ->CodEmp;
              $CodFil = $consulta ->CodFil;
      }
    }

      $consultarepresentante = DB::table('e005cadrep')
      ->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])
      ->get();

      if(count($consultarepresentante) >0) {
            foreach ($consultarepresentante as $consultar) {
              return response()->json([
                  'Status' => 'Localizado',
                  'CodRep' => $consultar->CodRep,
                  'RazSoc' => $consultar->RazSoc,
                  'InsEst' => $consultar->InsEst,
                  'CgcCpf' => $consultar->CgcCpf,
                  'IntNet' => $consultar->IntNet,
                  'CodCli' => $consultar->CodCli,
                  'CodFor' => $consultar->CodFor,
                  'CepRep' => $consultar->CepRep,
                  'EndRep' => $consultar->EndRep,
                  'NumRep' => $consultar->NumRep,
                  'CplRep' => $consultar->CplRep,
                  'BaiRep' => $consultar->BaiRep,
                  'CidRep' => $consultar->CidRep,
                  'UfsRep' => $consultar->UfsRep,
                  'SitRep' => $consultar->SitRep
              ]);
             }
        } else {
          return response()->json([
            'Status' => 'ER',
            'Msg' =>'Não Localizado pelo CPF/CNPJ Informado.',
  
               ]);
  
        }



}

  public function consultarcodigo(Request $request){
    $dados = $request->all();
    $CodEmp = $dados['CodEmp'];
    $CodFil = $dados['CodFil'];
    $CodRep = $dados['CodRep'];
    $CodUsu = Auth::user()->CodUsu;

    $consultaEmpresaFilialLogado = DB::table('e999usulog')
          ->where([['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil],['CodUsu', '=', $CodUsu]])
          ->get();
      if(count($consultaEmpresaFilialLogado) < 0){

              $consulta = DB::table('e999usulog')
                  ->where([['CodUsu', '=', $CodUsu]])
                  ->get();
              if(count($consulta)>0){
              $CodEmp = $consulta ->CodEmp;
              $CodFil = $consulta ->CodFil;
      }
    }

      $consultarepresentante = DB::table('e005cadrep')
      ->where([['CodRep', '=', $CodRep],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])
      ->get();

      if(count($consultarepresentante) >0) {
            foreach ($consultarepresentante as $consultar) {
              return response()->json([
                  'Status' => 'Localizado',
                  'RazSoc' => $consultar->RazSoc,
                  'InsEst' => $consultar->InsEst,
                  'CgcCpf' => $consultar->CgcCpf,
                  'IntNet' => $consultar->IntNet,
                  'CodCli' => $consultar->CodCli,
                  'CodFor' => $consultar->CodFor,
                  'CepRep' => $consultar->CepRep,
                  'EndRep' => $consultar->EndRep,
                  'NumRep' => $consultar->NumRep,
                  'CplRep' => $consultar->CplRep,
                  'BaiRep' => $consultar->BaiRep,
                  'CidRep' => $consultar->CidRep,
                  'UfsRep' => $consultar->UfsRep,
                  'SitRep' => $consultar->SitRep 
              ]);
             }
        } else {
          return response()->json([
            'Status' => 'ER',
            'Msg' =>'Código do Representante informado não Localizada na Empresa e Filial Logada',
  
               ]);
  
        }


  }

}
