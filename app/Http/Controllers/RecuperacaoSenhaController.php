<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Hash;

class RecuperacaoSenhaController extends Controller
{
    public function index(){
             return view('erp.zen.gerais.recuperasenha');
      }


      private function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';
        $caracteres .= $lmin;
        if ($maiusculas) $caracteres .= $lmai;
        if ($numeros) $caracteres .= $num;
        if ($simbolos) $caracteres .= $simb;
        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
                $rand = mt_rand(1, $len);
                $retorno .= $caracteres[$rand-1];
        }
        return $retorno;
    }


    public function resgatarsenha(Request $request){

        $dados = $request->all();
        $CgcCpf = $dados['CgcCpf'];

        if(empty($CgcCpf)){
            return response()->json([
                'Status' => 'Er',
                'Msg' => 'CPF/CNPJ não Informado ',
            ]);
        }
                   
        $consulta = DB::table('e999cadusu')->where ([['CgcCpf','=',$CgcCpf]]) ->get();

        if(count($consulta)>0){
                foreach($consulta as $usuario){
                        $NomUsu = $usuario->NomUsu;
                        $Senha  = RecuperacaoSenhaController::geraSenha();
                        $SenUsu = Hash::make($Senha);
                        $IntNet = $usuario->IntNet;


                        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
                            $Ip =  $_SERVER['HTTP_CLIENT_IP'];
                        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
                            $Ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
                        else { 
                            $Ip = $_SERVER['REMOTE_ADDR']; 
                        }
                        

                        $SolicitacaoSenha = DB::table('e999recsen')->insert(
                            [
                                'CgcCpf' => $CgcCpf,
                                'IpSoli' => $Ip,
                                'DtaCad' => date('Y/m/d'),
                                'HorCad' =>  date("H:i:s")
                            ]);

                        
                        if($SolicitacaoSenha == 'true'){
                            $AtualizarUsuario = DB::table('e999cadusu')->where([['CgcCpf','=' , $CgcCpf]])->update(
                                [
                                        'SenUsu' => $SenUsu,
                                        'DtaAtu' =>  date('Y/m/d'),
                                        'HorAtu' =>  date("H:i:s")
                                ]);

                                $assinatura = "
                                Prezado (a) ".$NomUsu. ",
                                <br>
                                Segue abaixo os dados de Acesso ao Sitema
                                <br>
                                Usuário: ".$CgcCpf."
                                <br>Senha: ".$Senha."
                                <br> 
                                <a style=\"float:left;\"  href=\"http://10.0.5.102:81\"> ERP Crns </a>  
                                <br>
                                Atenciosamente.
                                <table>
                                    <tr> 
                                        <td style=\"font-family:arial; font-size:13px; padding-left:10px\">
                                            <strong style=\"font-size: 16px;\"> Appollo Sistemas </strong><br>
                                            Suporte & Atendimento  
                                            <br>appollosistemas@gmail.com
                                            <br><b> Não Responder , e-mail não monitorado.
                                        </td> 
                                    </tr>
                                </table>";
                            
                                $mail = new PHPMailer(true);
                                $mail->CharSet = 'utf-8';
            
                            
                                $mail->isSMTP();                                            // Set mailer to use SMTP
                                $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                                $mail->Username   = '';                     // SMTP username
                                $mail->Password   = '';                               // SMTP password
                                $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
                                $mail->Port       = 587;                                    // TCP port to connect to
            
                                //Recipients
                                $mail->setFrom('', 'Atendimento CRNS');
                                $mail->addAddress($IntNet, $NomUsu);     // Add a recipient
                            
            
                                $mail->isHTML(true);                                  // Set email format to HTML
                                $mail->Subject = 'Recuperação de Senha';
                                $mail->msgHTML($assinatura);
                            
            
                                $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) ); 
                            
                                $mail->send();

                                return response()->json([
                                    'Status' => 'OK',
                                    'Msg' => 'E-mail enviado com Nova Senha. ',
                                ]);

                                
                            
                             


                        }

                }



        }


    }
}
