@extends('adminlte::page')

@section('title', 'Cronus (ERP)')

@section('content_header')
@stop

@section('css')

<link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">


<style type="text/css">
.modal {
text-align: center;
padding: 0!important;
}

.modal:before {
content: '';
display: inline-block;
height: 100%;
vertical-align: middle;
margin-right: -4px;
}

.modal-dialog {
display: inline-block;
text-align: left;
vertical-align: middle;
}

</style>

@stop

@section('js')

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.js') }}"></script>
<script src="{{ asset('js/jquery.maskedinput.js') }}"></script>
<script src="{{ asset('js/jquery.maskMoney.js') }}"></script>


<script type="text/javascript">


   $("#CepFil").focusout(function(){
          var CepConsulta = $("#CepFil").val();
          var Cep = CepConsulta.replace(/\D/g, '');


          ConsultaCep(Cep);

   });


   $("#CodFil").focusout(function(){
    consultarfilialporcodigo();

   });

   function consultarfilialporcodigo(){
        var CodFil = $("#CodFil").val();
        var CodEmpresa = $("#CodEmp").val();

        if(CodFil != null){
          var json = ConvertFormToJSON("#CadastroFilial");
                        var Form = this;
                       $('#myModal').modal('show');

                        $.ajax({


                            type: "GET",
                            dataType : "json",
                            data : json,
                            context : Form,
                            url: "/consulta/cadastro/filial/" + {CodEmp: CodEmpresa} ,

                            success: function(RetornaCadastroFilial) {
                                var status = (RetornaCadastroFilial.Status);

                                if(status=="Localizado"){
                                    $('#CgcFil').prop('readonly', true);
                                    $("#CgcFil").val(RetornaCadastroFilial.CgcFil);
                                    $('#CgcFil').prop('readonly', true);
                                    $("#RazSoc").val(RetornaCadastroFilial.RazSoc);
                                    $("#NomFan").val(RetornaCadastroFilial.NomFan);
                                    $("#RamAtv").val(RetornaCadastroFilial.RamAtv);
                                    $("#CodCli").val(RetornaCadastroFilial.CodCli);
                                    $("#CodFor").val(RetornaCadastroFilial.CodFor);
                                    $("#InsEst").val(RetornaCadastroFilial.InsEst);
                                    $("#InsMun").val(RetornaCadastroFilial.InsMun);
                                    $("#NumTel").val(RetornaCadastroFilial.NumTel);
                                    $("#NumFax").val(RetornaCadastroFilial.NumFax);
                                    $("#IntNet").val(RetornaCadastroFilial.IntNet);
                                    $("#FilMat").val(RetornaCadastroFilial.FilMat);
                                    $("#SitFil").val(RetornaCadastroFilial.SitFil);
                                    $("#CepFil").val(RetornaCadastroFilial.CepFil);
                                    $("#EndFil").val(RetornaCadastroFilial.EndFil);
                                    $('#EndFil').prop('readonly', true);
                                    $("#NumFil").val(RetornaCadastroFilial.NumFil);
                                    $("#CplFil").val(RetornaCadastroFilial.CplFil);
                                    $("#BaiFil").val(RetornaCadastroFilial.BaiFil);
                                    $('#BaiFil').prop('readonly', true);
                                    $("#CidFil").val(RetornaCadastroFilial.CidFil);
                                    $('#CidFil').prop('readonly', true);
                                    $("#UfsFil").val(RetornaCadastroFilial.UfsFil);
                                    $('#UfsFil').prop('readonly', true);
                                    $("#CodPai").val(RetornaCadastroFilial.CodPai);
                                    $('#CodPai').prop('readonly', true);
                                    $("#MunIbg").val(RetornaCadastroFilial.MunIbg);
                                    $('#MunIbg').prop('readonly', true);
                                } else if(status=="ER"){
                                     var Msg = (RetornaCadastroFilial.Msg);


                                     swal({
                                            title: "Advertência!",
                                            text: Msg,
                                            type: "warning",
                                            closeOnConfirm: true // ou mesmo sem isto
                                        }, function() {

                                        });
                                    //swal ( "Advertência",Msg , "error" )   ;



                                }



                                }





                        });

                         $('#myModal').modal('hide');
        }else{
          $("#CodFil").focus();
        }

   }

    $("#CgcFil").focusout(function(){
      consultarcnpj();

    });


    function consultarcnpj(){
                    var CNPJInput = $("#CgcFil").val();
                    var CNPJ = CNPJInput.replace(/\D/g, '');

                    var CodigoEmpresa = $("#CodEmp").val();



        if( (CNPJ.length >= 14)){

                    var json = ConvertFormToJSON("#CadastroFilial");
                    var Form = this;
                    $('#myModal').modal('show');

                    $.ajax({
                        type: "GET",
                        dataType : "json",
                        data : json,
                        context : Form,
                        url: "/consulta/empresa/x/filial/" + {CodEmp: CodigoEmpresa} ,

                        success: function(RetornaValidacaoCgcEmpresaxFilial) {
                            var status = (RetornaValidacaoCgcEmpresaxFilial.Status);

                            if(status == "Ok"){
                              $.ajax({
                                      //O campo URL diz o caminho de onde virá os dados

                                      //Aqui você deve preencher o tipo de dados que será lido,
                                      //no caso, estamos lendo JSON.

                                      dataType: "jsonp",
                                      jsonpCallback: 'jsonCallback',

                                      url: 'https://www.receitaws.com.br/v1/cnpj/'+CNPJ,



                                      //SUCESS é referente a função que será executada caso
                                      //ele consiga ler a fonte de dados com sucesso.
                                      //O parâmetro dentro da função se refere ao nome da variável
                                      //que você vai dar para ler esse objeto.
                                      success: function(resposta){
                                        //Agora basta definir os valores que você deseja preencher
                                        //automaticamente nos campos acima.

                                        var Retorno = (resposta.status);

                                        if (Retorno =="OK"){
                                                $("#NomFan").val(resposta.fantasia);
                                                $("#RazSoc").val(resposta.nome);
                                                $("#CodCna").val(resposta.atividade_principal.code);
                                                $("#IntNet").val(resposta.email);
                                                $("#DtaAbe").val(resposta.abertura);
                                                $("#NumFil").val(resposta.numero);

                                                var CepRetorno = (resposta.cep);
                                                var Cep = CepRetorno.replace(/\D/g, '');

                                                var iniciocep = Cep.substring(0,2);
                                                var meiocep  = Cep.substring(2,5);
                                                var fimcep  = Cep.substring(5,8);

                                                var cepmontado = iniciocep + '.' + meiocep + '-' + fimcep;


                                                $("#CepFil").val(cepmontado);


                                                $('#DtaAbe').prop('readonly', true);
                                                var SitFilial = (resposta.situacao);

                                                if (SitFilial == "ATIVA") {
                                                    $("#SitFil").val('A');
                                                 }else{
                                                    $("#SitFil").val('I');
                                                 }

                                                var FilialMatriz = (resposta.tipo);

                                                if (FilialMatriz == "MATRIZ"){
                                                   $("#FilMat").val("S");
                                                }else{
                                                  $("#FilMat").val("N");
                                                }

                                                var cnae = (resposta.atividade_principal);

                                                $(cnae).each(function (i) {
                                                       $("#CodCna").val(cnae[i].code) ;
                                                       $('#CodCna').prop('readonly', true);
                                               });

                                               $('#RazSoc').prop('readonly', true);
                                               $('#CgcFil').prop('readonly', true);


                                               ConsultaCep(Cep);
                                      }


                                        //Vamos incluir para que o Número seja focado automaticamente
                                        //melhorando a experiência do usuário
                                        $("#InsMun").focus();

                                        $('#myModal').modal('hide');
                                      }
                                    });

                            }else if(status=="ER"){
                                 var Msg = (RetornaValidacaoCgcEmpresaxFilial.Msg);


                                 swal({
                                        title: "Advertência!",
                                        text: Msg,
                                        type: "warning",
                                        closeOnConfirm: true // ou mesmo sem isto
                                    }, function() {

                                    });
                                //swal ( "Advertência",Msg , "error" )   ;



                            }else if(status=="Localizado"){
                                $('#CgcFil').prop('readonly', true);
                                $("#CodFil").val(RetornaValidacaoCgcEmpresaxFilial.CodFil);
                                $('#CodFil').prop('readonly', true);
                                $("#RazSoc").val(RetornaValidacaoCgcEmpresaxFilial.RazSoc);
                                $("#NomFan").val(RetornaValidacaoCgcEmpresaxFilial.NomFan);
                                $("#RamAtv").val(RetornaValidacaoCgcEmpresaxFilial.RamAtv);
                                $("#CodCli").val(RetornaValidacaoCgcEmpresaxFilial.CodCli);
                                $("#CodFor").val(RetornaValidacaoCgcEmpresaxFilial.CodFor);
                                $("#InsEst").val(RetornaValidacaoCgcEmpresaxFilial.InsEst);
                                $("#InsMun").val(RetornaValidacaoCgcEmpresaxFilial.InsMun);
                                $("#NumTel").val(RetornaValidacaoCgcEmpresaxFilial.NumTel);
                                $("#NumFax").val(RetornaValidacaoCgcEmpresaxFilial.NumFax);
                                $("#IntNet").val(RetornaValidacaoCgcEmpresaxFilial.IntNet);
                                $("#FilMat").val(RetornaValidacaoCgcEmpresaxFilial.FilMat);
                                $("#SitFil").val(RetornaValidacaoCgcEmpresaxFilial.SitFil);
                                $("#CepFil").val(RetornaValidacaoCgcEmpresaxFilial.CepFil);
                                $("#EndFil").val(RetornaValidacaoCgcEmpresaxFilial.EndFil);
                                $('#EndFil').prop('readonly', true);
                                $("#NumFil").val(RetornaValidacaoCgcEmpresaxFilial.NumFil);
                                $("#CplFil").val(RetornaValidacaoCgcEmpresaxFilial.CplFil);
                                $("#BaiFil").val(RetornaValidacaoCgcEmpresaxFilial.BaiFil);
                                $('#BaiFil').prop('readonly', true);
                                $("#CidFil").val(RetornaValidacaoCgcEmpresaxFilial.CidFil);
                                $('#CidFil').prop('readonly', true);
                                $("#UfsFil").val(RetornaValidacaoCgcEmpresaxFilial.UfsFil);
                                $('#UfsFil').prop('readonly', true);
                                $("#CodPai").val(RetornaValidacaoCgcEmpresaxFilial.CodPai);
                                $('#CodPai').prop('readonly', true);
                                $("#MunIbg").val(RetornaValidacaoCgcEmpresaxFilial.MunIbg);
                                $('#MunIbg').prop('readonly', true);
                            }
                      }



                    });

                  $('#myModal').modal('hide');

          }else {
            $("#CgcFil").focus();
          }

}


function ConsultaCep(NumCep){
  var CEP = NumCep;

  $.ajax({
   //O campo URL diz o caminho de onde virá os dados
   //É importante concatenar o valor digitado no CEP
   url: 'https://viacep.com.br/ws/'+CEP+'/json/unicode/',
   //Aqui você deve preencher o tipo de dados que será lido,
   //no caso, estamos lendo JSON.
   dataType: 'json',
   //SUCESS é referente a função que será executada caso
   //ele consiga ler a fonte de dados com sucesso.
   //O parâmetro dentro da função se refere ao nome da variável
   //que você vai dar para ler esse objeto.
   success: function(resposta){
     //Agora basta definir os valores que você deseja preencher
     //automaticamente nos campos acima.
     $('#CepFil').prop('readonly', true);
     $('#CidFil').prop('readonly', true);
     $('#UfsFil').prop('readonly', true);
     $('#MunIbg').prop('readonly', true);
     $('#BaiFil').prop('readonly', true);
     $('#EndFil').prop('readonly', true);
     $("#CplFil").val(resposta.complemento);
     $("#BaiFil").val(resposta.bairro);
     $("#CidFil").val(resposta.localidade);
     $("#EndFil").val(resposta.logradouro);
     $("#UfsFil").val(resposta.uf);
     $("#MunIbg").val(resposta.ibge);
     $("#CodPai").val('1058');
     $("#CodPai").prop('readonly', true);


     //Vamos incluir para que o Número seja focado automaticamente
     //melhorando a experiência do usuário
     $("#NumFil").focus();


}
});

}

function mascara(t, mask){
    var i = t.value.length;
    var saida = mask.substring(1,0);
    var texto = mask.substring(i)
    if (texto.substring(0,1) != saida){
    t.value += texto.substring(0,1);
}
}

function mascaraData( campo, e )
{
	var kC = (document.all) ? event.keyCode : e.keyCode;
	var data = campo.value;

	if( kC!=8 && kC!=46 )
	{
		if( data.length==2 )
		{
			campo.value = data += '/';
		}
		else if( data.length==5 )
		{
			campo.value = data += '/';
		}
		else
			campo.value = data;
	}
}

document.getElementById("endereco").style.display = "none";


function LimparFormulario(){
  $('#CadastroFilial').each (function(){
      this.reset();
    });
    $('#CodFil').prop('readonly', false);
    $('#CepFil').prop('readonly', false);
    $('#CidFil').prop('readonly', false);
    $('#UfsFil').prop('readonly', false);
    $('#MunIbg').prop('readonly', false);
    $('#BaiFil').prop('readonly', false);
    $('#EndFil').prop('readonly', false);
    $("#CodPai").prop('readonly', false);
    $('#RazSoc').prop('readonly', false);
    $('#CgcFil').prop('readonly', false);
    $('#CodCna').prop('readonly', false);
    $('#DtaAbe').prop('readonly', false);

}


function mostraendereco(){

  if (document.CadastroFilial.NomFan.value == "" )
  {
    document.CadastroFilial.NomFan.focus();
    return false;
 }
 if (document.CadastroFilial.RazSoc.value == "" )
 {
   document.CadastroFilial.RazSoc.focus();
   return false;
 }
 if (document.CadastroFilial.CgcFil.value == "" )
 {
   document.CadastroFilial.CgcFil.focus();
   return false;
 }
 if (document.CadastroFilial.InsEst.value == "" )
 {
   document.CadastroFilial.InsEst.focus();
   return false;
 }
 if (document.CadastroFilial.NumTel.value == "" )
 {
   document.CadastroFilial.NumTel.focus();
   return false;
 }
 if (document.CadastroFilial.IntNet.value == "" )
 {
   document.CadastroFilial.IntNet.focus();
   return false;
 }
      document.getElementById("endereco").style.display = "";
      document.getElementById("dados").style.display = "none";
}

function validaendereco(){

  if (document.CadastroFilial.CepFil.value == "" )
  {
    document.CadastroFilial.CepFil.focus();
    return false;
 }
 if (document.CadastroFilial.EndFil.value == "" )
 {
   document.CadastroFilial.EndFil.focus();
   return false;
 }
 if (document.CadastroFilial.NumFil.value == "" )
 {
   document.CadastroFilial.NumFil.focus();
   return false;
 }
 if (document.CadastroFilial.BaiFil.value == "" )
 {
   document.CadastroFilial.BaiFil.focus();
   return false;
 }
 if (document.CadastroFilial.CidFil.value == "" )
 {
   document.CadastroFilial.CidFil.focus();
   return false;
 }
 if (document.CadastroFilial.UfsFil.value == "" )
 {
   document.CadastroFilial.UfsFil.focus();
   return false;
 }
 if (document.CadastroFilial.MunIbg.value == "" )
 {
   document.CadastroFilial.MunIbg.focus();
   return false;
 }

    salvar();
}


function voltaendereco(){
      document.getElementById("endereco").style.display = "";
      document.getElementById("fiscal").style.display = "none";
}





function voltadados(){
      document.getElementById("dados").style.display = "";
      document.getElementById("endereco").style.display = "none";
}


//Converter Formulario em JSON
function ConvertFormToJSON(form){
        
        var array = jQuery(form).serializeArray();
        var json = {};

        jQuery.each(array, function() {
          json[this.name] = this.value || '';
        });

       
        return json;
}



function salvar(){
	//var data = {}
    var json = ConvertFormToJSON("#CadastroFilial");
    var Form = this;


    
 $('#myModal').modal('show');
	$.ajax({

			type: "POST",
			dataType : "json",
		  data : json,
		  context : Form,
			url: "/cadastro/filial",
			success: function(Retorno) {
				var status = (Retorno.Status);

				 $('#myModal').modal('hide');

			  if (status =="OK") {
					 var Msg = (Retorno.Mensagem);
             swal(Msg," ", "success");
						 LimparFormulario();
				}else {
						CadastronaoRealizado();
				}
			}


	});

};


function CadastroRealizado(){

  swal("Registro Salvo com Sucesso"," ", "success");
}

function CadastronaoRealizado(){
  swal ( "Desculpe !","Ocorreu um erro. Tente Novamente" , "error" )   ;
}


/**
* Função para aplicar máscara em campos de texto
* Copyright (c) 2008, Dirceu Bimonti Ivo - http://www.bimonti.net
* All rights reserved.
*/
function maskIt(w,e,m,r,a){
        // Cancela se o evento for Backspace

        if (!e) var e = window.event

        if (e.keyCode) code = e.keyCode;

        else if (e.which) code = e.which;



        // Variáveis da função

        var txt = (!r) ? w.value.replace(/[^\d]+/gi,'') : w.value.replace(/[^\d]+/gi,'').reverse();

        var mask = (!r) ? m : m.reverse();

        var pre = (a ) ? a.pre : "";

        var pos = (a ) ? a.pos : "";

        var ret = "";



        if(code == 9 || code == 8 || txt.length == mask.replace(/[^#]+/g,'').length) return false;



        // Loop na máscara para aplicar os caracteres

        for(var x=0,y=0, z=mask.length;x<z && y<txt.length;){

        if(mask.charAt(x)!='#'){

        ret += mask.charAt(x); x++;

        } else{

        ret += txt.charAt(y); y++; x++;

        }

        }



        // Retorno da função

        ret = (!r) ? ret : ret.reverse()

        w.value = pre+ret+pos;

        }



        // Novo método para o objeto 'String'

        String.prototype.reverse = function(){

        return this.split('').reverse().join('');

};


 </script>



@stop

@section('content')

<!--Inicio-->
<div class="page-header">

<center>
  <h3> Cadastro de Filial</h3>
</center>
</div>
<div>
<body>



<form class="form"  id="CadastroFilial" method="post"  >

{!! csrf_field() !!}
     <div class="container">
     			<div id="cadastrofilial">
             <div id="dados">

                    <div class="col-md-12">
                      <h4> <b>Dados Filial </b> </h4>
                    </div>
                    <div class="row">
                          <div class="col-md-2">
                            <label for="CodEmp">Empresa </label>
                            <div class="input-group">
                                <input class="form-control" type="text" id="CodEmp" name="CodEmp" value="{{$CodEmp}}"   placeholder="Código" readonly />
                                <div class="input-group-btn">
                                  <button type="button" class="btn btn-info">
                                     <span class="fa fa-search"></span>
                                   </button>
                              </div>
                            </div>
                          </div>
                    </div>

                    <div class="row">
                      <div class="col-md-2">
                        <label for="CodEmp">Código </label>
                        <div class="input-group">
                            <input class="form-control" type="text" id="CodFil" name="CodFil"  placeholder="Código" />
                           
                            <div class="input-group-btn">
                              <button  class="btn btn-info" onclick="consultarfilialporcodigo()">
                                 <span class="fa fa-search"></span>
                               </button>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                            <label for="NomFan">* Nome Fantasia </label>
                            <input class="form-control" type="text" id="NomFan" autocomplete="off" name="NomFan"   placeholder="Nome Fantasia" >
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-8">
                            <label for="CodEmp">* Razão Social </label>
                            <input class="form-control" type="text" id="RazSoc" name="RazSoc" autocomplete="off" placeholder="Razão Social" >
                      </div>
                  </div>

                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                          <label for="RamAtv">* Ramo de Atividade</label>
                          <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="RamAtv" name="RamAtv" required>
                              <option selected value="C">Comercial</option>
                              <option value="I">Industrial</option>
                              <option value="S">Prestação de Serviços</option>
                          </select>
                      </div>
                    </div>


                      <div class="col-md-2">
                        <label for="GruEmp">Filial como Cliente</label>
                        <div class="input-group">
                            <input class="form-control" type="number" id="CodCli" name="CodCli"  placeholder="Filial como Cliente" readonly />
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-info" >
                                <span class="fa fa-search"></span>
                          </div>
                        </div>
                      </div>

                    <div class="col-md-2">
                       <label for="GruEmp">Filial como Fornecedor</label>
                        <div class="input-group">
                            <input class="form-control" type="number" id="CodFor" name="CodFor"  placeholder="Filial como fornecedor" readonly />
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-info" >
                                <span class="fa fa-search"></span>
                          </div>
                        </div>
                      </div>
                </div>


                <div class="row">
                    <div class="col-md-3">
                        <label for="CgcFil">* Cnpj</label>
                        <div class="input-group">
                                    <input class="form-control" type="text" id="CgcFil" autocomplete="off"  name="CgcFil"
                                      
                                        onkeyup="maskIt(this,event,'##.###.###/####-##')"  maxlength="18"
                                       placeholder="CNPJ"
                                    
                                         >
                                         
                                         <div class="input-group-btn">
                                           <button  class="btn btn-info" onclick="consultarcnpj()">
                                              <span class="fa fa-search"></span>
                                            </button>
                                       </div>


                          </div>
                      </div>

                      <div class="col-md-3">
                          <label for="GruEmp">* Inscrição Estadual</label>
                          <input class="form-control" type="text" autocomplete="off" id="InsEst" name="InsEst"  placeholder="Inscrição Estadual" required/>
                        </div>

                        <div class="col-md-3">
                            <label for="GruEmp">Inscrição Municipal</label>
                            <input class="form-control" type="number" autocomplete="off" id="InsMun" name="InsMun" placeholder="Inscrição Municipal" />
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-2">
                            <label for="GruEmp">* Telefone</label>
                            <input class="form-control" type="text" autocomplete="off" id="NumTel" name="NumTel"  placeholder="Telefone" />
                          </div>

                          <div class="col-md-2">
                              <label for="GruEmp">Fax</label>
                              <input class="form-control" type="text" autocomplete="off"  id="NumFax" name="NumFax"  onkeyup="maskIt(this,event,'##-####-####')" maxlength="12"
                              placeholder="Fax" />
                            </div>

                            <div class="col-md-5">
                                <label for="GruEmp">* E-mail</label>
                                <input class="form-control" type="email" autocomplete="off" id="IntNet" name="IntNet"  placeholder="E-mail" />
                            </div>
                        </div>


                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                                <label for="TipTit">* Matriz</label>
                                <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="FilMat" name="FilMat" required>
                                    <option  value="S">Sim</option>
                                    <option selected value="N">Não</option>
                                </select>
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-group">
                                <label for="TipTit">* Situação</label>
                                <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="SitFil" name="SitFil" required>
                                    <option selected value="A">Ativo</option>
                                    <option value="I">Inativo</option>
                                </select>
                            </div>
                          </div>
                      </div>


                      <div class="container-fluid">
                            <div class="row">
                                  <div class="col-md-2">
                                        <button type="button" name="btnlimpar" onclick="LimparFormulario()"   class="btn btn-danger btn-sm custom-button-width"><i class="fa fa-refresh" aria-hidden="true"></i>  Limpar</button>
                                  </div>
                                <div class="col-md-6 text-right">
                                    <button  name="btnmostraendereco"  onclick="mostraendereco()" type="button" class="btn btn-primary btn-sm custom-button-width .navbar-right"><i class="fa fa-arrow-right" aria-hidden="true"></i>  Próximo</button>
                                 </div>
                            </div>
                    </div>



     		</div>
      </div>


        <div id="endereco">
            <div class="row">
                  <div class="col-md-12">
                    <h4> <b>Dados do Endereço </b> </h4>
                  </div>
            </div>

                  <div class="row">
                      <div class="col-md-2">
                          <label for="Cep">* Cep</label>
                          <input class="form-control" type="text" id="CepFil" name="CepFil" placeholder="Cep"
                          value="{{isset($consultarfilial->CepFil) ? $consultarfilial->CepFil : ''}}"
                          onkeypress="mascara(this, '##.###-###')" maxlength="10" required/>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-6">
                          <label for="Cep">* Endereço</label>
                          <input class="form-control" type="text" id="EndFil" name="EndFil"value="{{isset($consultarfilial->EndFil) ? $consultarfilial->EndFil : ''}}"
                          @if(isset($consultarfilial))
                              readonly
                          @endif
                          placeholder="Endereço" required/>
                      </div>

                      <div class="col-md-2">
                          <label for="NumFil">* Número</label>
                          <input class="form-control" type="text" id="NumFil" name="NumFil" placeholder="Numero" value="{{isset($consultarfilial->NumFil) ? $consultarfilial->NumFil : ''}}" required/>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-3">
                          <label for="Cep">Complemento</label>
                          <input class="form-control" type="text" id="CplFil" name="CplFil" value="{{isset($consultarfilial->CplFil) ? $consultarfilial->CplFil : ''}}"placeholder="Complemento" />
                      </div>

                      <div class="col-md-3">
                          <label for="Cep">* Bairro</label>
                          <input class="form-control" type="text" id="BaiFil" name="BaiFil" value="{{isset($consultarfilial->BaiFil) ? $consultarfilial->BaiFil : ''}}"
                          @if(isset($consultarfilial))
                              readonly
                          @endif
                          placeholder="Bairro " required/>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-3">
                          <label for="Cep">* Cidade</label>
                          <input class="form-control" type="text" id="CidFil" name="CidFil" value="{{isset($consultarfilial->CidFil) ? $consultarfilial->CidFil : ''}}"
                          @if(isset($consultarfilial))
                              readonly
                          @endif
                          placeholder="Cidade" required/>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-2">
                          <label for="Cep">* Estado</label>
                          <input class="form-control" type="text" id="UfsFil" Size="2" name="UfsFil" value="{{isset($consultarfilial->UfsFil) ? $consultarfilial->UfsFil : ''}}"
                          @if(isset($consultarfilial))
                              readonly
                          @endif
                          placeholder="Estado" required/>
                      </div>
                  </div>

                <div class="row">
                    <div class="col-md-2">
                        <label for="Cep">* Código País</label>
                        <input class="form-control" type="text" id="CodPai" name="CodPai" value="{{isset($consultarfilial->CodPai) ? $consultarfilial->CodPai : ''}}"
                        @if(isset($consultarfilial))
                            readonly
                        @endif
                         placeholder="Código País" />
                    </div>
                    <div class="col-md-2">
                        <label for="Cep">* Código Municipio IBGE</label>
                        <input class="form-control" type="text" id="MunIbg" name="MunIbg" value="{{isset($consultarfilial->MunIbg) ? $consultarfilial->MunIbg : ''}}"
                        @if(isset($consultarfilial))
                            readonly
                        @endif
                        placeholder="Código Municipo Ibge" required/>
                    </div>
                </div>

                      <br>
                <div class="row">
                    <div class="col-md-2">
                                    <button type="button" name="btnvoltadados" onclick="voltadados()" class="btn btn-primary btn-sm custom-button-width"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Anterior</button>
                    </div>
                    <div class="col-md-6 text-right">
                                <button  name="btnmostrafiscal"  onclick="validaendereco()" type="button" class="btn btn-primary btn-sm custom-button-width .navbar-right"><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>
                    </div>

     			       </div>
     			</div>



</div>
    <input type="hidden" name="CodUsu" id="CodUsu" value="{{ Auth::user()->CodUsu }}">
    <input type="hidden" name="CodEmp" id="CodEmp" value="{{$CodEmp}}">
</div>

<br>
</form>
</div>
</div>
</div>



<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class=" modal-dialog modal-sm  modal-dialog-centered" role="document">
    <div class="modal-content">
      <center>
      <img src="/img/load.gif" width="300px"  >
    </center>
    </div>
  </div>
</div>

@stop
