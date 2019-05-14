<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

class TituloReceberController extends Controller
{
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



            return view('erp.zen.financeiro.contasreceber.novotituloreceber')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);
    


        }
        else{
            return redirect('/');
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

        $CodCli =  $dados['CodCli'];
        $NumTit =  $dados['NumTit'];
        $TipTit =  $dados['TipTit'];

        $consultar = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])
                      ->get();

                     

                    if(count($consultar)>0){
                        foreach ($consultar as $Titulo ){
                          return response()->json([
                            'Status' => 'OK',
                            'SitTit' => $Titulo->SitTit,
                            'CodCcu' => $Titulo->CodCcu,
                            'DtaEmi' => $Titulo->DtaEmi,
                            'DtaVct' => $Titulo->DtaVct,
                            'ProPag' => $Titulo->ProPag,
                            'VlrOri' => $Titulo->VlrOri,
                            'VlrMul' => $Titulo->VlrMul,
                            'VlrJur' => $Titulo->VlrJur,
                            'VlrRec' => $Titulo->VlrRec,
                            'CodPor' => $Titulo->CodPor,
                            'CodCar' => $Titulo->CodCar,
                            'CodBar' => $Titulo->CodBar,
                            'NosNum' => $Titulo->NosNum,
                            'NumNfe' => $Titulo->NumNfe,
                            'SerNfe' => $Titulo->SerNfe,
                            'CodIns' => $Titulo->CodIns,
                            'InsBan' => $Titulo->InsBan,
                           ]);
                        }
                    } else {
                      return response()->json([
                        'Status' => 'Er',
                      ]);
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

        $CodCli =  $dados['CodCli'];
        $NumTit =  $dados['NumTit'];
        $TipTit =  $dados['TipTit'];
        $SitTit =  $dados['SitTit'];
        $CodCcu =  $dados['CodCcu'];
        $DtaEmi =  $dados['DtaEmi'];
        $DtaVct =  $dados['DtaVct'];
        $ProPag =  $dados['ProPag'];
        $VlrOri =  $dados['VlrOri'];
        $VlrJur =  $dados['VlrJur'];
        $VlrMul =  $dados['VlrMul'];
        $CodPor =  $dados['CodPor'];
        $CodCar =  $dados['CodCar'];
        $CodBar =  $dados['CodBar'];
        $InsBan =  $dados['InsBan'];
        $CodIns =  $dados['CodIns'];
       

        $Titulo = str_replace("/","",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($NumTit))));
        $Controle = rand(1, 9999999999);

        $NosNum = $CodEmp. $CodFil . $CodCli .  $Titulo . $Controle;

        

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

       
        
        $VlrOri = str_replace(".", "", $VlrOri);
        $VlrOri = str_replace(",", ".", $VlrOri);
        $VlrRec = $VlrOri + $VlrJur + $VlrMul ;
        $VlrRec = str_replace(",", ".", $VlrRec);

        

        $consultar = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])
                      ->get();

        if(count($consultar)>0){

            if(($SitTit == 'CA')&&($TipTit =='BOL')){
                    $cancelar = TituloReceberController::cancelartitulo($CodCli,$NumTit,$TipTit);
            } else {
                    $AtualizarTitulo = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                        [
                            'SitTit' => $SitTit,
                            'CodCcu' => $CodCcu,
                            'DtaVct' => $DtaVct,
                            'ProPag' => $ProPag,
                            'VlrJur' => $VlrJur,
                            'VlrMul' => $VlrMul,
                            'VlrRec' => $VlrRec,
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

            }

        }else {

                            $CadastroTitulo = DB::table('e604titrec')->insert(
                                [
                                    'CodEmp' => $CodEmp,
                                    'CodFil' => $CodFil,
                                    'CodCli' => $CodCli,
                                    'NumTit' => $NumTit,
                                    'TipTit' => $TipTit,
                                    'SitTit' => $SitTit,
                                    'CodCcu' => $CodCcu,
                                    'DtaEmi' => $DtaEmi,
                                    'DtaVct' => $DtaVct,
                                    'ProPag' => $ProPag,
                                    'VlrOri' => $VlrOri,
                                    'VlrJur' => $VlrJur,
                                    'VlrMul' => $VlrMul,
                                    'VlrRec' => $VlrRec,
                                    'CodPor' => $CodPor,
                                    'CodCar' => $CodCar,
                                    'CodBar' => $CodBar,
                                    'InsBan' => $InsBan,
                                    'NosNum' => $NosNum,
                                    'CtrInt' => $Controle,
                                    'CodUsu' => $CodUsu,
                                    'DtaCad' =>  date('Y/m/d'),
                                    'HorCad' =>  date("H:i:s")
                            ]
                            );
                    
                            if ($CadastroTitulo == 'true'){

                                $gerarBoleto = TituloReceberController::boletogerencianet($CodCli,$NumTit,$TipTit);
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


    public function boletogerencianet($CodCli,$NumTit,$TipTit){
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
        
        
        $ConsultaIntegracao = DB::table('e999dadint')
                                  ->where([['CodEmp','=',$CodEmp],['COdFil','=',$CodFil],['CodInt','=','GERENCIANET']])
                                  ->get();

    
        if(count($ConsultaIntegracao)>0){
            foreach($ConsultaIntegracao as $Integracao){
                $gerencianet_clientid = $Integracao->ChvId;
                $gerencianet_clientsecret = $Integracao->ChvSec;
                $TipAmb = $Integracao->TipAmb;

                if($TipAmb == 0){
                    $gerencianet_sandbox = true;
                }else if ($TipAmb == 1){
                    $gerencianet_sandbox = false;
                }
            }
        }


        $options = array(
            'client_id' => $gerencianet_clientid,
            'client_secret' => $gerencianet_clientsecret,
            'sandbox' => $gerencianet_sandbox
        );


        $consultaCliente = DB::table('e003cadcli')
                            ->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli]])
                            ->get();

        if(count($consultaCliente) >0){
            foreach($consultaCliente as $cliente){
                $CgcCpf = $cliente->CgcCpf;
                $RazSoc = $cliente->RazSoc;
                $TelCli = $cliente->TelCli;
                $TipCli = $cliente->TipCli;
                $IntNet = $cliente->IntNet;
                $EndCli = $cliente->EndCli;
                $NumCli = $cliente->NumCli;
                $BaiCli = $cliente->BaiCli;
                $CepCli = $cliente->CepCli;
                $CidCli = $cliente->CidCli;
                $CplCli = $cliente->CplCli;
                $UfsCli = $cliente->UfsCli;
            }
        }

        $TelCli= str_replace("-", "", $TelCli);
        
        
        $CgcCpf = preg_replace("/[^0-9]/", "", $CgcCpf);
        $CepCli = preg_replace("/[^0-9]/", "", $CepCli);

        
        $address  = [
            "street" => $EndCli,  //Rua
            "number" => $NumCli,  // Numero 
            "neighborhood" => $BaiCli ,   //Bairro
            "zipcode" => $CepCli , //CEP Sem Formatacao
            "city" => $CidCli , // Cidade 
            "complement" => $CplCli , // Complemento 
            "state" => $UfsCli   // estado 2 caraceteres
        ];

        if($TipCli == 'F'){
            $customer = [
                'name' => $RazSoc, // nome do cliente
                'cpf' => $CgcCpf , // cpf válido do cliente
                'email' => $IntNet , //E-mail do Cliente
                'phone_number' => $TelCli,// telefone do cliente
                'address' => $address 
              ];
    
        } else if($TipCli == 'J'){
            $juridical_data = [
                'corporate_name' => $RazSoc, // nome da razão social
                'cnpj' => $CgcCpf,  // CNPJ da empresa, com 14 caracteres
              ];
               
              $customer = [
                'email' => $IntNet , //E-mail do Cliente
                'phone_number' => $TelCli,// telefone do cliente
                'juridical_person' => $juridical_data,
                'address' => $address 
              ];
        }
        

        

        

        $consultar = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])
                      ->get();

     
       if(count($consultar)>0){
            foreach ($consultar as $Titulo ){
                    $VlrRec = $Titulo->VlrRec;
                    $NosNum = $Titulo->NosNum; 
                    $DtaVct = $Titulo->DtaVct;

            }
       }

       $VlrRec = preg_replace("/[^0-9]/", "", $VlrRec);
      
       $item = [
        'name' => 'Ref. a NF 20000',
        'amount' => (int) '1',
        'value' => (int) $VlrRec
       ];

       $items = array(
           $item
       );



       $metadata = array(
                'custom_id'=>$NosNum,
                'notification_url' => 'http://'. $_SERVER['SERVER_NAME'].'/novo/titulo/receber/notificacao'
       );


       
       $body = array(
            'metadata' => $metadata,
            'items' => $items
       );


       try{
                $api = new \Gerencianet\Gerencianet($options);
                $transacao = $api->createCharge(array(),$body);

                if($transacao['code'] =='200'){
                            $transacao_id = $transacao['data']['charge_id'];

                            $params = array(
                                'id' => $transacao_id
                            );

                            $bankingBillet = [
                                'expire_at' => $DtaVct,
                                'customer' => $customer
                            ];

                            $payment = [
                                'banking_billet' => $bankingBillet
                            ];

                            $body = ['payment' => $payment];


                            try{
                                $pay_charge = $api->payCharge($params, $body);

                                if($pay_charge['code'] =='200'){
                                    $link = $pay_charge['data']['link'];
                                    $codigobarras = $pay_charge['data']['barcode'];
                                    $pdf = $pay_charge['data']['pdf']['charge'];

                                    $AtualizarTitulo = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                                        [
                                            'CodBar' =>  $codigobarras,
                                            'LnkBol' =>  $link,
                                            'LnkPdf' =>  $pdf,
                                            'CharId' =>  $transacao_id,
                                            'UsuAtu' =>  $CodUsu,
                                            'DtaAtu' =>  date('Y/m/d'),
                                            'HorAtu' =>  date("H:i:s")
                                        ]);

                                    $retorno = TituloReceberController::consultartransacaoGerenciaNet($transacao_id);
                                   // copy($pdf,'/boletos/'.urldecode(basename($pdf)));

                                }
                            } catch (Exception $i){
                                    echo "ERRO: ";
                                    print_r($i->getMessage());
                                    exit;
                            }
                }


       } catch(Exception $e){
                echo "ERRO: ";
                print_r($e->getMessage());
                exit;
       }

    }


   


    public function cancelartitulo($CodCli,$NumTit,$TipTit){
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
                    
                    
                    $ConsultaIntegracao = DB::table('e999dadint')
                                            ->where([['CodEmp','=',$CodEmp],['COdFil','=',$CodFil],['CodInt','=','GERENCIANET']])
                                            ->get();

                
                    if(count($ConsultaIntegracao)>0){
                        foreach($ConsultaIntegracao as $Integracao){
                            $gerencianet_clientid = $Integracao->ChvId;
                            $gerencianet_clientsecret = $Integracao->ChvSec;
                            $TipAmb = $Integracao->TipAmb;

                            if($TipAmb == 0){
                                $gerencianet_sandbox = true;
                            }else if ($TipAmb == 1){
                                $gerencianet_sandbox = false;
                            }
                        }
                    }


                    $options = array(
                        'client_id' => $gerencianet_clientid,
                        'client_secret' => $gerencianet_clientsecret,
                        'sandbox' => $gerencianet_sandbox
                    );

                    $consultar = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])
                      ->get();

                    if(count($consultar)>0){
                            foreach($consultar as $titulo){
                                $NosNum = $titulo->NosNum;
                                $CharId = $titulo->CharId;
                            }
                    }


                    $params = [
                        'id' => $CharId
                      ];


                    try{

                             $api = new \Gerencianet\Gerencianet($options);

                            $cancelamento = $api->cancelCharge($params,array());

                            $status = $cancelamento['code'];

                            if($status == '200'){
                                $AtualizarTitulo = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                                    [
                                        'SitTit' => 'CA',
                                        'UsuAtu' => $CodUsu,
                                        'DtaAtu' =>  date('Y/m/d'),
                                        'HorAtu' =>  date("H:i:s")
                                    ]);

                                    $retorno = TituloReceberController::consultartransacaoGerenciaNet($CharId);
                            }

                            
 
                    }catch(Exception $e){
                        echo "ERRO: ";
                        print_r($e->getMessage());
                        exit;
                    }


        

    }


    public function enviaremail(Request $request){
        $CodUsu = Auth::user()->CodUsu;
        $dados = $request->all();
        $CodCli =  $dados['CodCli'];
        $NumTit =  $dados['NumTit'];
        $TipTit =  $dados['TipTit'];
        $IntNet =  $dados['IntNet'];


        $EmpresaLogada = DB::table('e999usulog')
                            -> where([['CodUsu','=' , $CodUsu]])
                            ->get();

    
        if(count($EmpresaLogada)>0){
            foreach($EmpresaLogada as $consulta){
                    $CodEmp = $consulta->CodEmp;
                    $CodFil = $consulta->CodFil;

            }
        }
        
        
        $ConsultaIntegracao = DB::table('e999dadint')
                                ->where([['CodEmp','=',$CodEmp],['COdFil','=',$CodFil],['CodInt','=','GERENCIANET']])
                                ->get();

    
        if(count($ConsultaIntegracao)>0){
            foreach($ConsultaIntegracao as $Integracao){
                $gerencianet_clientid = $Integracao->ChvId;
                $gerencianet_clientsecret = $Integracao->ChvSec;
                $TipAmb = $Integracao->TipAmb;

                if($TipAmb == 0){
                    $gerencianet_sandbox = true;
                }else if ($TipAmb == 1){
                    $gerencianet_sandbox = false;
                }
            }
        }


        $options = array(
            'client_id' => $gerencianet_clientid,
            'client_secret' => $gerencianet_clientsecret,
            'sandbox' => $gerencianet_sandbox
        );

        $consultar = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])
        ->get();

        if(count($consultar)>0){
                foreach($consultar as $titulo){
                    $SitTit = $titulo->SitTit;
                    $CharId = $titulo->CharId;
                }
        }

        if(($SitTit <> 'CA') || ($SitTit <> 'LQ') && (!empty($CharId))){
             $params = [
                'id' => $CharId
             ];
    
    
            $body = [
                'email' => $IntNet
            ];
    
    
            try{
    
                    $api = new \Gerencianet\Gerencianet($options);
    
                    $envioemail = $api->resendBillet($params,$body);
    
                    $status = $envioemail['code'];
    
                    if($status == '200'){

                        $msg = 'Envio de Segunda via Boleto ' . $NumTit. ' Tipo '. $TipTit . ' do Cliente ' .$CodCli .'  da Empresa ' .$CodEmp .' e Filial '.$CodFil; 
                       
                       //Registrar Log de Envio de E-mail
                        $Log = DB::table('e999logema')->insert(
                            [
                                'CodEmp' => $CodEmp,
                                'CodApl' => 'R',
                                'MsgDiv' => $msg,
                                'IntNet' => $IntNet,
                                'CodUsu' => $CodUsu,
                                'DtaCad' =>  date('Y/m/d'),
                                'HorCad' =>  date("H:i:s")
                        ]
                        );

                        if($Log == 'true'){
                            $retorno = TituloReceberController::consultartransacaoGerenciaNet($CharId);
                            return response()->json([
                                'Status' => 'OK',
                                'Mensagem' => 'Boleto Enviado com Sucesso!'
                            ]);
                        } else {
                            return response()->json([
                                'Status' => 'Er',
                                'Mensagem' => 'Ocorreu um erro ao enviar o Boleto . Tente Novamente'
                            ]);
                        }
                    }
    
                    
    
            }catch(Exception $e){
                echo "ERRO: ";
                print_r($e->getMessage());
                exit;
            }

        } else {
            return response()->json([
                'Status' => 'Er',
                'Mensagem' => 'Título já Baixado ou Cancelado. Não é permitido o envio de Segunda via'
            ]); 
        }


        



        

    }

    public function baixamanual(Request $request){
                $CodUsu = Auth::user()->CodUsu;
                $dados = $request->all();
                $CodCli =  $dados['CodCli'];
                $NumTit =  $dados['NumTit'];
                $TipTit =  $dados['TipTit'];
                $IntNet =  $dados['IntNet'];


                $EmpresaLogada = DB::table('e999usulog')
                                    -> where([['CodUsu','=' , $CodUsu]])
                                    ->get();

            
                if(count($EmpresaLogada)>0){
                    foreach($EmpresaLogada as $consulta){
                            $CodEmp = $consulta->CodEmp;
                            $CodFil = $consulta->CodFil;

                    }
                }
                
                
                $ConsultaIntegracao = DB::table('e999dadint')
                                        ->where([['CodEmp','=',$CodEmp],['COdFil','=',$CodFil],['CodInt','=','GERENCIANET']])
                                        ->get();

            
                if(count($ConsultaIntegracao)>0){
                    foreach($ConsultaIntegracao as $Integracao){
                        $gerencianet_clientid = $Integracao->ChvId;
                        $gerencianet_clientsecret = $Integracao->ChvSec;
                        $TipAmb = $Integracao->TipAmb;

                        if($TipAmb == 0){
                            $gerencianet_sandbox = true;
                        }else if ($TipAmb == 1){
                            $gerencianet_sandbox = false;
                        }
                    }
                }


                $options = array(
                    'client_id' => $gerencianet_clientid,
                    'client_secret' => $gerencianet_clientsecret,
                    'sandbox' => $gerencianet_sandbox
                );

                $consultar = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])
                ->get();

                if(count($consultar)>0){
                        foreach($consultar as $titulo){
                            $SitTit = $titulo->SitTit;
                            $CharId = $titulo->CharId;
                        }
                }

                if(($SitTit <> 'CA') || ($SitTit <> 'LQ') && (!empty($CharId))){

                            $params = [
                                'id' => $CharId
                            ];


                            try{

                                    $api = new \Gerencianet\Gerencianet($options);

                                    $baixa = $api->settleCharge($params,array());

                                    $status = $baixa['code'];

                                    if($status == '200'){
                                        $AtualizarTitulo = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                                            [
                                                'SitTit' => 'LQ',
                                                'UsuAtu' =>  $CodUsu,
                                                'DtaAtu' =>  date('Y/m/d'),
                                                'HorAtu' =>  date("H:i:s")
                                            ]);

                                            $retorno = TituloReceberController::consultartransacaoGerenciaNet($CharId);

                                            return response()->json([
                                                'Status' => 'OK',
                                                'Mensagem' => 'Boleto baixado com Sucesso.'
                                            ]);
                                    }

                                    

                            }catch(Exception $e){
                                echo "ERRO: ";
                                print_r($e->getMessage());
                                exit;
                            }

                } else {
                    return response()->json([
                        'Status' => 'Er',
                        'Mensagem' => 'Título já Baixado ou Cancelado.'
                    ]); 
                }

    }


    public function consultartransacaoGerenciaNet($charge_id){
        $CodUsu = Auth::user()->CodUsu;
        $CharId = $charge_id;

        $EmpresaLogada = DB::table('e999usulog')
                                    -> where([['CodUsu','=' , $CodUsu]])
                                    ->get();

            
                if(count($EmpresaLogada)>0){
                    foreach($EmpresaLogada as $consulta){
                            $CodEmp = $consulta->CodEmp;
                            $CodFil = $consulta->CodFil;

                    }
                }
                
                
                $ConsultaIntegracao = DB::table('e999dadint')
                                        ->where([['CodEmp','=',$CodEmp],['COdFil','=',$CodFil],['CodInt','=','GERENCIANET']])
                                        ->get();

            
                if(count($ConsultaIntegracao)>0){
                    foreach($ConsultaIntegracao as $Integracao){
                        $gerencianet_clientid = $Integracao->ChvId;
                        $gerencianet_clientsecret = $Integracao->ChvSec;
                        $TipAmb = $Integracao->TipAmb;

                        if($TipAmb == 0){
                            $gerencianet_sandbox = true;
                        }else if ($TipAmb == 1){
                            $gerencianet_sandbox = false;
                        }
                    }
                }

                $options = array(
                    'client_id' => $gerencianet_clientid,
                    'client_secret' => $gerencianet_clientsecret,
                    'sandbox' => $gerencianet_sandbox
                );

                $params = [
                    'id' => $CharId
                ];

                try{
                    $api = new \Gerencianet\Gerencianet($options);

                    $consultartransacao = $api->detailCharge($params,array());

                    $status = $consultartransacao['data']['status'];

                    // Status 
                    /*
                        new = novo
                        paid = pago
                        unpaid = não pago
                        refunded = devolvido
                        contested = contestado
                        canceled = cancelado
                        settled = Baixa Manual
                        waiting = Aguardando Pagamento
                        expired = Vencido



                    */

                    $consultar = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CharId','=',$CharId]])
                    ->get();
    
                    if(count($consultar)>0){
                            foreach($consultar as $titulo){
                                $CodCli = $titulo->CodCli;
                                $NumTit = $titulo->NumTit;
                                $TipTit = $titulo->TipTit;
                            }
                    }
                    if($status == 'new'){
                        $AtualizarTitulo = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                            [
                                'SitTit' => 'PE',
                                'UsuAtu' =>  $CodUsu,
                                'DtaAtu' =>  date('Y/m/d'),
                                'HorAtu' =>  date("H:i:s")
                            ]);

                            //Registrar Log 
                            $Log = DB::table('e604logrec')->insert(
                                [
                                    'CodEmp' => $CodEmp,
                                    'CodFil' => $CodFil,
                                    'CodCli' => $CodCli,
                                    'NumTit' => $NumTit,
                                    'TipTit' => $TipTit,
                                    'SitMov' => 'Boleto Criado',
                                    'CodUsu' => '11',
                                    'DtaCad' =>  date('Y/m/d'),
                                    'HorCad' =>  date("H:i:s")
                            ]
                            );

                    } else if($status == 'paid'){
                        $AtualizarTitulo = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                            [
                                'DtaPgt' => date('Y/m/d'),
                                'UsuPgt' => '11',
                                'SitTit' => 'LQ',
                                'UsuAtu' =>  $CodUsu,
                                'DtaAtu' =>  date('Y/m/d'),
                                'HorAtu' =>  date("H:i:s")
                            ]);

                             //Registrar Log 
                             $Log = DB::table('e604logrec')->insert(
                                [
                                    'CodEmp' => $CodEmp,
                                    'CodFil' => $CodFil,
                                    'CodCli' => $CodCli,
                                    'NumTit' => $NumTit,
                                    'TipTit' => $TipTit,
                                    'SitMov' => 'Boleto Pago',
                                    'CodUsu' => '11',
                                    'DtaCad' =>  date('Y/m/d'),
                                    'HorCad' =>  date("H:i:s")
                            ]
                            );
                    } else if($status == 'unpaid'){
                        $AtualizarTitulo = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                            [
                                'SitTit' => 'AG',
                                'UsuAtu' =>  $CodUsu,
                                'DtaAtu' =>  date('Y/m/d'),
                                'HorAtu' =>  date("H:i:s")
                            ]);

                             //Registrar Log 
                             $Log = DB::table('e604logrec')->insert(
                                [
                                    'CodEmp' => $CodEmp,
                                    'CodFil' => $CodFil,
                                    'CodCli' => $CodCli,
                                    'NumTit' => $NumTit,
                                    'TipTit' => $TipTit,
                                    'SitMov' => 'Não foi possível confirmar o Pagamento ',
                                    'CodUsu' => '11',
                                    'DtaCad' =>  date('Y/m/d'),
                                    'HorCad' =>  date("H:i:s")
                            ]
                            );
                
                    } else if($status == 'refunded'){
                        $AtualizarTitulo = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                            [
                                'SitTit' => 'DE',
                                'UsuAtu' =>  $CodUsu,
                                'DtaAtu' =>  date('Y/m/d'),
                                'HorAtu' =>  date("H:i:s")
                            ]);

                             //Registrar Log 
                             $Log = DB::table('e604logrec')->insert(
                                [
                                    'CodEmp' => $CodEmp,
                                    'CodFil' => $CodFil,
                                    'CodCli' => $CodCli,
                                    'NumTit' => $NumTit,
                                    'TipTit' => $TipTit,
                                    'SitMov' => 'Pagamento devolvido',
                                    'CodUsu' => '11',
                                    'DtaCad' =>  date('Y/m/d'),
                                    'HorCad' =>  date("H:i:s")
                            ]
                            );
                    } else if($status == 'contested'){
                        $AtualizarTitulo = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                            [
                                'SitTit' => 'CO',
                                'UsuAtu' =>  $CodUsu,
                                'DtaAtu' =>  date('Y/m/d'),
                                'HorAtu' =>  date("H:i:s")
                            ]);

                            //Registrar Log 
                            $Log = DB::table('e604logrec')->insert(
                                [
                                    'CodEmp' => $CodEmp,
                                    'CodFil' => $CodFil,
                                    'CodCli' => $CodCli,
                                    'NumTit' => $NumTit,
                                    'TipTit' => $TipTit,
                                    'SitMov' => 'Pagamento em Contestação',
                                    'CodUsu' => '11',
                                    'DtaCad' =>  date('Y/m/d'),
                                    'HorCad' =>  date("H:i:s")
                            ]
                            );
                    } else if($status == 'canceled'){
                        $AtualizarTitulo = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                            [
                                'SitTit' => 'CA',
                                'UsuAtu' =>  $CodUsu,
                                'DtaAtu' =>  date('Y/m/d'),
                                'HorAtu' =>  date("H:i:s")
                            ]);

                            //Registrar Log 
                            $Log = DB::table('e604logrec')->insert(
                                [
                                    'CodEmp' => $CodEmp,
                                    'CodFil' => $CodFil,
                                    'CodCli' => $CodCli,
                                    'NumTit' => $NumTit,
                                    'TipTit' => $TipTit,
                                    'SitMov' => 'Boleto Cancelado',
                                    'CodUsu' => $CodUsu,
                                    'DtaCad' =>  date('Y/m/d'),
                                    'HorCad' =>  date("H:i:s")
                            ]
                            );

                    } else if($status == 'settled'){
                        $AtualizarTitulo = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                            [
                                'SitTit' => 'LM',
                                'DtaPgt' =>  date('Y/m/d'),
                                'UsuPgt' =>  $CodUsu,
                                'UsuAtu' =>  $CodUsu,
                                'DtaAtu' =>  date('Y/m/d'),
                                'HorAtu' =>  date("H:i:s")
                            ]);

                            //Registrar Log 
                            $Log = DB::table('e604logrec')->insert(
                                [
                                    'CodEmp' => $CodEmp,
                                    'CodFil' => $CodFil,
                                    'CodCli' => $CodCli,
                                    'NumTit' => $NumTit,
                                    'TipTit' => $TipTit,
                                    'SitMov' => 'Pagamento Manual',
                                    'CodUsu' => $CodUsu,
                                    'DtaCad' =>  date('Y/m/d'),
                                    'HorCad' =>  date("H:i:s")
                            ]
                            );
                    } else if($status == 'waiting'){
                        $AtualizarTitulo = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                            [
                                'SitTit' => 'AG',
                                'UsuAtu' =>  $CodUsu,
                                'DtaAtu' =>  date('Y/m/d'),
                                'HorAtu' =>  date("H:i:s")
                            ]);

                        //Registrar Log 
                        $Log = DB::table('e604logrec')->insert(
                            [
                                'CodEmp' => $CodEmp,
                                'CodFil' => $CodFil,
                                'CodCli' => $CodCli,
                                'NumTit' => $NumTit,
                                'TipTit' => $TipTit,
                                'SitMov' => 'Aguardando Pagamento',
                                'CodUsu' => '11',
                                'DtaCad' =>  date('Y/m/d'),
                                'HorCad' =>  date("H:i:s")
                        ]
                        );
                    } else if($status == 'expired'){
                        $AtualizarTitulo = DB::table('e604titrec')->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['CodCli','=',$CodCli],['NumTit','=',$NumTit],['TipTit','=',$TipTit]])->update(
                            [
                                'SitTit' => 'VC',
                                'UsuAtu' =>  $CodUsu,
                                'DtaAtu' =>  date('Y/m/d'),
                                'HorAtu' =>  date("H:i:s")
                            ]);

                            //Registrar Log 
                            $Log = DB::table('e604logrec')->insert(
                                [
                                    'CodEmp' => $CodEmp,
                                    'CodFil' => $CodFil,
                                    'CodCli' => $CodCli,
                                    'NumTit' => $NumTit,
                                    'TipTit' => $TipTit,
                                    'SitMov' => 'Boleto Vencido',
                                    'CodUsu' => '11',
                                    'DtaCad' =>  date('Y/m/d'),
                                    'HorCad' =>  date("H:i:s")
                            ]
                            );
                    }




                } catch(Exception $e) {
                    echo "Erro :";
                    print_r($e->getMessage());
                    exit;


                }


    }

    public function indexconsulta(){
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



            return view('erp.zen.financeiro.contasreceber.consultatituloreceber')->with(['CodEmp' => $CodEmp ,'NomEmp' => $NomEmp,'CodFil' => $CodFil , 'NomFil' =>$NomFil]);
    


        }
        else{
            return redirect('/');
        }
    }


    public function consultartitulo(Request $request){
        $CodUsu = Auth::user()->CodUsu;
        $dados = $request->all();
        $CodPor = $dados['CodPor'];
        $NumTit = array ($dados['NumTit']);
        $DtaIni = $dados['DtaIni'];
        $DtaFim = $dados['DtaFim'];


        $EmpresaLogada = DB::table('e999usulog')
                -> where([['CodUsu','=' , $CodUsu]])
                ->get();


                if(count($EmpresaLogada)>0){
                        foreach($EmpresaLogada as $consulta){
                                $CodEmp = $consulta->CodEmp;
                                $CodFil = $consulta->CodFil;

                        }
                }

                
                
                
        $consultar = DB::table('v_e604titrec')
                            ->where([['CodEmp','=',$CodEmp],['CodFil','=',$CodFil],['DtaVct','>=',$DtaIni],['DtaVct','<=',$DtaFim],['CodPor','=',$CodPor]])
                            ->get();

        

        
            if(count($consultar)>0){
                    foreach ($consultar as $Titulo ){
                                
                                    $DtaVct = $Titulo->DtaVct;
                                    
                                    
                                    $VlrRec = $Titulo->VlrRec;
                                    $CodPor = $Titulo->CodPor;
                                    
                                    $CodCli = $Titulo->CodCli;
                                    $NomCli = $Titulo->RazSoc;
                                    $NumTit = $Titulo->NumTit;
                                    $TipTit = $Titulo->TipTit;
                                    $Situacao = $Titulo->SitTit;

                                    $DtaVct = date('d/m/Y', strtotime($DtaVct));


                                    $VlrRec =  str_replace(".", ",", $VlrRec);

                                    $consultartipo = DB::table('e019cadtip')->where([['CodEmp','=',$CodEmp],['CodTip','=',$TipTit]])->get();

                                    if(count($consultartipo) > 0){
                                        foreach($consultartipo as $tipo){
                                            $DesTip =  $tipo->NomTip;
                                        }
                                    }

                                    

                                    $titulos [] = array(
                                        'Status' => 'OK',
                                        'CodCli' => $CodCli,
                                        'NomCli' => $NomCli,
                                        'NumTit' => $NumTit,
                                        'TipTit' => $TipTit,
                                        'SitTit' => $Situacao,
                                        'DesTip' => $DesTip,
                                        'DtaVct' => $DtaVct,
                                        'VlrRec' => $VlrRec,
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
