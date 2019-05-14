<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Mensagem;
use DB;


class SelecionaEmpresaFilialController extends Controller
{
  public function index(){

    if(Auth::check()){

        $CodUsu = Auth::user()->CodUsu;
        
        

         $ConsultaLigacao  = DB::table('e999empfil')
                       ->where([['CodUsu', '=', $CodUsu]])
                       ->get();


             
            


            
           

         
       

         return view('erp.zen.cadastros.gerais.selecionaempresafilial');
  
     }else{
        return redirect('/');
     }

  }


  public function ConsultaFilial(Request $request){
    $dados = $request->all();
    $CodUsu = $dados['CodUsu'];
    $CodEmp = $dados['CodEmp'];

    $arrayempresa = array();


    $consultargrupo = DB::table('consultafilialusuario')
                       ->where([['CodUsu', '=', $CodUsu],['CodEmp','=',$CodEmp]])
                       ->get();

        if(count($consultargrupo) >0) {
                  foreach ($consultargrupo as $consulta) {
                    $CodFil = $consulta->CodFil;
                    $CodEmp = $consulta->CodEmp;
                    $NomFan = $consulta->NomFan;
                    
                    

                    $empresa [] = array('Status'=>'OK','CodFil'=>$CodFil,'NomFan'=>$NomFan);
                    
                  }

                
                  return json_encode($empresa);
                  
      } else {
              $empresa [] = array('Status'=>'ER','CodEmp'=>'9999999999','NomFan'=> 'Não encontrado Grupos');
              return json_encode($empresa);
      }

}


public function logarempresa (Request $request){
    $dados = $request->all();
    $CodEmp = $dados['CodEmp'];
    $CodFil = $dados['CodFil'];
    $CodUsu = $dados['CodUsu'];

    

   


    $Logar = DB::table('e999usulog')->insert(
        [
         'CodEmp' => $CodEmp,
         'CodFil' => $CodFil,
         'CodUsu' => $CodUsu,
         'DtaLog' =>  date('Y/m/d'),
         'HorLog' =>  date("H:i:s")
      ]
    );

    

    if ($Logar == 'true'){
      return response()->json([
        'Status' => 'OK',
        'Mensagem' => 'Registro Atualizado com Sucesso!'
      ]);
    }else{
        return redirect('selecionar');
    }



}


  public function ListarEmpresa(){
    $CodUsu = Auth::user()->CodUsu;
    $EmpAtu = 0;

    DB::table('e999usulog')->where('CodUsu', '=', $CodUsu)->delete();


    $ConsultaLigacao  = DB::table('e999empfil')
                       ->where([['CodUsu', '=', $CodUsu]])
                       ->get();

    if(count($ConsultaLigacao)>0){
       foreach ($ConsultaLigacao as $ligacao){
              $CodEmp = $ligacao->CodEmp;

              if ($EmpAtu <> $CodEmp){

                    $DadosEmpresa = DB::table('e001cademp')
                                  ->where([['CodEmp','=',$CodEmp],['SitEmp','=','A']])
                                  ->get();

                    if(count($DadosEmpresa) > 0){
                      foreach ($DadosEmpresa as $Empresa){
                          $NomFan = $Empresa->NomFan;

                          $EmpAtu = $Empresa->CodEmp;
                      }
                      
                      $listaEmpresa [] = array(
                        'Status' => 'OK',
                        'CodEmp' => $CodEmp ,
                        'NomFan' => $NomFan ,
                      );
                    }

              }
        
       }
       return json_encode($listaEmpresa);
    } else {
          $listaEmpresa [] = array('Status'=>'ER','CodEmp'=>'9999999999','NomFan'=> 'Não Encontrado Empresas Ligada ao Usuário. Entre em contato com o Administrador do Sistema.');
          return json_encode($listaEmpresa);

    }


  }

 public function Deslogar(Request $request){
   $CodUsu = Auth::user()->CodUsu;
   DB::table('e999usulog')->where('CodUsu', '=', $CodUsu)->delete();

   return redirect('login')->with(Auth::logout());

  

   
 }



}
