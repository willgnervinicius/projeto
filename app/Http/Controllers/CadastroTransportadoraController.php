<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Mensagem;
use DB;


class CadastroTransportadoraController extends Controller
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




         return view('erp.zen.cadastros.transportadora.novatransportadora')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);


         
       }else{
          return redirect('/');
       }


  }



  public function processar(Request $request)
  {
    $dados = $request->all();
    $CodEmp = $dados['CodEmp'];
    $CodFil = $dados['CodFil'];
    $CodUsu = Auth::user()->CodUsu;
    $CgcCpf = $dados['CgcCpf'];
    $RazSoc = $dados['RazSoc'];
    $InsEst = $dados['InsEst'];
    $CepTra = $dados['CepTra'];
    $EndTra = $dados['EndTra'];
    $NumTra = $dados['NumTra'];
    $CplTra = $dados['CplTra'];
    $BaiTra = $dados['BaiTra'];
    $CidTra = $dados['CidTra'];
    $UfsTra = $dados['UfsTra'];
    $SitTra = $dados['SitTra'];

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

    $consultatransportadora = DB::table('e004cadtra')
                ->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])
                ->get();

    if(count($consultatransportadora) >0) {


      $AtualizaTransportadora = DB::table('e004cadtra')->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])->update(
                [
                   'RazSoc' => $RazSoc,
                   'InsEst' => $InsEst,
                   'CepTra' => $CepTra,
                   'EndTra' => $EndTra,
                   'NumTra' => $NumTra,
                   'CplTra' => $CplTra,
                   'BaiTra' => $BaiTra,
                   'CidTra' => $CidTra,
                   'UfsTra' => $UfsTra,
                   'SitTra' => $SitTra,
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
          $CadastroTransportadora = DB::table('e004cadtra')->insert(
          [
              'CodEmp' => $CodEmp,
              'CodFil' => $CodFil,
              'RazSoc' => $RazSoc,
              'InsEst' => $InsEst,
              'CgcCpf' => $CgcCpf,
              'CepTra' => $CepTra,
              'EndTra' => $EndTra,
              'NumTra' => $NumTra,
              'CplTra' => $CplTra,
              'BaiTra' => $BaiTra,
              'CidTra' => $CidTra,
              'UfsTra' => $UfsTra,
              'SitTra' => $SitTra,
              'Codusu' => $CodUsu,
              'DtaCad' =>  date('Y/m/d'),
              'HorCad' =>  date("H:i:s")
        ]
      );

      if ($CadastroTransportadora == 'true'){
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

      $consultatransportadora = DB::table('e004cadtra')
      ->where([['CgcCpf', '=', $CgcCpf],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])
      ->get();

      if(count($consultatransportadora) >0) {
            foreach ($consultatransportadora as $consultar) {
              return response()->json([
                  'Status' => 'Localizado',
                  'CodTra' => $consultar->CodTra,
                  'RazSoc' => $consultar->RazSoc,
                  'InsEst' => $consultar->InsEst,
                  'CgcCpf' => $consultar->CgcCpf,
                  'CepTra' => $consultar->CepTra,
                  'EndTra' => $consultar->EndTra,
                  'NumTra' => $consultar->NumTra,
                  'CplTra' => $consultar->CplTra,
                  'BaiTra' => $consultar->BaiTra,
                  'CidTra' => $consultar->CidTra,
                  'UfsTra' => $consultar->UfsTra,
                  'SitTra' => $consultar->SitTra 
              ]);
             }
        } else {
          return response()->json([
            'Status' => 'ER',
            'Msg' =>'Código da Transportadora Informada não Localizada',
  
               ]);
  
        }



}

  public function consultarcodigo(Request $request){
    $dados = $request->all();
    $CodEmp = $dados['CodEmp'];
    $CodFil = $dados['CodFil'];
    $CodTra = $dados['CodTra'];
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

      $consultatransportadora = DB::table('e004cadtra')
      ->where([['CodTra', '=', $CodTra],['CodEmp', '=', $CodEmp],['CodFil', '=', $CodFil]])
      ->get();

      if(count($consultatransportadora) >0) {
            foreach ($consultatransportadora as $consultar) {
              return response()->json([
                  'Status' => 'Localizado',
                  'RazSoc' => $consultar->RazSoc,
                  'InsEst' => $consultar->InsEst,
                  'CgcCpf' => $consultar->CgcCpf,
                  'CepTra' => $consultar->CepTra,
                  'EndTra' => $consultar->EndTra,
                  'NumTra' => $consultar->NumTra,
                  'CplTra' => $consultar->CplTra,
                  'BaiTra' => $consultar->BaiTra,
                  'CidTra' => $consultar->CidTra,
                  'UfsTra' => $consultar->UfsTra,
                  'SitTra' => $consultar->SitTra 
              ]);
             }
        } else {
          return response()->json([
            'Status' => 'ER',
            'Msg' =>'Código da Transportadora Informada não Localizada na Empresa e Filial Logada',
  
               ]);
  
        }


  }

}
