<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Mensagem;
use DB;


class CadastroTributacaoController extends Controller
{
  public function index(){

    if(Auth::check()){
        $CodUsu = Auth::user()->CodUsu;
        $dataAtual = date("Y/m/d");



        $listaDept = DB::table('e008caddep')
                                       ->where('SitDep', '=', 'A')
                                       ->get();


        $listaOrigem = DB::table('e008cadori')
                                    ->where('SitOri', '=', 'A')
                                    ->get();

        $listaCST = DB::table('e008cadcst')
                                ->where([['SitCst', '=', 'A'],['TipCST', '=', 'CST']])
                                  ->get();

        $listaCSOSN = DB::table('e008cadcst')
                                ->where([['SitCst', '=', 'A'],['TipCST', '=', 'CSOSN']])
                                  ->get();

        $listaPISCofins = DB::table('e008cadcst')
                                ->where([['SitCst', '=', 'A'],['TipCST', '=', 'PISCOF'],['TipApl', '=', 'S']])
                                ->orderBy('CodCst', 'ASC')
                                  ->get();

        $listaCofins = DB::table('e008cadcst')
                                ->where([['SitCst', '=', 'A'],['TipCST', '=', 'PISCOF'],['TipApl', '=', 'S']])
                                ->orderBy('CodCst', 'ASC')
                                  ->get();
        $listaIPI = DB::table('e008cadcst')
                                ->where([['SitCst', '=', 'A'],['TipCST', '=', 'IPI'],['TipApl', '=', 'S']])
                                ->orderBy('CodCst', 'ASC')
                                  ->get();

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
          
          
          
          
                   return view('erp.zen.cadastros.produto.tributacaoindividual',compact('listaDept','listaOrigem','listaCST','listaCSOSN','listaPISCofins','listaCofins','listaIPI'))->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);
          

        
       }else{
          return redirect('/');
       }


  }



  public function processar(Request $request)
  {
    $dados = $request->all();
    $CodEmp = $dados['CodEmp'];
  //  $CodFil = $dados['CodFil'];
    $CodPro = $dados['CodPro'];
    $CodOri = $dados['CodOri'];
    $CodTns = $dados['CodTns'];
    $CodCst = $dados['CodCst'];
    $CstIpi = $dados['CstIpi'];
    $CstPis = $dados['CstPis'];
    $CstCof = $dados['CstCof'];
    $TipIpi = $dados['TipIpi'];
    $TipPis = $dados['TipPis'];
    $TipCof = $dados['TipCof'];
    $AliIcm = $dados['AliIcm'];
    $AliIpi = $dados['AliIpi'];
    $CodNcm = $dados['CodNcm'];
    $CodCes = $dados['CodCes'];
    $VlrIpi = $dados['VlrIpi'];
    $VlrPis = $dados['VlrPis'];
    $VlrCof = $dados['VlrCof'];
    $ExcTip = $dados['ExcTip'];
    $AliMva = $dados['AliMva'];
    $TriFed = $dados['TriFed'];
    $TriEst = $dados['TriEst'];
    $TriMun = $dados['TriMun'];
    $CodCsn = $dados['CodCsn'];
    $BasIcm = $dados['BasIcm'];
    $BasISt = $dados['BasISt'];
    $MotDes = $dados['MotDes'];
    $RedIcm = $dados['RedIcm'];
    $RedISt = $dados['RedISt'];
    $AliFcp = $dados['AliFcp'];
    $CodUsu = $dados['CodUsu'];

    $nAliIcm = str_replace(",", ".", $AliIcm);

    if($AliIpi <> ""){
      $nAliIpi = str_replace(",", ".", $AliIpi);
    }else {
      $nAliIpi = "0.00";
    }

    if($VlrIpi <> ""){
      $nVlrIpi = str_replace(",", ".", $VlrIpi);
    }else {
      $nVlrIpi = "0.00";
    }

    if($VlrPis <> ""){
      $nVlrPis = str_replace(",", ".", $VlrPis);
    } else {
      $nVlrPis = "0.00";
    }

    if($VlrCof <> ""){
      $nVlrCof = str_replace(",", ".", $VlrCof);
    }else {
      $nVlrCof = "0.00";
    }

    if($AliMva <> ""){
      $nAliMva = str_replace(",", ".", $AliMva);
    }else {
      $nAliMva = "0.00";
    }

    if($TriFed <> ""){
      $nTriFed = str_replace(",", ".", $TriFed);
    }

    if($TriEst <> ""){
     $nTriEst = str_replace(",", ".", $TriEst);

    }

    if($TriMun <> ""){
      $nTriMun = str_replace(",", ".", $TriMun);
    }else {
      $nTriMun = "0.00";
    }
    if($RedIcm <> ""){
      $nRedIcm = str_replace(",", ".", $RedIcm);
    }else {
      $nRedIcm = "0.00";
    }
    if($RedISt <> ""){
      $nRedISt = str_replace(",", ".", $RedISt);
    }else {
      $nRedISt = "0.00";
    }
    if($AliFcp <> ""){
      $nAliFcp = str_replace(",", ".", $AliFcp);
    }

    


    $consultaproduto = DB::table('e008cadtri')
                         ->where([['CodEmp', '=', $CodEmp],['CodPro','=', $CodPro]])
                         ->get();




    if(count($consultaproduto) >0) {


      $AtualizaTributo = DB::table('e008cadtri')->where([['CodEmp', '=', $CodEmp],['CodPro','=', $CodPro]])->update(
                [
                  'CodOri' => $CodOri,
                  'CodTns' => $CodTns,
                  'CodCst' => $CodCst,
                  'CstIpi' => $CstIpi,
                  'CstPis' => $CstPis,
                  'CstCof' => $CstCof,
                  'TipIpi' => $TipIpi,
                  'TipPis' => $TipPis,
                  'TipCof' => $TipCof,
                  'AliIcm' => $nAliIcm,
                  'AliIpi' => $nAliIpi,
                  'CodNcm' => $CodNcm,
                  'CodCes' => $CodCes,
                  'VlrIpi' => $nVlrIpi,
                  'VlrPis' => $nVlrPis,
                  'VlrCof' => $nVlrCof,
                  'ExcTip' => $ExcTip,
                  'AliMva' => $nAliMva,
                  'TriFed' => $nTriFed,
                  'TriEst' => $nTriEst,
                  'TriMun' => $nTriMun,
                  'CodCsn' => $CodCsn,
                  'BasIcm' => $BasIcm,
                  'BasISt' => $BasISt,
                  'MotDes' => $MotDes,
                  'RedIcm' => $nRedIcm,
                  'RedISt' => $nRedISt,
                  'AliFcp' => $nAliFcp,
                  'UsuAtu' =>$CodUsu,
                  'DatAtu' =>  date('Y/m/d'),
                  'HorAtu' =>  date("H:i:s")
              ]
      );



            return response()->json([
            'Status' => 'OK',
            'Mensagem' => 'Registro Atualizado com Sucesso!'
          ]);




    }else {
          $CadastroTributo = DB::table('e008cadtri')->insert(
          [
          'CodEmp' => $CodEmp,
          'CodPro' => $CodPro,
          'CodOri' => $CodOri,
          'CodTns' => $CodTns,
          'CodCst' => $CodCst,
          'CstIpi' => $CstIpi,
          'CstPis' => $CstPis,
          'CstCof' => $CstCof,
          'TipIpi' => $TipIpi,
          'TipPis' => $TipPis,
          'TipCof' => $TipCof,
          'AliIcm' => $nAliIcm,
          'AliIpi' => $nAliIpi,
          'CodNcm' => $CodNcm,
          'CodCes' => $CodCes,
          'VlrIpi' => $nVlrIpi,
          'VlrPis' => $nVlrPis,
          'VlrCof' => $nVlrCof,
          'ExcTip' => $ExcTip,
          'AliMva' => $nAliMva,
          'TriFed' => $nTriFed,
          'TriEst' => $nTriEst,
          'TriMun' => $nTriMun,
          'CodCsn' => $CodCsn,
          'BasIcm' => $BasIcm,
          'BasISt' => $BasISt,
          'MotDes' => $MotDes,
          'RedIcm' => $nRedIcm,
          'RedISt' => $nRedISt,
          'AliFcp' => $nAliFcp,
          'CodUsu' => $CodUsu,
          'DatCad' =>  date('Y/m/d'),
          'HorCad' =>  date("H:i:s")
        ]
      );

      if ($CadastroTributo == 'true'){
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


  public function consultarCfop(Request $request)
  {
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


  public function ConsultaProduto(Request $request)
  {
    $dados = $request->all();
    $CodPro = $dados['CodPro'];
    $CodEmp = $dados['CodEmp'];



  $consultarProduto = DB::table('e008cadtri')
                       ->where([['CodEmp', '=', $CodEmp],['CodPro','=', $CodPro]])
                       ->get();

    if(count($consultarProduto) >0) {
          foreach ($consultarProduto as $consulta) {
                $CodOri = $consulta->CodOri;

                $CodTns = $consulta->CodTns;

                $consultartransacao = DB::table('e008cadtns')
                                     ->where([['CodTns', '=', $CodTns],['TipTns','=', 'S']])
                                     ->get();

                  if(count($consultartransacao) >0) {
                        foreach ($consultartransacao as $consultaCodTns) {
                          $DesTns = $consultaCodTns->DesTns;


                        }
                  }

                 $CodCst = $consulta ->CodCst;
                 $CstIpi = $consulta ->CstIpi;
                 $CstPis = $consulta ->CstPis;
                 $CstCof = $consulta ->CstCof;
                 $TipIpi = $consulta ->TipIpi;
                 $TipPis = $consulta ->TipPis;
                 $TipCof = $consulta ->TipCof;
                 $AliIcm = $consulta ->AliIcm;
                 $AliIpi = $consulta ->AliIpi;
                 $CodNcm = $consulta ->CodNcm;
                 $CodCes = $consulta ->CodCes;
                 $VlrIpi = $consulta ->VlrIpi;
                 $VlrPis = $consulta ->VlrPis;
                 $VlrCof = $consulta ->VlrCof;
                 $ExcTip = $consulta ->ExcTip;
                 $AliMva = $consulta ->AliMva;
                 $TriFed = $consulta ->TriFed;
                 $TriEst = $consulta ->TriEst;
                 $TriMun = $consulta ->TriMun;
                 $CodCsn = $consulta ->CodCsn;
                 $BasIcm = $consulta ->BasIcm;
                 $BasISt = $consulta ->BasISt;
                 $MotDes = $consulta ->MotDes;
                 $RedIcm = $consulta ->RedIcm;
                 $RedISt = $consulta ->RedISt;
                 $AliFcp = $consulta ->AliFcp;




            $consultarDescricao = DB::table('e008cadpro')
                                 ->where([['CodEmp', '=', $CodEmp],['CodPro','=', $CodPro]])
                                 ->get();

                if(count($consultarDescricao) >0) {
                  foreach ($consultarDescricao as $consultar) {
                    $DesPro = $consultar->DesPro;
                }
              }

                    return response()->json([
                    'Status' => 'Ok',
                    'DesPro' => $DesPro,
                    'CodOri' => $CodOri,
                    'CodTns' => $CodTns,
                    'DesTns' => $DesTns,
                    'CodCst' => $CodCst,
                    'CstIpi' => $CstIpi,
                    'CstPis' => $CstPis,
                    'CstCof' => $CstCof,
                    'TipIpi' => $TipIpi,
                    'TipPis' => $TipPis,
                    'TipCof' => $TipCof,
                    'AliIcm' => $AliIcm,
                    'AliIpi' => $AliIpi,
                    'CodNcm' => $CodNcm,
                    'CodCes' => $CodCes,
                    'VlrIpi' => $VlrIpi,
                    'VlrPis' => $VlrPis,
                    'VlrCof' => $VlrCof,
                    'ExcTip' => $ExcTip,
                    'AliMva' => $AliMva,
                    'TriFed' => $TriFed,
                    'TriEst' => $TriEst,
                    'TriMun' => $TriMun,
                    'CodCsn' => $CodCsn,
                    'BasIcm' => $BasIcm,
                    'BasISt' => $BasISt,
                    'MotDes' => $MotDes,
                    'RedIcm' => $RedIcm,
                    'RedISt' => $RedISt,
                    'AliFcp' => $AliFcp,

                       ]);
          }
    } else {
      $consultarDescricao = DB::table('e008cadpro')
                           ->where([['CodEmp', '=', $CodEmp],['CodPro','=', $CodPro]])
                           ->get();

          if(count($consultarDescricao) >0) {
            foreach ($consultarDescricao as $consultar) {
              $DesPro = $consultar->DesPro;

              return response()->json([
              'Status' => 'OkDescricao',
              'DesPro' =>$DesPro,

                 ]);
            }

          }else {
            return response()->json([
            'Status' => 'ER',
            'Msg' =>'Produto do Código '.$CodPro.' não Cadastrado.',

               ]);

          }

    }

  }


}
