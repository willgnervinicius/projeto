<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Mensagem;
use DB;


class CadastroProdutoController extends Controller
{
  public function index(){

    if(Auth::check()){
        $CodUsu = Auth::user()->CodUsu;
        $dataAtual = date("Y/m/d");

        $listaDept = DB::table('e008caddep')
                    ->where('SitDep', '=', 'A')
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




          return view('erp.zen.cadastros.produto.novoproduto',compact('listaDept'))->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);


        
       }else{
          return redirect('/');
       }


  }



  public function processar(Request $request)
  {
    $dados = $request->all();
    $CodEmp = $dados['CodEmp'];
    $CodPro = $dados['CodPro'];
    $DesPro = $dados['DesPro'];
    $DesEmb = $dados['DesEmb'];
    $UniMed = $dados['UniMed'];
    $TipPro = $dados['TipPro'];
    $TipMer = $dados['TipMer'];
    $CtlEst = $dados['CtlEst'];
    $CodDep = $dados['CodDep'];
    $CodGru = $dados['CodGru'];
    $CodSub = $dados['CodSub'];
    $DesNfe = $dados['DesNfe'];
    $SitPro = $dados['SitPro'];
    $CodUsu = Auth::user()->CodUsu;


    $DesPro = strtoupper($DesPro);

    $EmpresaLogada = DB::table('e999usulog')
    -> where([['CodUsu','=' , $CodUsu]])
    ->get();


        if(count($EmpresaLogada)>0){
              foreach($EmpresaLogada as $consulta){
                    $CodEmp = $consulta->CodEmp;
                    $CodFil = $consulta->CodFil;

              }
        }

    $consultaproduto = DB::table('e008cadpro')
                         ->where([['CodEmp', '=', $CodEmp],['CodPro','=', $CodPro]])
                         ->get();




    if(count($consultaproduto) >0) {


      $AtualizaProduto = DB::table('e008cadpro')->where([['CodEmp', '=', $CodEmp],['CodPro','=', $CodPro]])->update(
                [
                  'DesPro' =>$DesPro,
                  'NomPro' =>$NomPro,
                  'DesEmb' =>$DesEmb,
                  'UniMed' =>$UniMed,
                  'TipPro' =>$TipPro,
                  'TipMer' =>$TipMer,
                  'CtlEst' =>$CtlEst,
                  'CodDep' =>$CodDep,
                  'CodGru' =>$CodGru,
                  'CodSub' =>$CodSub,
                  'DesNfe' =>$DesNfe,
                  'SitPro' =>$SitPro,
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
          $CadastroProduto = DB::table('e008cadpro')->insert(
          [
          'CodEmp' => $CodEmp,
          'CodPro' =>$CodPro,
          'DesPro' =>$DesPro,
          'DesEmb' =>$DesEmb,
          'UniMed' =>$UniMed,
          'TipPro' =>$TipPro,
          'TipMer' =>$TipMer,
          'CtlEst' =>$CtlEst,
          'CodDep' =>$CodDep,
          'CodGru' =>$CodGru,
          'CodSub' =>$CodSub,
          'DesNfe' =>$DesNfe,
          'SitPro' =>$SitPro,
          'CodUsu' =>$CodUsu,
          'DatCad' =>  date('Y/m/d'),
          'HorCad' =>  date("H:i:s")
        ]
      );

      if ($CadastroProduto == 'true'){

                  $EntradaEstoque = DB::table('e802movest')->insert(
                    [
                    'CodEmp' => $CodEmp,
                    'CodFil' => $CodFil,
                    'CodPro' => $CodPro,
                    'UniMed' => $UniMed,
                    'TipMov' => 'AS',
                    'DesMov' => 'Saldo Inicial',
                    'EstAnt' => '0.000',
                    'QtdMov' => '0.000',
                    'EstAtu' => '0.000',
                    'DtaMov' => date('Y/m/d'),
                    'HorMov' => date("H:i:s"),
                    'CodUsu' =>$CodUsu
                ]
                );
                 
                if ($EntradaEstoque == 'true'){
                    return response()->json([
                          'Status' => 'OK',
                          'Mensagem' => 'Registro Incluido com Sucesso!'
                      ]);
                }
      }else{
            return response()->json([
            'Status' => 'Erro'
              ]);
      }



    }
  }


  public function ConsultaGrupo(Request $request){
      $dados = $request->all();
      $CodDep = $dados['CodDep'];

      $arrayGrupo = array();

    $consultargrupo = DB::table('e008cadgru')
                         ->where([['CodDep', '=', $CodDep],['SitGru','=', 'A']])
                         ->get();

          if(count($consultargrupo) >0) {
                    foreach ($consultargrupo as $consulta) {
                      $CodGru = $consulta->CodGru;
                      $NomGru = $consulta->NomGru;

                        $grupos [] = array('Status'=>'OK','CodGru'=>$CodGru,'NomGru'=> $NomGru);




                    }

                    return json_encode($grupos);
        } else {
                $grupos [] = array('Status'=>'ER','CodGru'=>'9999999999','NomGru'=> 'Não encontrado Grupos');
                return json_encode($grupos);
        }

}

  public function ConsultaSubGrupo(Request $request){
      $dados = $request->all();
      $CodGru = $dados['CodGru'];



    $consultarsubgrupo = DB::table('e008cadsub')
                         ->where([['CodGru', '=', $CodGru],['SitSub','=', 'A']])
                         ->get();

      if(count($consultarsubgrupo) >0) {
            foreach ($consultarsubgrupo as $consulta) {
                $CodSub = $consulta->CodSub;
                $NomSub = $consulta->NomSub;

                $subgrupos [] = array('Status'=>'OK','CodSub'=>$CodSub,'NomSub'=> $NomSub);

            }
              return json_encode($subgrupos);
          } else {
                  $grupos [] = array('Status'=>'ER','CodSub'=>'9999999999','NomSub'=> 'Não encontrado SubGrupos');
                  return json_encode($grupos);
          }


  }


  public function ConsultarProduto (Request $request){
    $dados = $request->all();
    $CodEmp = $dados['CodEmp'];
    $CodPro = $dados['CodPro'];



  $consultarproduto = DB::table('e008cadpro')
                       ->where([['CodEmp', '=', $CodEmp],['CodPro','=', $CodPro]])
                       ->get();

    if(count($consultarproduto) >0) {
          foreach ($consultarproduto as $consulta) {
            $DesPro = $consulta->DesPro;
            $DesEmb = $consulta->DesEmb;
            $UniMed = $consulta->UniMed;
            $TipPro = $consulta->TipPro;
            $TipMer = $consulta->TipMer;
            $CtlEst = $consulta->CtlEst;
            $CodDep = $consulta->CodDep;
            $CodGru = $consulta->CodGru;
            $CodSub = $consulta->CodSub;
            $DesNfe = $consulta->DesNfe;
            $SitPro = $consulta->SitPro;

            return response()->json([
            'Status' => 'Ok',
            'DesPro' =>$DesPro,
            'DesEmb' =>$DesEmb,
            'UniMed' =>$UniMed,
            'TipPro' =>$TipPro,
            'TipMer' =>$TipMer,
            'CtlEst' =>$CtlEst,
            'CodDep' =>$CodDep,
            'CodGru' =>$CodGru,
            'CodSub' =>$CodSub,
            'DesNfe' =>$DesNfe,
            'SitPro' =>$SitPro
               ]);
          }
    }

  }


 public function ConsultarDescricaoProduto(Request $request){
  $dados = $request->all();
  $CodPro = $dados['CodPro'];
  $CodUsu = Auth::user()->CodUsu;

  $consultaEmpresaFilialLogado = DB::table('e999usulog')
        ->where([['CodUsu', '=', $CodUsu]])
        ->get();
    if(count($consultaEmpresaFilialLogado) > 0){
          foreach($consultaEmpresaFilialLogado as $consulta) {
            $CodEmp = $consulta ->CodEmp;
            $CodFil = $consulta ->CodFil;
          }
            
            
            
  }

      $consultarproduto = DB::table('e008cadpro')
                        ->where([['CodEmp', '=', $CodEmp],['CodPro','=', $CodPro]])
                        ->get();

        if(count($consultarproduto) >0) {
              foreach ($consultarproduto as $consulta) {
                      $DesPro = $consulta->DesPro;
                      $UniMed = $consulta->UniMed;

                      return response()->json([
                      'Status' => 'Ok',
                      'DesPro' =>$DesPro,
                      'UniMed' =>$UniMed
                      ]);
              }
        }


 }

 public function ConsultarMovimentacaoEstoqueProduto(Request $request){
    $dados = $request->all();
    $CodUsu = Auth::user()->CodUsu;
    $CodPro = $dados['CodPro'];
    $DesPro = $dados['DesPro'];
    $DtaIni = $dados['DtaIni'];
    $DtaFim = $dados['DtaFim'];
    $arraymovimento = array();

    

        $consultaEmpresaFilialLogado = DB::table('e999usulog')
              ->where([['CodUsu', '=', $CodUsu]])
              ->get();
        
        if(count($consultaEmpresaFilialLogado) > 0){
              foreach($consultaEmpresaFilialLogado as $consulta) {
                $CodEmp = $consulta ->CodEmp;
                $CodFil = $consulta ->CodFil;
              }            
        }

    $consultarmovimentacao = DB::table('e802movest')
                         ->where([['CodEmp', '=', $CodEmp],['CodFil','=', $CodFil],['CodPro','=',$CodPro],['DtaMov','>=',$DtaIni],['DtaMov','<=',$DtaFim]])
                         ->get();

          if(count($consultarmovimentacao) >0) {
                    foreach ($consultarmovimentacao as $consulta) {
                      $UniMed = $consulta->UniMed;
                      $DesMov = $consulta->DesMov;
                      $EstAnt = $consulta->EstAnt;
                      $QtdMov = $consulta->QtdMov;
                      $EstAtu = $consulta->EstAtu;
                      $DtaMov = $consulta->DtaMov;
                      $HorMov = $consulta->HorMov;
                      $UsuMov = $consulta->CodUsu;

                     

                      $consultaUsuario = DB::table('e999cadusu')
                                         ->where([['CodUsu','=',$UsuMov]])
                                         ->get();

                       if(count($consultaUsuario) > 0){
                            foreach($consultaUsuario as $Usuario){
                              $NomUsu = $Usuario ->NomUsu;
                            }

                       }

                        $movimento [] = array(
                          'Status'=>'OK',
                          'CodPro'=> $CodPro,
                          'DesPro'=> $DesPro,
                          'UniMed'=> $UniMed,
                          'DesMov'=> $DesMov,
                          'EstAnt'=> $EstAnt,
                          'QtdMov'=> $QtdMov,
                          'EstAtu'=> $EstAtu,
                          'DtaMov'=> $DtaMov,
                          'HorMov'=> $HorMov,
                          'NomUsu'=> $NomUsu
                        );




                    }

                    return json_encode($movimento);
        } else {
                $movimento [] = array('Status'=>'ER','Msg'=> 'Não encontrado Movimentação');
                return json_encode($movimento);
        }

 }
}
