<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Auth;
Use DB;

class AberturaPeriodoController extends Controller
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
    
    
    
    
             return view('erp.zen.cadastros.gerais.filial.aberturaperiodo')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);
    
         }else{
            return redirect('/');
         }
    
      }
    
      public function processar(Request $request){
               $dados = $request->all();
               $PerIni = $dados['DtaIni'];
               $PerFim = $dados['DtaFim'];
               $CodUsu = Auth::user()->CodUsu;
               
               $EmpresaLogada = DB::table('e999usulog')
                -> where([['CodUsu','=' , $CodUsu]])
                ->get();


                if(count($EmpresaLogada)>0){
                        foreach($EmpresaLogada as $consulta){
                                $CodEmp = $consulta->CodEmp;
                                $CodFil = $consulta->CodFil;

                        }
                }


                $AberuraPeriodo = DB::table('e002abeper')
                -> where([['CodEmp','=' , $CodEmp],['CodFil','=',$CodFil]])
                ->get();


                if(count($AberuraPeriodo)== 0){
                    $Periodo = DB::table('e002abeper')->insert(
                        [
                            'CodEmp' => $CodEmp,
                            'CodFil' => $CodFil,
                            'IniEst' => '1900-01-01',
                            'IniCom' => '1900-01-01',
                            'IniVen' => '1900-01-01',
                            'IniFin' => '1900-01-01',
                            'FimEst' => '1900-01-01',
                            'FimCom' => '1900-01-01',
                            'FimVen' => '1900-01-01',
                            'FimFin' => '1900-01-01',
                            'Codusu' => $CodUsu,
                            'DtaCad' =>  date('Y/m/d'),
                            'HorCad' =>  date("H:i:s")
                    ]
                    );
                }






               if(isset($dados['cEstoque'])){
                    $AtualizarPeriodo = DB::table('e002abeper')->where([['CodEmp','=' , $CodEmp],['CodFil','=',$CodFil]])->update(
                    [
                            'IniEst' => $PerIni,
                            'FimEst' => $PerFim,
                            'UsuAtu' => $CodUsu,
                            'DtaAtu' =>  date('Y/m/d'),
                            'HorAtu' =>  date("H:i:s")
                    ]);
    
                   
                 
               }else if(isset($dados['cVendas'])){
                    $AtualizarPeriodo = DB::table('e002abeper')->where([['CodEmp','=' , $CodEmp],['CodFil','=',$CodFil]])->update(
                        [
                                'IniVen' => $PerIni,
                                'FimVen' => $PerFim,
                                'UsuAtu' => $CodUsu,
                                'DtaAtu' =>  date('Y/m/d'),
                                'HorAtu' =>  date("H:i:s")
                        ]);
               }else if(isset($dados['cCompras'])){
                    $AtualizarPeriodo = DB::table('e002abeper')->where([['CodEmp','=' , $CodEmp],['CodFil','=',$CodFil]])->update(
                        [
                                'IniCom' => $PerIni,
                                'FimCom' => $PerFim,
                                'UsuAtu' => $CodUsu,
                                'DtaAtu' =>  date('Y/m/d'),
                                'HorAtu' =>  date("H:i:s")
                        ]);
               }else if(isset($dados['cFinanceiro'])){
                    $AtualizarPeriodo = DB::table('e002abeper')->where([['CodEmp','=' , $CodEmp],['CodFil','=',$CodFil]])->update(
                        [
                                'IniFin' => $PerIni,
                                'FimFin' => $PerFim,
                                'UsuAtu' => $CodUsu,
                                'DtaAtu' =>  date('Y/m/d'),
                                'HorAtu' =>  date("H:i:s")
                        ]);
               } else {
                    $AtualizarPeriodo = DB::table('e002abeper')->where([['CodEmp','=' , $CodEmp],['CodFil','=',$CodFil]])->update(
                        [
                                'IniEst' => $PerIni,
                                'IniCom' => $PerIni,
                                'IniVen' => $PerIni,
                                'IniFin' => $PerIni,
                                'FimEst' => $PerFim,
                                'FimCom' => $PerFim,
                                'FimVen' => $PerFim,
                                'FimFin' => $PerFim,
                                'UsuAtu' => $CodUsu,
                                'DtaAtu' =>  date('Y/m/d'),
                                'HorAtu' =>  date("H:i:s")
                        ]);


               }

            
               

      }

      public function consultar( Request $request){
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

            $consultar =DB::table('e002abeper')->where([['CodEmp','=' , $CodEmp],['CodFil','=',$CodFil]])
                                               ->get();

       

                if(count($consultar)>0){
                    foreach ($consultar as $PeriodoAberto ){
                            $IniEst =   date('d/m/Y', strtotime($PeriodoAberto->IniEst)) ;
                            $IniCom =   date('d/m/Y', strtotime($PeriodoAberto->IniCom)) ;
                            $IniVen =   date('d/m/Y', strtotime($PeriodoAberto->IniVen)) ;
                            $IniFin =   date('d/m/Y', strtotime($PeriodoAberto->IniFin)) ;
                            $FimEst =   date('d/m/Y', strtotime($PeriodoAberto->FimEst)) ;
                            $FimCom =   date('d/m/Y', strtotime($PeriodoAberto->FimCom)) ;
                            $FimVen =   date('d/m/Y', strtotime($PeriodoAberto->FimVen)) ;
                            $FimFin =   date('d/m/Y', strtotime($PeriodoAberto->FimFin)) ;
                        
                        
                        
                        
                        return response()->json([
                        'Status' => 'OK',
                        'IniEst' => $IniEst,
                        'IniCom' => $IniCom,
                        'IniVen' => $IniVen,
                        'IniFin' => $IniFin,
                        'FimEst' => $FimEst,
                        'FimCom' => $FimCom,
                        'FimVen' => $FimVen,
                        'FimFin' => $FimFin,
                        'CodFil' => $CodFil,
                        'NomFan' => $NomFan,
                        ]);
                    }
                } else {
                    return response()->json([
                    'Status' => 'Er',
                    ]);
                }

      }
     
}
