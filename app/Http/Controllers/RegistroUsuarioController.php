<?php

namespace App\Http\Controllers;

//require_once "../vendor/autoload.php";

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RegistroUsuarioController extends Controller
{
    private function processar(Request $request){
            $dados  = $request->all();
            $NomUsu = $dados['NomUsu'] ;
            $SenUsu = RegistroUsuarioController::geraSenha();
            $CgcCpf = $dados['CgcCpf'];
            $IntNet = $dados['IntNet'];
            $FotUsu = 'default.jpg';

            $Senha = $SenUsu;

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


            $consulta = DB::table('e999cadusu')->where ([['CgcCpf','=',$CgcCpf]]) ->get();

            


            if(count($consulta) >0){
                return response()->json([
                    'Status' => 'Er',
                    'Msg' => 'Não é possível atualizar os dados de usuário após o Cadastro. ',
                ]);

            } else {

                $CadastroUsuario = DB::table('e999cadusu')->insert(
                    [
                        'NomUsu' => $NomUsu,
                        'CgcCpf' => $CgcCpf,
                        'SenUsu' => Hash::make($SenUsu),
                        'IntNet' => $IntNet,
                        'FotUsu' => $FotUsu,
                        'SitUsu' => 'A',
                        'UsuCad' => $CodUsu,
                        'DtaCad' => date('Y/m/d'),
                        'HorCad' =>  date("H:i:s")
                    ]);

                 if($CadastroUsuario == 'true'){
                    $consulta = DB::table('e999cadusu')->where ([['CgcCpf','=',$CgcCpf]]) ->get();

                    if (count($consulta)> 0){
                        foreach($consulta as $usuario ){
                            $UsuCad = $usuario->CodUsu;

                            $CadastroEmpresaFilial = DB::table('e999empfil')->insert(
                                [
                                    'CodEmp' => $CodEmp,
                                    'CodFil' => $CodFil,
                                    'CodUsu' => $UsuCad,
                                ]);

                                if($CadastroEmpresaFilial == 'true'){
                                   $registro = RegistroUsuarioController::enviarsenha($NomUsu,$CgcCpf,$Senha,$IntNet);

                                        
                                   return response()->json([
                                    'Status' => 'OK',
                                    'Msg' => 'Registro salvo com Sucesso!. Senha enviada por e-mail.',
                                   ]);
                                       

                                }

                        }

                    }
                        

                 }

                 
            }




            


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


    private function enviarsenha($NomUsu,$CgcCpf,$Senha,$IntNet){
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
                $mail->Username   = 'appollosistemas@gmail.com';                     // SMTP username
                $mail->Password   = '@vini1107';                               // SMTP password
                $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port       = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('appollosistemas@gmail.com', 'Atendimento CRNS');
                $mail->addAddress($IntNet, $NomUsu);     // Add a recipient
            

                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Dados de Acesso ao Sistema';
                $mail->msgHTML($assinatura);
            

                $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) ); 
            
                if(!$mail->send()) {
                    $Msg = 'Erro ao Enviar e-mail ' . $mail->ErrorInfo;
                    return $Msg;
                    
                 } else {
                    $Msg = 'Usuário Cadastrado e senha enviada por E-mail.';
                    return $Msg;
                 }
    }


   


    private function consultar(){


    }
    
}
