<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mensagem;
Use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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


                       
                    return view('home')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);

                      }
          } else {

          
          }


          return redirect('selecione');

   }  else {
    return redirect('/');
   }   
}



public function conversachat(Request $request){
  $dados = $request->all();


  //dd($dados);
  $MSG  = $dados['Msg'];

  if($MSG = "1"){
          $OpcaoSelecionadaPrimeiro = DB::table('c1000cadcht')
                                  ->where([['SubMen', '=', $MSG]])
                                    ->get();

          if(count($OpcaoSelecionadaPrimeiro) >0) {
             foreach ($OpcaoSelecionadaPrimeiro as $consulta) {
                  $CodMsg = $consulta->CodMsg;
                  $DesMsg = $consulta->MsgCht;

                  $retorna [] = array(
                    'Status'=>'OK',
                    'CodMsg'=>  $CodMsg,
                    'DesMsg'=>  $DesMsg
                  );
             }
             return json_encode($retorna);
          }

  }
  else if ($MSG = "2"){

  }
  else if ($MSG = "3"){

  }
  else if ($MSG = "4"){

  }
  else if ($MSG = "5"){

  }
  else if ($MSG = "6"){

  }


}

}
