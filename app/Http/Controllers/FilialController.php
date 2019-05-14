<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Mensagem;
use Auth;
use App\Filial;
use App\Empresa;

class FilialController extends Controller
{
  public function index ()
  {
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




       return view('erp.zen.cadastros.filial.novafilial')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);


     
     }else{
        return redirect('/');
     }



    }

  public function processar(Request $req)
  {
          $dados = $req->all();

          $CgcFil  =$dados['CgcFil'];
          $pontos = array("/", ".","-");
          $Cgc = str_replace($pontos, "", $CgcFil);

          $CodEmp = $dados['CodEmp'];
          $RazSoc =$dados['RazSoc'];
          $NomFan =$dados['NomFan'];
          $CodCli =$dados['CodCli'];
          $CodFor =$dados['CodFor'];
          $CgcFil =$Cgc;
          $RamAtv =$dados['RamAtv'];
          $InsEst =$dados['InsEst'];
          $InsMun =$dados['InsMun'];
          $NumTel =$dados['NumTel'];
          $NumFax =$dados['NumFax'];
          $IntNet =$dados['IntNet'];
          $FilMat =$dados['FilMat'];
          $SitFil =$dados['SitFil'];
          $CepFil =$dados['CepFil'];
          $EndFil =$dados['EndFil'];
          $NumFil =$dados['NumFil'];
          $CplFil =$dados['CplFil'];
          $BaiFil =$dados['BaiFil'];
          $CidFil= $dados['CidFil'];
          $UfsFil =$dados['UfsFil'];
          $CodPai =$dados['CodPai'];
          $MunIbg =$dados['MunIbg'];
          $CodUsu = $dados['CodUsu'];
          

          $consultafilial = Filial::where([['CodEmp', '=', $CodEmp],['CgcFil','=', $Cgc]]) ->get();


     



     if(count($consultafilial) >0) {


       $AtualizarFilial = Filial::where([['CodEmp', '=', $CodEmp],['CgcFil','=', $Cgc]])->update(
                 [
                   'RazSoc' => $RazSoc,
                   'NomFan' => $NomFan,
                   'CodCli' => $CodCli,
                   'CodFor' => $CodFor,
                   'RamAtv' => $RamAtv,
                   'InsEst' => $InsEst,
                   'InsMun' => $InsMun,
                   'NumTel' => $NumTel,
                   'NumFax' => $NumFax,
                   'IntNet' => $IntNet,
                   'FilMat' => $FilMat,
                   'SitFil' => $SitFil,
                   'CepFil' => $CepFil,
                   'EndFil' => $EndFil,
                   'NumFil' => $NumFil,
                   'CplFil' => $CplFil,
                   'BaiFil' => $BaiFil,
                   'CidFil' => $CidFil,
                   'UfsFil' => $UfsFil,
                   'CodPai' => $CodPai,
                   'MunIbg' => $MunIbg,
                   'CodUsu' => $CodUsu,
                   'DatAtu' =>  date('Y/m/d'),
                   'HorAtu' =>  date("H:i:s")
               ]
       );



             return response()->json([
             'Status' => 'OK',
             'Mensagem' => 'Registro Atualizado com Sucesso!'
           ]);




     }else {

           $codigofilial = Filial::where([['CodEmp', '=', $CodEmp]])->get();
           
          if(count($codigofilial) >0) {
              foreach ($codigofilial as $codigo) {
                           $UltimoCodigo =  $codigo->CodFil;
              }
             $CodFil = $UltimoCodigo + 1;

        } else {
          $CodFil = 1;
        }




           $CadastroFilial = Filial::insert(
           [
            'CodEmp' => $CodEmp,
            'CodFil' => $CodFil,
            'RazSoc' => $RazSoc,
            'NomFan' => $NomFan,
            'CodCli' => $CodCli,
            'CodFor' => $CodFor,
            'CgcFil' => $Cgc,
            'RamAtv' => $RamAtv,
            'InsEst' => $InsEst,
            'InsMun' => $InsMun,
            'NumTel' => $NumTel,
            'NumFax' => $NumFax,
            'IntNet' => $IntNet,
            'FilMat' => $FilMat,
            'SitFil' => $SitFil,
            'CepFil' => $CepFil,
            'EndFil' => $EndFil,
            'NumFil' => $NumFil,
            'CplFil' => $CplFil,
            'BaiFil' => $BaiFil,
            'CidFil' => $CidFil,
            'UfsFil' => $UfsFil,
            'CodPai' => $CodPai,
            'MunIbg' => $MunIbg,
            'CodUsu' => $CodUsu,
            'DatCad' =>  date('Y/m/d'),
            'HorCad' =>  date("H:i:s")
         ]
       );

       if ($CadastroFilial == 'true'){
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


public function validaempresaxfilialcnpj (Request $request){

     $dados = $request->all();
     $CodEmp = $dados['CodEmp'];

     $CgcFil = $dados['CgcFil'];

     $pontos = array("/", ".","-");
     $Cgc = str_replace($pontos, "", $CgcFil);

     $Cnpj = substr($Cgc, 0, 8);



   $consultarfilialxempresa = Empresa::where([['CodEmp', '=', $CodEmp],['CgcMat','LIKE', '%'.$Cnpj.'%']]) ->get();
   

     if(count($consultarfilialxempresa) >0) {
           foreach ($consultarfilialxempresa as $consulta) {
                  
                 $consultarfilial = Filial::where([['CodEmp', '=', $CodEmp],['CgcFil','=', $Cgc]]) ->get();


                  if(count($consultarfilial) > 0){
                        foreach ($consultarfilial as $consultar) {
                               return response()->json([
                                 'Status' => 'Localizado',
                                 'CodFil' => $consultar->CodFil,
                                 'RazSoc' => $consultar->RazSoc,
                                 'NomFan' => $consultar->NomFan,
                                 'CodCli' => $consultar->CodCli,
                                 'CodFor' => $consultar->CodFor,
                                 'RamAtv' => $consultar->RamAtv,
                                 'InsEst' => $consultar->InsEst,
                                 'InsMun' => $consultar->InsMun,
                                 'NumTel' => $consultar->NumTel,
                                 'NumFax' => $consultar->NumFax,
                                 'IntNet' => $consultar->IntNet,
                                 'FilMat' => $consultar->FilMat,
                                 'SitFil' => $consultar->SitFil,
                                 'CepFil' => $consultar->CepFil,
                                 'EndFil' => $consultar->EndFil,
                                 'NumFil' => $consultar->NumFil,
                                 'CplFil' => $consultar->CplFil,
                                 'BaiFil' => $consultar->BaiFil,
                                 'CidFil' => $consultar->CidFil,
                                 'UfsFil' => $consultar->UfsFil,
                                 'CodPai' => $consultar->CodPai,
                                 'MunIbg' => $consultar->MunIbg,
                               ]);
                        }
                  } else {
                    return response()->json([
                    'Status' => 'Ok',


                       ]);
                  }
           }
     } else {
       return response()->json([
       'Status' => 'ER',
       'Msg' =>'Raiz do CNPJ Informado não pertence a Empresa Logada ',

          ]);
     }

}






public function consultar(Request $request)
{
  $dados = $request->all();
  $CodEmp = $dados['CodEmp'];
  $CodFil = $dados['CodFil'];




   $consultarfilial = Filial::where([['CodEmp', '=', $CodEmp],['CodFil','=', $CodFil]]) ->get();


    if(count($consultarfilial) >0) {
          foreach ($consultarfilial as $consultar) {
                              return response()->json([
                                'Status' => 'Localizado',
                                'CodFil' => $consultar->CodFil,
                                'RazSoc' => $consultar->RazSoc,
                                'NomFan' => $consultar->NomFan,
                                'CgcFil' => $consultar->CgcFil,
                                'CodCli' => $consultar->CodCli,
                                'CodFor' => $consultar->CodFor,
                                'RamAtv' => $consultar->RamAtv,
                                'InsEst' => $consultar->InsEst,
                                'InsMun' => $consultar->InsMun,
                                'NumTel' => $consultar->NumTel,
                                'NumFax' => $consultar->NumFax,
                                'IntNet' => $consultar->IntNet,
                                'FilMat' => $consultar->FilMat,
                                'SitFil' => $consultar->SitFil,
                                'CepFil' => $consultar->CepFil,
                                'EndFil' => $consultar->EndFil,
                                'NumFil' => $consultar->NumFil,
                                'CplFil' => $consultar->CplFil,
                                'BaiFil' => $consultar->BaiFil,
                                'CidFil' => $consultar->CidFil,
                                'UfsFil' => $consultar->UfsFil,
                                'CodPai' => $consultar->CodPai,
                                'MunIbg' => $consultar->MunIbg,
                              ]);
              }

        } else {
          return response()->json([
          'Status' => 'ER',
          'Msg' =>'Código da Filial Informada não Localizada',

             ]);

        }


}
}
