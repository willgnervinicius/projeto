<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Mensagem;
use DB;


class CadastroRelacaoItemFornecedorController extends Controller
{
  public function index(){

    if(Auth::check()){
        $CodUsu = Auth::user()->CodUsu;
        $dataAtual = date("Y/m/d");
        $CodEmp = '1';

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




      


        $listaProdutos = DB::table('e008cadpro')
                                       ->where([['CodEmp',$CodEmp],['SitPro','=','A']])
                                       ->get();

        return view('erp.zen.cadastros.produto.relacaoitemfornecedor',compact('listaProdutos'))->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);

         

       }else{
          return redirect('/');
       }


  }



  public function processar(Request $req)
  {
    dd($req);
  }
}
