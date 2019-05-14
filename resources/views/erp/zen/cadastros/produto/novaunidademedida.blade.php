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

<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script type="text/javascript">





function LimparFormulario(){
  $('#EnviarCadastroDepartamento').each (function(){
      this.reset();
    });

}

// Enviar Cadastro Via Ajax sem Jquery

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function salvar(){
	//var data = {}
                var json = ConvertFormToJSON("#EnviarCadastroDepartamento");
                var Form = this;
 $('#myModal').modal('show');
	$.ajax({

			type: "POST",
			dataType : "json",
		  data : json,
		  context : Form,
			url: "/cadastro/departamento",
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



function ConvertFormToJSON(form){
					 console.log('ConvertFormToJSON invoked!');
					 var array = jQuery(form).serializeArray();
					 var json = {};

					 jQuery.each(array, function() {
							 json[this.name] = this.value || '';
					 });

					 console.log('JSON: '+json);
					 return json;
			 }








 </script>



@stop

@section('content')

<!--Inicio-->
<center>
  <h3> Cadastro de Departamento/Seção</h3>
</center>

<meta name="csrf-token" content="{{ csrf_token() }}">

<div>
<body>

<form class="form"  id="EnviarCadastroDepartamento" method="post"  action="">


{!! csrf_field() !!}

<div class"container">

    <div class="row">

        <div class="col-md-2">
          <label for="CodDep">Código</label>
          <div class="input-group">
              <input class="form-control" type="text" id="CodUni" name="CodUni" placeholder="Código" />
              <div class="input-group-btn">
                  <button type="button" class="btn btn-info" >
                  <span class="glyphicon glyphicon-search"></span>
            </div>
          </div>
        </div>


    </div>


    <div class="row">
        <div class="col-md-6">
              <label for="NomDep">* Descrição  </label>
              <input class="form-control" type="text" id="NomUni" name="NomUni" placeholder="Descrição" required/>
        </div>
  </div>




    <div class="row">
      <div class="col-md-2">
        <div class="form-group">
            <label for="SitDep">Situação</label>
            <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="SitDep" name="SitDep" >
                <option selected value="A">Ativo</option>
                <option value="I">Inativo</option>
            </select>
        </div>
      </div>
  </div>







</div>


  <input type="hidden" name="CodUsu" value="{{ Auth::user()->CodUsu }}">



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


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class=" modal-dialog modal-sm  modal-dialog-centered" role="document">
    <div class="modal-content">
      <center>
      <img src="/img/carregando.gif" width="200px"  >
    </center>
    </div>
  </div>
</div>

</form>
</div>
</div>
</div>


<

@stop
