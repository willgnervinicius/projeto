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



<script type="text/javascript">



var CpfCnpjMaskBehavior = function (val) {
			return val.replace(/\D/g, '').length <= 11 ? '000.000.000-009' : '00.000.000/0000-00';
		},
    cpfCnpjpOptions = {
    	onKeyPress: function(val, e, field, options) {
      	field.mask(CpfCnpjMaskBehavior.apply({}, arguments), options);
      }
    };

$(function() {
	$(':input[name=CgcMat]').mask(CpfCnpjMaskBehavior, cpfCnpjpOptions);
})


$("#CepTran").focusout(function(){
       var CepConsulta = $("#CepTran").val();
       var Cep = CepConsulta.replace(/\D/g, '');


       ConsultaCep(Cep);

});





	 $("#CodEmp").focusout(function(){
        consultarporcodigo();
	 });




   $("#CgcMat").focusout(function(){
       consultarCgc();
   });


  function consultarCgc(){
    var CNPJInput = $("#CgcMat").val();
     var CNPJ = CNPJInput.replace(/\D/g, '');

     if (CNPJ.length > 12){

			 var json = ConvertFormToJSON("#CadastroEmpresa");
			 var Form = this;
			 var origin   = window.location.origin;

			  $('#myModal').modal('show');

							$.ajax({

							type: "GET",
							dataType : "json",
							data : json,
							context : Form,




					  url: "/nova/empresa/" + {CgcMat: $("#CgcMat").val()},


							success: function(Retorno) {
                      var status = (Retorno.Status);
                      var Cnpj = (Retorno.CgcMat);
                      var NomFan = (Retorno.NomFan);
                      var GruEmp = (Retorno.GruEmp);
                      var Codigo = (Retorno.CodEmp);




                      if (status =="Ok") {
                            $('#CodEmp').val(Retorno.CgcMat);
                            $('#NomFan').val(Retorno.NomFan);
                            $('#GruEmp').val(Retorno.GruEmp);
                            $('#SitEmp').val(Retorno.SitEmp);
                            $('#CodEmp').val(Retorno.CodEmp);

                            
                           
                      }else {
                                            $('#myModal').modal('hide');


                      }


              }
							


							});

      } else {
          return false;

     }


       $('#myModal').modal('hide');
  
  }

     









function LimparFormulario(){
  $('#CadastroEmpresa').each (function(){
      this.reset();
    });


    $('#CgcMat').prop('readonly', false);
    $('#CodEmp').prop('readonly', false);
    $('#CgcMat').focus();

}





//Função Cadastro Realizado com Sucesso





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

// Enviar Cadastro Via Ajax sem Jquery

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function salvar(){
    var json = ConvertFormToJSON("#CadastroEmpresa");
    var Form = this;
    $('#myModal').modal('show');
    $.ajax({

        type: "POST",
        dataType : "json",
        data : json,
        context : Form,
        url: "/nova/empresa",

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


function consultarporcodigo(){

      var json = ConvertFormToJSON("#CadastroEmpresa");
      var Form = this;



			var Empresa = $("#EmpresaLogada").val();
			var CodEmp =  $("#CodEmp").val();

        if(Empresa == CodEmp){
          $('#myModal').modal('show');
          $.ajax({

              type: "GET",
              dataType : "json",
              data : json,
              context : Form,
              url: "/nova/empresa/" + {CodEmp: $("#EmpresaLogada").val()} ,
              
              success: function(Retorno) {
                var status = (Retorno.Status);
               

                if(status =="Ok"){
                            
                            $('#CgcMat').val(Retorno.CgcMat);
                            $('#NomFan').val(Retorno.NomFan);
                            $('#GruEmp').val(Retorno.GruEmp);
                            $('#SitEmp').val(Retorno.SitEmp);
                            
                  
                  $(':input[name=CgcMat]').mask(CpfCnpjMaskBehavior, cpfCnpjpOptions);
                }else {
                  $('#CgcMat').prop('readonly', false);

                }






              }


          });
        $('#myModal').modal('hide');

        } else {
          swal({
                title: "Advertência!",
                text: 'Não é possivel consultar outra empresa a não ser a que esta Logado.',
                type: "warning",
                closeOnConfirm: true // ou mesmo sem isto
            }, function() {

            });
        }

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
  <h3> Cadastro de Empresa</h3>
</center>

<meta name="csrf-token" content="{{ csrf_token() }}">

<div>
<body>

<form class="form"  id="CadastroEmpresa" method="post"  action="">


{!! csrf_field() !!}



<div class"container">
  <div class="row">
        <div class="col-md-12">
          <h4> <b>Dados da Empresa </b> </h4>
        </div>
  </div>
    <div class="row">

        <div class="col-md-2">
          <label for="CodEmp">Código </label>
          <div class="input-group">
              <input class="form-control" type="number" id="CodEmp" name="CodEmp"  placeholder="Código" />
              <div class="input-group-btn">
                  <button type="button" class="btn btn-info" onclick="consultarporcodigo()" >
                  <span class="fa fa-search"></span>
            </div>
          </div>
        </div>


    </div>







    <div class="row">
        <div class="col-md-3">
            <label for="CgcMat">* CNPJ da Matriz </label>
            <div class="input-group">
                        <input class="form-control" type="text" id="CgcMat" autocomplete="off"  name="CgcMat"
                           placeholder="CNPJ da Matriz">
                             <div class="input-group-btn">
                               <button  class="btn btn-info" onclick="consultarCgc()">
                                  <span class="fa fa-search"></span>
                                </button>
                           </div>


              </div>
          </div>


    <div class="col-md-5">
          <label for="NomFan">* Nome Fantasia </label>
          <input class="form-control" type="text" id="NomFan" name="NomFan" placeholder="Nome Fantasia" required/>
    </div>
  </div>



    <div class="row">
        <div class="col-md-2">
            <label for="Cep"> Grupo de Empresa</label>
            <input class="form-control" type="text" id="GruEmp" name="GruEmp" 
            placeholder="Grupo de Empresa" />
        </div>
    </div>

    <div class="row">
      <div class="col-md-2">
        <div class="form-group">
            <label for="SitEmp">Situação</label>
            <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="SitEmp" name="SitEmp">
                <option selected value="A">Ativo</option>
                <option value="I">Inativo</option>
            </select>
        </div>
      </div>
  </div>







</div>


  <input type="hidden" name="CodUsu" value="{{ Auth::user()->CodUsu }}">
  <input type="hidden" name="EmpresaLogada" id="EmpresaLogada" value="{{$CodEmp}}">



</div>

<br>
<div class="container-fluid">
      <div class="row">
            <div class="col-md-2">
                  <button type="button" name="btnlimpar"  onclick="LimparFormulario()"  class="btn btn-danger btn-sm custom-button-width"> <i class="fa fa-refresh" aria-hidden="true"></i> Limpar</button>
            </div>
          <div class="col-md-6 text-right">
              <button  name="btnsalvar"   type="button"  onclick="salvar()" class="btn btn-primary btn-sm custom-button-width .navbar-right"><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>
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
      <img src="{{ asset('/img/') }}/carregando.gif" width="200px"  >
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
