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
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.maskedinput.js') }}"></script>
<script src="{{ asset('js/jquery.mask.js') }}"></script>


<script type="text/javascript">

// Mascara de CPF e CNPJ
var CpfCnpjMaskBehavior = function (val) {
			return val.replace(/\D/g, '').length <= 11 ? '000.000.000-009' : '00.000.000/0000-00';
		},
    cpfCnpjpOptions = {
    	onKeyPress: function(val, e, field, options) {
      	field.mask(CpfCnpjMaskBehavior.apply({}, arguments), options);
      }
    };

$(function() {
	$(':input[name=CgcCpf]').mask(CpfCnpjMaskBehavior, cpfCnpjpOptions);
})

$("#CepRep").focusout(function(){
       var CepConsulta = $("#CepRep").val();
       var Cep = CepConsulta.replace(/\D/g, '');


       ConsultaCep(Cep);

});


$("#CgcCpf").focusout(function(){
      consultarporcgc();
});

$("#CodRep").focusout(function(){
     consultarporcodigo();
});


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
     $('#CidRep').prop('readonly', true);
     $('#UfsRep').prop('readonly', true);
     $('#BaiRep').prop('readonly', true);
     $('#EndRep').prop('readonly', true);
     $("#CplRep").val(resposta.complemento);
     $("#BaiRep").val(resposta.bairro);
     $("#CidRep").val(resposta.localidade);
     $("#EndRep").val(resposta.logradouro);
     $("#UfsRep").val(resposta.uf);
     

     //Vamos incluir para que o Número seja focado automaticamente
     //melhorando a experiência do usuário
     $("#NumFil").focus();


}
});

}

function salvar(){
	//var data = {}
  var json = ConvertFormToJSON("#CadastroRepresentante");
  var Form = this;

	$.ajax({

			type: "POST",
			dataType : "json",
		  data : json,
		  context : Form,
			
			url: "/novo/representante",
			success: function(Retorno) {
				var status = (Retorno.Status);

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

function consultarporcodigo(){

  var json = ConvertFormToJSON("#CadastroRepresentante");
  var Form = this;
  var CodRep = $('#CodRep').val();

    $.ajax({
          type: "GET",
          dataType : "json",
          data : json,
          context : Form,
          url: "/consulta/representante/codigo/" + {CodRep: CodRep} ,

          success: function(Retorno) {
                  var Status = Retorno.Status;
                  var Msg = Retorno.Msg;

                  if(Status == 'Localizado'){
                    $('#CgcCpf').val(Retorno.CgcCpf);
                    $('#RazSoc').val(Retorno.RazSoc);
                    $('#InsEst').val(Retorno.InsEst);
                    $('#IntNet').val(Retorno.IntNet);
                    $('#CodFor').val(Retorno.CodFor);
                    $('#CodCli').val(Retorno.CodCli);
                    $('#CepRep').val(Retorno.CepRep);
                    $('#EndRep').val(Retorno.EndRep);
                    $('#NumRep').val(Retorno.NumRep);
                    $('#CplRep').val(Retorno.CplRep);
                    $('#BaiRep').val(Retorno.BaiRep);
                    $('#CidRep').val(Retorno.CidRep);
                    $('#UfsRep').val(Retorno.UfsRep);
                    $('#SitRep').val(Retorno.SitRep);

                    $('#CidRep').prop('readonly', true);
                    $('#UfsRep').prop('readonly', true);
                    $('#BaiRep').prop('readonly', true);
                    $('#EndRep').prop('readonly', true);
                    $('#CodRep').prop('readonly', true);
                    
                  } else {

                    swal(Msg," ", "error");
                    $('#CgcCpf').focus();
                  }

          }
          


    });
}


function consultarporcgc(){

var json = ConvertFormToJSON("#CadastroRepresentante");
var Form = this;
var CgcCpf = $('#CgcCpf').val();

    $.ajax({
          type: "GET",
          dataType : "json",
          data : json,
          context : Form,
          url: "/consulta/representante/cgccpf/" + {CgcCpf: CgcCpf} ,

          success: function(Retorno) {
                  var Status = Retorno.Status;

                  if(Status == 'Localizado'){
                    $('#CodRep').val(Retorno.CodRep);
                    $('#RazSoc').val(Retorno.RazSoc);
                    $('#InsEst').val(Retorno.InsEst);
                    $('#IntNet').val(Retorno.IntNet);
                    $('#CodFor').val(Retorno.CodFor);
                    $('#CodCli').val(Retorno.CodCli);
                    $('#CepRep').val(Retorno.CepRep);
                    $('#EndRep').val(Retorno.EndRep);
                    $('#NumRep').val(Retorno.NumRep);
                    $('#CplRep').val(Retorno.CplRep);
                    $('#BaiRep').val(Retorno.BaiRep);
                    $('#CidRep').val(Retorno.CidRep);
                    $('#UfsRep').val(Retorno.UfsRep);
                    $('#SitRep').val(Retorno.SitRep);

                    $('#CidRep').prop('readonly', true);
                    $('#UfsRep').prop('readonly', true);
                    $('#BaiRep').prop('readonly', true);
                    $('#EndRep').prop('readonly', true);
                    $('#CodRep').prop('readonly', true);

                   

                    
                    
                  }

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


function LimparFormulario(){
  $('#CadastroRepresentante').each (function(){
      this.reset();
    });

    $('#CidRep').prop('readonly', false);
    $('#UfsRep').prop('readonly', false);
    $('#BaiRep').prop('readonly', false);
    $('#EndRep').prop('readonly', false);
    $('#CodRep').prop('readonly', false);
    $('#CgcEmp').focus();

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

function ConvertFormToJSON(form){
					 
					 var array = jQuery(form).serializeArray();
					 var json = {};

					 jQuery.each(array, function() {
							 json[this.name] = this.value || '';
					 });

					 
					 return json;
	}






 </script>



@stop

@section('content')

<!--Inicio-->
<center>
  <h3> Cadastro de Representantes</h3>
</center>



<div>
<body>

<form class="form"  id="CadastroRepresentante" method="post"  action="">


{!! csrf_field() !!}




<div class"container">
  <div class="row">
        <div class="col-md-12">
          <h4> <b>Dados do Representante </b> </h4>
        </div>
  </div>
    <div class="row">

        <div class="col-md-2">
          <label for="CodEmp">Código </label>
          <div class="input-group">
              <input class="form-control" type="number" id="CodRep" name="CodRep" placeholder="Código" />
              <div class="input-group-btn">
                  <button type="button" class="btn btn-info" >
                  <span class="fa fa-search"></span>
            </div>
          </div>
        </div>


    </div>


    <div class="row">
      <div class="col-md-5">
            <label for="NomFan">* Nome Completo  / Razão Social </label>
            <input class="form-control" type="text" id="RazSoc" name="RazSoc" placeholder="Nome Completo / Razão Social" required/>
      </div>

        <div class="col-md-3">
            <label for="GruEmp">* CNPJ / CPF </label>
            <div class="input-group">
                        <input class="form-control" type="text" id="CgcCpf" autocomplete="off"  name="CgcCpf"
                           placeholder="CPF/CNPJ" >
                             <div class="input-group-btn">
                               <button  class="btn btn-info">
                                  <span class="fa fa-search"></span>
                                </button>
                           </div>


              </div>
          </div>

					<div class="col-md-2">
								<label for="NomFan">*Inscrição Estadual </label>
								<input class="form-control" type="text" id="InsEst" name="InsEst" placeholder="Inscrição Estadual" required/>
					</div>


  </div>

  <div class="row">
  <div class="col-md-5">
            <label for="IntNet">*E-mail </label>
            <input class="form-control" type="email" id="IntNet" name="IntNet" placeholder="E-mail" required/>
      </div>
    <div class="col-md-2">
          <label for="NomFan">Código Cliente </label>
          <input class="form-control" type="text" id="CodCli" name="CodCli" placeholder="Código Cliente" readonly/>
    </div>
    <div class="col-md-2">
          <label for="NomFan">Código Fornecedor </label>
          <input class="form-control" type="text" id="CodFor" name="CodFor" placeholder="Código Fornecedor" readonly/>
    </div>

  </div>


    <div class="row">
        <div class="col-md-2">
            <label for="Cep">* Cep</label>
            <input class="form-control" type="text" id="CepRep" name="CepRep" placeholder="Cep"
            onkeypress="mascara(this, '##.###-###')" maxlength="10" required/>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label for="Cep">* Endereço</label>
            <input class="form-control" type="text" id="EndRep" name="EndRep"
            placeholder="Endereço" required/>
        </div>

        <div class="col-md-2">
            <label for="NumFil">* Número</label>
            <input class="form-control" type="text" id="NumRep" name="NumRep" placeholder="Numero"  required/>
        </div>

        <div class="col-md-3">
            <label for="Cep">Complemento</label>
            <input class="form-control" type="text" id="CplRep" name="CplRep" placeholder="Complemento" />
        </div>

    </div>



    <div class="row">
      <div class="col-md-3">
          <label for="Cep">* Bairro</label>
          <input class="form-control" type="text" id="BaiRep" name="BaiRep" 
          placeholder="Bairro " required/>
      </div>

        <div class="col-md-3">
            <label for="Cep">* Cidade</label>
            <input class="form-control" type="text" id="CidRep" name="CidRep"
            @if(isset($consultarfilial))
                readonly
            @endif
            placeholder="Cidade" required/>
        </div>

        <div class="col-md-2">
            <label for="Cep">* Estado</label>
            <input class="form-control" type="text" id="UfsRep" Size="2" name="UfsRep"
            @if(isset($consultarfilial))
                readonly
            @endif
            placeholder="Estado" required/>
        </div>
    </div>


    <div class="row">
        <div class="col-md-2">
          <div class="form-group">
              <label for="TipTit">Situação</label>
              <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="SitRep" name="SitRep" required>
                  <option selected value="A">Ativo</option>
                  <option value="I">Inativo</option>
              </select>
          </div>
        </div>
    </div>




</div>


  <input type="hidden" name="CodUsu" value="{{ Auth::user()->CodUsu }}">
  <input type="hidden" name="CodEmp" value="{{ $CodEmp }}">
  <input type="hidden" name="CodFil" value="{{ $CodFil }}">


</div>

<br>
<div class="container-fluid">
      <div class="row">
            <div class="col-md-2">
                  <button type="button" name="btnlimpar"  onclick="LimparFormulario()"  class="btn btn-danger btn-sm custom-button-width"> <i class="fa fa-refresh" aria-hidden="true"></i> Limpar</button>
            </div>
          <div class="col-md-6 text-right">
              <button  name="btnsalvar"   type="button" onclick="salvar()" class="btn btn-primary btn-sm custom-button-width .navbar-right"><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>
           </div>
      </div>
</div>

</form>
</div>
</div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class=" modal-dialog modal-sm  modal-dialog-centered" role="document">
    <div class="modal-content">
      <center>
      <img src="/img/carregando.gif" width="200px"  >
    </center>
    </div>
  </div>
</div>


  <div class="modal fade" id="ModalMsg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class=" modal-dialog modal-sm  modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <center>
              <h3 class="modal-title"> <i class="fa fa-info-circle" aria-hidden="true"></i> Informação </h3>
          </center>
        </div>
        <div class="modal-body">
          <p>
           O CNPJ informado não pertence a Matriz da Empresa.
         </p>
          Só é possivel realizar o Cadastro da Empresa com o CNPJ da Matriz.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm custom-button-width .navbar-right" data-dismiss="modal">Fechar</button>
        </div>
    </div>
  </div>
</div>


  <div class="modal fade" id="ModalInativa" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class=" modal-dialog modal-sm  modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <center>
              <h3 class="modal-title"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Advertência </h3>
          </center>
        </div>
        <div class="modal-body">
          <p>
           Não é possivel cadastrar empresa Inativa na Receita Federal.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm custom-button-width .navbar-right" data-dismiss="modal">Fechar</button>
        </div>
    </div>
  </div>


@stop
