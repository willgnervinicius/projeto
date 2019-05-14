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
<script src="{{ asset('js/jquery.mask.js') }}"></script>

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
	$(':input[name=CgcCpf]').mask(CpfCnpjMaskBehavior, cpfCnpjpOptions);
})

function ConvertFormToJSON(form){
					 
					 var array = jQuery(form).serializeArray();
					 var json = {};

					 jQuery.each(array, function() {
							 json[this.name] = this.value || '';
					 });

					 
					 return json;
	}


function LimparFormulario(){
  $('#CadastroUsuario').each (function(){
      this.reset();
    });


   

}


function salvar(){
	//var data = {}
    var json = ConvertFormToJSON("#CadastroUsuario");
    var Form = this;
  
    
	$.ajax({

			type: "POST",
			dataType : "json",
		  data : json,
		  context : Form,
			url: "/cadastro/usuario",
			success: function(Retorno) {
				var status = (Retorno.Status);

        
				

			  if (status =="OK") {
					 var Msg = (Retorno.Msg);
             swal(Msg," ", "success");
						 LimparFormulario();
				}else {
          var Msg = (Retorno.Msg);
             swal(Msg," ", "error");
				}
			}


	});

};




  

 </script>



@stop

@section('content')

<!--Inicio-->
<center>
  <h3> Cadastro de Usuário</h3>
</center>



<div>
<body>

<form class="form"  id="CadastroUsuario" method="post"  action="">


{!! csrf_field() !!}



<div class"container">
  <div class="row">
        <div class="col-md-12">
          <h4> <b>Dados do Usuário </b> </h4>
        </div>
  </div>
    <div class="row">

        <div class="col-md-2">
          <label for="CodEmp">Código </label>
          <div class="input-group">
              <input class="form-control" type="number" id="CodUsu" name="CodUsu" placeholder="Código" />
              <div class="input-group-btn">
                  <button type="button" class="btn btn-info" >
                  <span class="fa fa-search"></span>
            </div>
          </div>
        </div>


    </div>

    <div class="row">
      <div class="col-md-6">
            <label for="NomFan">* Nome  / Razão Social </label>
            <input class="form-control" type="text" id="NomUsu" name="NomUsu" placeholder="Nome  / Razão Social" required/>
      </div>
    </div>






    <div class="row">
        <div class="col-md-3">
            <label for="GruEmp">* CNPJ / CPF </label>
            <div class="input-group">
                        <input class="form-control" type="text" id="CgcCpf" autocomplete="off"  name="CgcCpf"
                           placeholder="CPF/CNPJ">
                             <div class="input-group-btn">
                               <button  class="btn btn-info">
                                  <span class="fa fa-search"></span>
                                </button>
                           </div>


              </div>
          </div>
  </div>

  <div class="row">


        <div class="col-md-6">
          <label for="IntNet">E-mail </label>
          <input class="form-control" type="email" id="IntNet" name="IntNet" placeholder="E-mail" />

        </div>
  </div>

 

</div>


 



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
