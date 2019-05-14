<?php
namespace App\http\Controllers;


use DB;
use Auth;
use Illuminate\http\Request;


class CentrodeCustoController extends Controller {

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

                             $listaCentroCusto = DB::table('e999cadccu')
                                                ->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['SitCcu', '=', 'A']])
                                                ->get();
    
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
    
    
      
    
            return view('erp.zen.cadastros.gerais.fiscais.novocentrocusto',compact('listaCentroCusto'))->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);
    
    
    
            
    
           }else{
              return redirect('/');
           }
    
    
    }


    public function processar(Request $Request){
       $dados = $Request->all();
       $CodCcu = $dados['CodCcu'];
       $DesCcu = $dados['DesCcu'];
       $PaiCcu = $dados['PaiCcu'];
       $SitCcu = $dados['SitCcu'];
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

        $ConsultaCentroCusto = DB::table('e999cadccu')
                     ->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCcu', '=', $CodCcu]])
                     ->get();
        
        if(count($ConsultaCentroCusto)>0){
           $AtualizaGrupo = DB::table('e999cadccu')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCcu', '=', $CodCcu]])->update(
                      [
                      'Desccu' => $DesCcu,
                      'SitCcu' => $SitCcu,
                      'UsuAtu' => $CodUsu,
                      'DtaAtu' =>  date('Y/m/d'),
                      'HorAtu' =>  date("H:i:s")
                    ]
            );



                  return response()->json([
                  'Status' => 'OK',
                  'Mensagem' => 'Registro Atualizado com Sucesso!'
                ]);

        } else {
                $CadastroCcu = DB::table('e999cadccu')->insert(
                  [
                    'CodEmp' => $CodEmp,
                    'CodFil' => $CodFil,
                    'CodCcu' => $CodCcu,
                    'Desccu' => $DesCcu,
                    'PaiCcu' => $PaiCcu,
                    'SitCcu' => $SitCcu,
                    'CodUsu' =>$CodUsu,
                    'DtaCad' =>  date('Y/m/d'),
                    'HorCad' =>  date("H:i:s")
                ]
              );
        
              if ($CadastroCcu == 'true'){
                return response()->json([
                      'Status' => 'OK',
                      'Mensagem' => 'Registro Incluido com Sucesso!'
                  ]);
              }else{
                    return response()->json([
                    'Status' => 'Erro',
                    'Mensagem' => 'Ocorreu um erro Tente novamente!'
                      ]);
              }

        }


    }


    public function consultar(Request $Request ){
      $dados = $Request->all();
      $CodCcu = $dados['CodCcu'];
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

      $ConsultaCentroCusto = DB::table('e999cadccu')
                    ->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCcu', '=', $CodCcu]])
                    ->get();

      if(count($ConsultaCentroCusto)>0){
          foreach ($ConsultaCentroCusto as $Consulta ){
            return response()->json([
              'Status' => 'OK',
              'DesCcu' => $Consulta->DesCcu,
              'PaiCcu' => $Consulta->PaiCcu,
              'SitCcu' => $Consulta->SitCcu
             ]);
          }
      } else {
        return response()->json([
          'Status' => 'Er',
        ]);
      }
       

    }


}