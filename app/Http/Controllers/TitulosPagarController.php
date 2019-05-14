<?php

namespace App\http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



use Auth;
use DB;

use pagseguro;







class TitulosPagarController extends controller{

    public function index(){
                if (Auth::check()){
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



                    return view('erp.zen.financeiro.contaspagar.novotitulopagar')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);
            


            }
            else{
                return redirect('/');
            }
    }

    public function processar(Request $request){
        $dados = $request->all();
        
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

        $CodFor =  $dados['CodFor'];
        $NumTit =  $dados['NumTit'];
        $TipTit =  $dados['TipTit'];
        $SitTit =  $dados['SitTit'];
        $TriDar =  $dados['TriDar'];
        $CodCcu =  $dados['CodCcu'];
        $DtaEnt =  $dados['DtaEnt'];
        $DtaVct =  $dados['DtaVct'];
        $ProPag =  $dados['ProPag'];
        $VlrOri =  $dados['VlrOri'];
        $VlrJur =  $dados['VlrJur'];
        $VlrMul =  $dados['VlrMul'];
        $VlrDes =  $dados['VlrDes'];
        $VlrPag =  $dados['VlrPag'];
        $CodPor =  $dados['CodPor'];
        $CodCar =  $dados['CodCar'];
        $CodBan =  $dados['CodBan'];
        $AgeCta =  $dados['AgeCta'];
        $NumCta =  $dados['NumCta'];
        $CodBar =  $dados['CodBar'];
        $CtrInt =  $dados['CtrInt'];
        $NumRem =  $dados['NumRem'];
        $OrdCom =  $dados['OrdCom'];
        $NumNfe =  $dados['NumNfe'];
        $SerNfe =  $dados['SerNfe'];

        if ($VlrJur <> ''){
            $VlrJur = str_replace(",", ".", $VlrJur);
        }else{
            $VlrJur = 0.00;
        }

        if ($VlrMul <> ''){
            $VlrMul = str_replace(",", ".", $VlrMul);
        }else{
            $VlrMul = 0.00;
        }

        if ($VlrDes <> ''){
            $VlrDes = str_replace(",", ".", $VlrDes);
        }else{
            $VlrDes = 0.00;
        }

        
        $VlrOri = str_replace(",", ".", $VlrOri);
        $VlrPag = $VlrOri + $VlrJur + $VlrMul - $VlrDes;
        $VlrPag = str_replace(",", ".", $VlrPag);


        $consultar = DB::table('e504titpag')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodFor','=',$CodFor],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])
                      ->get();

        if(count($consultar)>0){
            $AtualizarTitulo = DB::table('e504titpag')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodFor','=',$CodFor],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                [
                    'SitTit' => $SitTit,
                    'TriDar' => $TriDar,
                    'CodCcu' => $CodCcu,
                    'DtaVct' => $DtaVct,
                    'ProPag' => $ProPag,
                    'VlrJur' => $VlrJur,
                    'VlrMul' => $VlrMul,
                    'VlrDes' => $VlrDes,
                    'VlrPag' => $VlrPag,
                    'CodPor' => $CodPor,
                    'CodCar' => $CodCar,
                    'CodBan' => $CodBan,
                    'AgeCta' => $AgeCta,
                    'NumCta' => $NumCta,
                    'CodBar' => $CodBar,
                    'UsuAtu' => $CodUsu,
                    'DtaAtu' =>  date('Y/m/d'),
                    'HorAtu' =>  date("H:i:s")
                ]);

                return response()->json([
                    'Status' => 'OK',
                    'Mensagem' => 'Registro Atualizado com Sucesso!'
                ]);



        }else {

                            $CadastroTitulo = DB::table('e504titpag')->insert(
                                [
                                    'CodEmp' => $CodEmp,
                                    'CodFil' => $CodFil,
                                    'CodFor' => $CodFor,
                                    'NumTit' => $NumTit,
                                    'TipTit' => $TipTit,
                                    'SitTit' => $SitTit,
                                    'TriDar' => $TriDar,
                                    'CodCcu' => $CodCcu,
                                    'DtaEnt' => $DtaEnt,
                                    'DtaVct' => $DtaVct,
                                    'ProPag' => $ProPag,
                                    'VlrOri' => $VlrOri,
                                    'VlrJur' => $VlrJur,
                                    'VlrMul' => $VlrMul,
                                    'VlrDes' => $VlrDes,
                                    'VlrPag' => $VlrPag,
                                    'CodPor' => $CodPor,
                                    'CodCar' => $CodCar,
                                    'CodBan' => $CodBan,
                                    'AgeCta' => $AgeCta,
                                    'NumCta' => $NumCta,
                                    'CodBar' => $CodBar,
                                    'Codusu' => $CodUsu,
                                    'DtaCad' =>  date('Y/m/d'),
                                    'HorCad' =>  date("H:i:s")
                            ]
                            );
                    
                            if ($CadastroTitulo == 'true'){
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

    public function consultar(Request $request){
        $dados = $request->all();
        
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

        $CodFor =  $dados['CodFor'];
        $NumTit =  $dados['NumTit'];
        $TipTit =  $dados['TipTit'];

        $consultar = DB::table('e504titpag')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodFor','=',$CodFor],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])
                      ->get();

                     

                    if(count($consultar)>0){
                        foreach ($consultar as $Titulo ){
                          return response()->json([
                            'Status' => 'OK',
                            'SitTit' => $Titulo->SitTit,
                            'CodCcu' => $Titulo->CodCcu,
                            'DtaEnt' => $Titulo->DtaEnt,
                            'DtaVct' => $Titulo->DtaVct,
                            'ProPag' => $Titulo->ProPag,
                            'VlrOri' => $Titulo->VlrOri,
                            'VlrMul' => $Titulo->VlrMul,
                            'VlrJur' => $Titulo->VlrJur,
                            'VlrDes' => $Titulo->VlrDes,
                            'VlrPag' => $Titulo->VlrPag,
                            'CodPor' => $Titulo->CodPor,
                            'CodCar' => $Titulo->CodCar,
                            'CodBan' => $Titulo->CodBan,
                            'AgeCta' => $Titulo->AgeCta,
                            'NumCta' => $Titulo->NumCta,
                            'CodBar' => $Titulo->CodBar,
                            'CtrInt' => $Titulo->CtrInt,
                            'NumRem' => $Titulo->NumRem,
                            'OrdCom' => $Titulo->OrdCom,
                            'NumNfe' => $Titulo->NumNfe,
                            'SerNfe' => $Titulo->SerNfe,
                            'DtaApr' => $Titulo->DtaApr,
                           ]);
                        }
                    } else {
                      return response()->json([
                        'Status' => 'Er',
                      ]);
                    }


    }


    public function indexbaixa(){
                        if (Auth::check()){
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



                            return view('erp.zen.financeiro.contaspagar.baixatitulopagar')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);
                    


                    }
                    else{
                        return redirect('/');
                    }
    }

    public function baixar(Request $request){
        $dados = $request->all();
        $CodFor = $dados['CodFor'];
        $NumTit = $dados['NumTit'];
        $TipTit = $dados['TipTit'];
        $SitBai = $dados['SitBai'];

        
       
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


            

        $Consultar = DB::table('e505baitit')
                         ->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodFor','=',$CodFor],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])
                         ->get();

        if(count($Consultar) == 0){

             if ($SitBai == 'B'){
                            $VlrPgt = $dados['VlrPgt'];
                            $DtaPgt = $dados['DtaPgt'];    
                            $VlrPgt = str_replace(",", ".", $VlrPgt);


                            $Baixa = DB::table('e505baitit')->insert(
                                [
                                    'CodEmp' => $CodEmp,
                                    'CodFil' => $CodFil,
                                    'CodFor' => $CodFor,
                                    'NumTit' => $NumTit,
                                    'TipTit' => $TipTit,
                                    'DtaPgt' => $DtaPgt,
                                    'VlrPgt' => $VlrPgt,
                                    'Codusu' => $CodUsu,
                                    'DtaCad' =>  date('Y/m/d'),
                                    'HorCad' =>  date("H:i:s")
                            ]
                            );
                    
                            if ($Baixa == 'true'){
                                $AtualizarTitulo = DB::table('e504titpag')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodFor','=',$CodFor],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                                    [
                                        'SitTit' => 'LQ',
                                        'DtaApr' => $DtaPgt,
                                        'UsuAtu' => $CodUsu,
                                        'DtaAtu' =>  date('Y/m/d'),
                                        'HorAtu' =>  date("H:i:s")
                                    ]);
                    
                                    return response()->json([
                                        'Status' => 'OK',
                                        'Mensagem' => 'Título baixado com Sucesso!'
                                    ]);
                            }else{
                                return response()->json([
                                'Status' => 'Erro',
                                'Mensagem' => 'Ocorreu um erro ao inserir o Registro . Tente Novamente'
                                    ]);
                            }
                             
            }


        } else {
            if ($SitBai == 'E'){
                DB::table('e505baitit')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodFor','=',$CodFor],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->delete();

        
                $AtualizarTitulo = DB::table('e504titpag')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodFor','=',$CodFor],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                        [
                            'DtaApr' =>  null,
                            'DtaPgt' => null,
                            'VlrApr' => '0.00',
                            'SitTit'  => 'AB',
                            'CodPor' => '9999',
                            'UsuAtu' => $CodUsu,
                            'DtaAtu' =>  date('Y/m/d'),
                            'HorAtu' =>  date("H:i:s")
                        ]);
        
                        return response()->json([
                            'Status' => 'OK',
                            'Mensagem' => 'Baixa Estornada com Sucesso!'
                        ]);

            }
        }


    }


    public function consultartitulobaixar(Request $request){
                $dados = $request->all();
                $CodPor = $dados['CodPor'];
                $NumTit [] = array ($dados['NumTit']);
                $DtaIni = $dados['DtaIni'];
                $DtaFim = $dados['DtaFim'];
                $SitBai = $dados['SitBai'];


                

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


                /* Consultar Titulos Abertos */
                if ((!empty($CodPor)) && (empty ( $NumTit )) && (!empty($DtaIni)) && (!empty($DtaFim)) && ($SitBai == 'B')){
                            $consultar = DB::table('v_e504titpag')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['DtaVct','>=',$DtaIni],['DtaVct','<=',$DtaFim],['CodPor','=',$CodPor]])
                                                                  ->get();

                                                              
                            if(count($consultar)>0){
                                    foreach ($consultar as $Titulo ){
                                                                     
                                                                      $DtaVct = $Titulo->DtaVct;
                                                                      $ProPag = $Titulo->ProPag;
                                                                      
                                                                      $VlrPag = $Titulo->VlrPag;
                                                                      $CodPor = $Titulo->CodPor;
                                                                      
                                                                      $CodFor = $Titulo->CodFor;
                                                                      $NomFor = $Titulo->RazSoc;
                                                                      $NumTit = $Titulo->NumTit;
                                                                      $TipTit = $Titulo->TipTit;
                                                  
                                                                      $DtaVct = date('d/m/Y', strtotime($DtaVct));
                                                  
                                                                      $DtaPgt = date('Y-m-d');
                                                  
                                                                      $VlrPag =  str_replace(".", ",", $VlrPag);
                                                  
                                                                      $consultartipo = DB::table('e019cadtip')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodTip','=',$TipTit]])-get();

                                                                      if(count($consultartipo) > 0){
                                                                          foreach($consultartipo as $tipo){
                                                                              $DesTip =  $tipo->NomTip;
                                                                          }
                                                                      }
                                                  
                                                                      
                                                  
                                                                      $titulos [] = array(
                                                                          'Status' => 'OK',
                                                                          'CodFor' => $CodFor,
                                                                          'NomFor' => $NomFor,
                                                                          'NumTit' => $NumTit,
                                                                          'TipTit' => $TipTit,
                                                                          'DesTip' => $DesTip,
                                                                          'DtaPgt' => $DtaPgt,
                                                                          'DtaVct' => $DtaVct,
                                                                          'ProPag' => $ProPag,
                                                                          'VlrPag' => $VlrPag,
                                                                          'CodPor' => $CodPor
                                                                          
                                                                      );
                                                  
                                                  
                                                                      
                                    }
                                            return json_encode($titulos);
                            } else {
                                    return response()->json([
                                            'Status' => 'Er',
                                           ]);
                            }


                }else if ((empty($CodPor)) && (!empty ( $NumTit )) && (!empty($DtaIni)) && (!empty($DtaFim)) && ($SitBai == 'B')){
                            $consultar = DB::table('v_e504titpag')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['DtaVct','>=',$DtaIni],['DtaVct','<=',$DtaFim],['NumTit','=',$NumTit],['CodPor','<>','9999']])->get();
                            

                        
                                if(count($consultar)>0){
                                foreach ($consultar as $Titulo ){
                                                    
                                                        $DtaVct = $Titulo->DtaVct;
                                                        $ProPag = $Titulo->ProPag;
                                                        
                                                        $VlrPag = $Titulo->VlrPag;
                                                        $CodPor = $Titulo->CodPor;
                                                        
                                                        $CodFor = $Titulo->CodFor;
                                                        $NomFor = $Titulo->RazSoc;
                                                        $NumTit = $Titulo->NumTit;
                                                        $TipTit = $Titulo->TipTit;
                                    
                                                        $DtaVct = date('d/m/Y', strtotime($DtaVct));
                                    
                                                        $DtaPgt = date('Y-m-d');
                                    
                                                        $VlrPag =  str_replace(".", ",", $VlrPag);


                                                        $consultartipo = DB::table('e019cadtip')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodTip','=',$TipTit]])->get();

                                                        if(count($consultartipo) > 0){
                                                            foreach($consultartipo as $tipo){
                                                                $DesTip =  $tipo->NomTip;
                                                            }
                                                        }
                                    
                                                       
                                    
                                                        
                                    
                                                        $titulos [] = array(
                                                            'Status' => 'OK',
                                                            'CodFor' => $CodFor,
                                                            'NomFor' => $NomFor,
                                                            'NumTit' => $NumTit,
                                                            'TipTit' => $TipTit,
                                                            'DesTip' => $DesTip,
                                                            'DtaPgt' => $DtaPgt,
                                                            'DtaVct' => $DtaVct,
                                                            'ProPag' => $ProPag,
                                                            'VlrPag' => $VlrPag,
                                                            'CodPor' => $CodPor
                                                            
                                                        );
                                    
                                    
                                                        
                                }
                                            return json_encode($titulos);
                                } else {
                                            return response()->json([
                                            'Status' => 'Er',
                                            ]);
                                }
                } else if ((empty($CodPor)) && (empty ( $NumTit )) && (!empty($DtaIni)) && (!empty($DtaFim)) && ($SitBai == 'B')){
                    $consultar = DB::table('v_e504titpag')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['DtaVct','>=',$DtaIni],['DtaVct','<=',$DtaFim],['CodPor','<>','9999']])
                    ->get();

                
                        if(count($consultar)>0){
                        foreach ($consultar as $Titulo ){
                                            
                                                $DtaVct = $Titulo->DtaVct;
                                                $ProPag = $Titulo->ProPag;
                                                
                                                $VlrPag = $Titulo->VlrPag;
                                                $CodPor = $Titulo->CodPor;
                                                
                                                $CodFor = $Titulo->CodFor;
                                                $NomFor = $Titulo->RazSoc;
                                                $NumTit = $Titulo->NumTit;
                                                $TipTit = $Titulo->TipTit;
                            
                                                $DtaVct = date('d/m/Y', strtotime($DtaVct));
                            
                                                $DtaPgt = date('Y-m-d');
                            
                                                $VlrPag =  str_replace(".", ",", $VlrPag);
                            
                                                $consultartipo = DB::table('e019cadtip')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodTip','=',$TipTit]])->get();

                                                if(count($consultartipo) > 0){
                                                    foreach($consultartipo as $tipo){
                                                        $DesTip =  $tipo->NomTip;
                                                    }
                                                }
                            
                                                
                            
                                                $titulos [] = array(
                                                    'Status' => 'OK',
                                                    'CodFor' => $CodFor,
                                                    'NomFor' => $NomFor,
                                                    'NumTit' => $NumTit,
                                                    'TipTit' => $TipTit,
                                                    'DesTip' => $DesTip,
                                                    'DtaPgt' => $DtaPgt,
                                                    'DtaVct' => $DtaVct,
                                                    'ProPag' => $ProPag,
                                                    'VlrPag' => $VlrPag,
                                                    'CodPor' => $CodPor
                                                    
                                                );
                            
                            
                                                
                        }
                                    return json_encode($titulos);
                        } else {
                                    return response()->json([
                                    'Status' => 'Er',
                                    ]);
                        }
            
                }


                /* Consultar Titulos já Baixados */


                if ((!empty($CodPor)) && (empty ( $NumTit )) && (!empty($DtaIni)) && (!empty($DtaFim)) && ($SitBai == 'E')){
                    $consultar = DB::table('v_e504titpag_bai')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['DtaPgt','>=',$DtaIni],['DtaPgt','<=',$DtaFim],['CodPor','=',$CodPor]])
                                                          ->get();

                                                         
                    if(count($consultar)>0){
                            foreach ($consultar as $Titulo ){
                                                             
                                                              $DtaVct = $Titulo->DtaVct;
                                                              $ProPag = $Titulo->ProPag;
                                                             
                                                              
                                                              $VlrPag = $Titulo->VlrPag;
                                                              $CodPor = $Titulo->CodPor;
                                                              
                                                              $CodFor = $Titulo->CodFor;
                                                              $NomFor = $Titulo->RazSoc;
                                                              $NumTit = $Titulo->NumTit;
                                                              $TipTit = $Titulo->TipTit;
                                          
                                                              $DtaVct = date('d/m/Y', strtotime($DtaVct));

                                                              $DtaPgt = $Titulo->DtaPgt;
                                                              $DtaPgt = date('d/m/Y', strtotime($DtaPgt));
                                          
                                                             
                                          
                                                              $VlrPag =  str_replace(".", ",", $VlrPag);
                                                              $consultartipo = DB::table('e019cadtip')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodTip','=',$TipTit]])->get();

                                                              if(count($consultartipo) > 0){
                                                                  foreach($consultartipo as $tipo){
                                                                      $DesTip =  $tipo->NomTip;
                                                                  }
                                                              }
                                          
                                                              $titulos [] = array(
                                                                  'Status' => 'OK',
                                                                  'CodFor' => $CodFor,
                                                                  'NomFor' => $NomFor,
                                                                  'NumTit' => $NumTit,
                                                                  'TipTit' => $TipTit,
                                                                  'DesTip' => $DesTip,
                                                                  'DtaPgt' => $DtaPgt,
                                                                  'DtaVct' => $DtaVct,
                                                                  'ProPag' => $ProPag,
                                                                  'VlrPag' => $VlrPag,
                                                                  'CodPor' => $CodPor
                                                                  
                                                              );
                                          
                                          
                                                              
                            }
                                    return json_encode($titulos);
                    } else {
                            return response()->json([
                                    'Status' => 'Er',
                                   ]);
                    }


                }else if ((empty($CodPor)) && (!empty ( $NumTit )) && (!empty($DtaIni)) && (!empty($DtaFim)) && ($SitBai == 'E')){
                                $consultar = DB::table('v_e504titpag_bai')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['DtaPgt','>=',$DtaIni],['DtaPgt','<=',$DtaFim],['NumTit','=',$NumTit]])
                                ->get();

                            
                                    if(count($consultar)>0){
                                    foreach ($consultar as $Titulo ){
                                                        
                                                            $DtaVct = $Titulo->DtaVct;
                                                            $ProPag = $Titulo->ProPag;
                                                            
                                                            $VlrPag = $Titulo->VlrPag;
                                                            $CodPor = $Titulo->CodPor;
                                                            
                                                            $CodFor = $Titulo->CodFor;
                                                            $NomFor = $Titulo->RazSoc;
                                                            $NumTit = $Titulo->NumTit;
                                                            $TipTit = $Titulo->TipTit;
                                        
                                                            $DtaVct = date('d/m/Y', strtotime($DtaVct));
                                        
                                                            $DtaPgt = $Titulo->DtaPgt;
                                                            $DtaPgt = date('d/m/Y', strtotime($DtaPgt));
                                        
                                        
                                                            $VlrPag =  str_replace(".", ",", $VlrPag);
                                        
                                                            $consultartipo = DB::table('e019cadtip')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodTip','=',$TipTit]])->get();

                                                            if(count($consultartipo) > 0){
                                                                foreach($consultartipo as $tipo){
                                                                    $DesTip =  $tipo->NomTip;
                                                                }
                                                            }
                                        
                                                            
                                        
                                                            $titulos [] = array(
                                                                'Status' => 'OK',
                                                                'CodFor' => $CodFor,
                                                                'NomFor' => $NomFor,
                                                                'NumTit' => $NumTit,
                                                                'TipTit' => $TipTit,
                                                                'DesTip' => $DesTip,
                                                                'DtaPgt' => $DtaPgt,
                                                                'DtaVct' => $DtaVct,
                                                                'ProPag' => $ProPag,
                                                                'VlrPag' => $VlrPag,
                                                                'CodPor' => $CodPor
                                                                
                                                            );
                                        
                                        
                                                            
                                    }
                                                return json_encode($titulos);
                                    } else {
                                                return response()->json([
                                                'Status' => 'Er',
                                                ]);
                                    }
                } else if ((empty($CodPor)) && (empty ( $NumTit )) && (!empty($DtaIni)) && (!empty($DtaFim)) && ($SitBai == 'E')){
                    $consultar = DB::table('v_e504titpag_bai')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['DtaPgt','>=',$DtaIni],['DtaPgt','<=',$DtaFim],['CodPor','<>','9999']])
                    ->get();

                
                        if(count($consultar)>0){
                        foreach ($consultar as $Titulo ){
                                            
                                                $DtaVct = $Titulo->DtaVct;
                                                $ProPag = $Titulo->ProPag;
                                                
                                                $VlrPag = $Titulo->VlrPag;
                                                $CodPor = $Titulo->CodPor;
                                                
                                                $CodFor = $Titulo->CodFor;
                                                $NomFor = $Titulo->RazSoc;
                                                $NumTit = $Titulo->NumTit;
                                                $TipTit = $Titulo->TipTit;
                            
                                                $DtaVct = date('d/m/Y', strtotime($DtaVct));
                            
                                                $DtaPgt = $Titulo->DtaPgt;
                                                $DtaPgt = date('d/m/Y', strtotime($DtaPgt));
                            
                            
                                                $VlrPag =  str_replace(".", ",", $VlrPag);
                            
                                                $consultartipo = DB::table('e019cadtip')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodTip','=',$TipTit]])->get();

                                                if(count($consultartipo) > 0){
                                                    foreach($consultartipo as $tipo){
                                                        $DesTip =  $tipo->NomTip;
                                                    }
                                                }
                            
                                                
                            
                                                $titulos [] = array(
                                                    'Status' => 'OK',
                                                    'CodFor' => $CodFor,
                                                    'NomFor' => $NomFor,
                                                    'NumTit' => $NumTit,
                                                    'TipTit' => $TipTit,
                                                    'DesTip' => $DesTip,
                                                    'DtaPgt' => $DtaPgt,
                                                    'DtaVct' => $DtaVct,
                                                    'ProPag' => $ProPag,
                                                    'VlrPag' => $VlrPag,
                                                    'CodPor' => $CodPor
                                                    
                                                );
                            
                            
                                                
                        }
                                    return json_encode($titulos);
                        } else {
                                    return response()->json([
                                    'Status' => 'Er',
                                    ]);
                        }
            
                }






    }
    

    public function indexaprovacao(){
        if (Auth::check()){
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



            return view('erp.zen.financeiro.contaspagar.aprovacaotitulopagar')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);
    


        }
        else{
            return redirect('/');
        }
    }

    public function aprovar(Request $request){
        $dados = $request->all();
        $CodFor = $dados['CodFor'];
        $NumTit = $dados['NumTit'];
        $TipTit = $dados['TipTit'];
        $ProPgt = $dados['ProPgt'];
        $DtaApr = $dados['DtaApr'];
        $VlrApr = $dados['VlrApr'];
        $CodPor = $dados['CodPor'];
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

        $VlrApr = str_replace(",", ".", $VlrApr);

        $Aprovacao = DB::table('e506aprtit')->insert(
            [
                'CodEmp' => $CodEmp,
                'CodFil' => $CodFil,
                'CodFor' => $CodFor,
                'NumTit' => $NumTit,
                'TipTit' => $TipTit,
                'ProPgt' => $ProPgt,
                'DtaApr' => $DtaApr,
                'VlrApr' => $VlrApr,
                'CodPor' => $CodPor,
                'Codusu' => $CodUsu,
                'DtaCad' =>  date('Y/m/d'),
                'HorCad' =>  date("H:i:s")
        ]
        );

        if ($Aprovacao == 'true'){
            $AtualizarTitulo = DB::table('e504titpag')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodFor','=',$CodFor],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                [
                    'ProPag' => $ProPgt,
                    'DtaApr' => $DtaApr,
                    'VlrApr' => $VlrApr,
                    'CodPor' => $CodPor,
                    'UsuAtu' => $CodUsu,
                    'DtaAtu' =>  date('Y/m/d'),
                    'HorAtu' =>  date("H:i:s")
                ]);

                return response()->json([
                    'Status' => 'OK',
                    'Mensagem' => 'Registro Atualizado com Sucesso!'
                ]);
        }else{
            return response()->json([
            'Status' => 'Erro',
            'Mensagem' => 'Ocorreu um erro ao inserir o Registro . Tente Novamente'
                ]);
        }


        

    }


    public function estornaraprovacao(Request $request){
        $dados = $request->all();
        $CodFor = $dados['CodFor'];
        $NumTit = $dados['NumTit'];
        $TipTit = $dados['TipTit'];
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

        DB::table('e506aprtit')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodFor','=',$CodFor],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->delete();

        
        $AtualizarTitulo = DB::table('e504titpag')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodFor','=',$CodFor],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                [
                    'DtaApr' =>  null,
                    'VlrApr' => '0.00',
                    'CodPor' => '9999',
                    'UsuAtu' => $CodUsu,
                    'DtaAtu' =>  date('Y/m/d'),
                    'HorAtu' =>  date("H:i:s")
                ]);

                return response()->json([
                    'Status' => 'OK',
                    'Mensagem' => 'Registro Atualizado com Sucesso!'
                ]);
   }

        

    

    public function consultartitulosaprovacao(Request $request){
        $dados = $request->all();
        $VctIni = $dados['VctIni'];
        $VctFim = $dados['VctFim'];
        $SitApr = $dados['SitApr'];
        $DtaApr = date('Y-m-d');
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

        if($SitApr == 'A'){
                    $consultar = DB::table('v_e504titpag')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['DtaVct','>=',$VctIni],['DtaVct','<=',$VctFim],['CodPor','=','9999']])
                                ->get();

                                

                                if(count($consultar)>0){
                                    foreach ($consultar as $Titulo ){
                                        $TipoTititulo = $Titulo->TipTit;
                                        $DtaVct = date('d/m/Y', strtotime($Titulo->DtaVct));
                                    
                                        if($TipoTititulo =='04'){
                                            $DesTit = 'Boleto';
                                        } else if($TipoTititulo == '05'){
                                            $DesTit = 'DOC';
                                        }else if($TipoTititulo == '06'){
                                            $DesTit = 'TED';
                                        }else{
                                            $DesTit = 'Outros';
                                        }
                                    
                                        $titulos [] = array(
                                        'Status' => 'OK',
                                        'TipTit' => $Titulo->TipTit,
                                        'DesTit' => $DesTit,
                                        'DtaApr' => $DtaApr,
                                        'CodFor' => $Titulo->CodFor,
                                        'NomFor' => $Titulo->RazSoc,
                                        'NumTit' => $Titulo->NumTit,
                                        'DtaVct' => $DtaVct,
                                        'VlrPag' => $Titulo->VlrPag
                                    );
                                    }
                                    return json_encode($titulos);
                                } else {
                                return response()->json([
                                    'Status' => 'Er',
                                ]);
                                }
        } else if ($SitApr == 'D'){
            $consultar = DB::table('e506aprtit')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['DtaApr','>=',$VctIni],['DtaApr','<=',$VctFim]])
            ->get();

            

            if(count($consultar)>0){
                foreach ($consultar as $Titulo ){
                    $TipoTititulo = $Titulo->TipTit;
                    $CodFor = $Titulo->CodFor ;
                    $NumTit = $Titulo->NumTit ;

                    $consultartitulo = DB::table('v_e504titpag')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodFor','=',$CodFor],['NumTit','=',$NumTit],['TipTit','=',$TipoTititulo]])
                                ->get();

                                if(count($consultartitulo)>0){
                                        foreach($consultartitulo as $buscatitulos){
                                            $DtaVct = $buscatitulos->DtaVct ;
                                            $VlrPag = $buscatitulos->VlrPag ;
                                            $RazSoc = $buscatitulos->RazSoc ;
                                        }


                                }

                                
                    
                    $DtaVct = date('d/m/Y', strtotime($DtaVct));
                    $DtaApr = date('d/m/Y', strtotime($Titulo->DtaApr));
                
                    if($TipoTititulo =='04'){
                        $DesTit = 'Boleto';
                    } else if($TipoTititulo == '05'){
                        $DesTit = 'DOC';
                    }else if($TipoTititulo == '06'){
                        $DesTit = 'TED';
                    }else{
                        $DesTit = 'Outros';
                    }
                
                    $titulos [] = array(
                    'Status' => 'OK',
                    'TipTit' => $TipoTititulo,
                    'DesTit' => $DesTit,
                    'DtaApr' => $DtaApr,
                    'CodFor' => $Titulo->CodFor,
                    'NomFor' => $RazSoc,
                    'NumTit' => $Titulo->NumTit,
                    'DtaVct' => $DtaVct,
                    'VlrPag' => $VlrPag,
                    'CodPor' => $Titulo->CodPor,
                );
                }
                return json_encode($titulos);
            } else {
            return response()->json([
                'Status' => 'Er',
            ]);
            }
        }
    }




}