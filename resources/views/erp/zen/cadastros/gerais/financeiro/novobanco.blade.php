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
<script src="{{ asset('js/jquery.mask.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

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
	$(':input[name=CgcBan]').mask(CpfCnpjMaskBehavior, cpfCnpjpOptions);
})


function ConvertFormToJSON(form){
            var array = jQuery(form).serializeArray();
            var json = {};

            jQuery.each(array, function() {
                    json[this.name] = this.value || '';
            });

            
            return json;
}



function consultar(){
        var Banco = $('#CodBan').val();

        var dadosajax = {
                        "_token": "{{ csrf_token() }}",
                        'CodBan' : Banco,
        }


        $.ajax({
            

                    type: "GET",
                    dataType : "json",
                    data : dadosajax,
                    
                    url: "/consulta/banco/"+{CodBan:Banco},
                
                success: function(Retorno) {
                        var status = (Retorno.Status);

                        if(status == 'OK'){
                            
                            $('#NomFan').val(Retorno.NomFan);
                            $('#CgcBan').val(Retorno.CgcBan);
                           
                          
                        } 

                }
      });

}


function salvar(){

    var json = ConvertFormToJSON("#CadastroBanco");
    var Form = this;

    $.ajax({

            type: "POST",
            dataType : "json",
            data : json,
            context : Form,
            url: "/novo/banco",
            success: function(Retorno) {
                var status = (Retorno.Status);
                var Msg = (Retorno.Msg);

                if(status == 'OK'){
                    swal(Msg," ", "success");
                    LimparFormulario();
                } else if(status =='Er'){
                    swal(Msg," ", "error");
                }
               


            }


    });

    

}

function LimparFormulario(){
  $('#CadastroBanco').each (function(){
        this.reset();
    });
}



$("#CodBan").focusout(function(){    
    consultar();
});

 </script>



@stop

@section('content')

<!--Inicio-->
<center>
  <h3> Cadastro de Banco</h3>
</center>



<div>
<body>

<form class="form"  id="CadastroBanco" method="post"  action="">


{!! csrf_field() !!}




<div class"container">
  
    <div class="row">

        <div class="col-md-2">
          <label for="CodBan">* Banco </label>
          <div class="input-group">
              <input class="form-control" type="number" id="CodBan" name="CodBan" placeholder="Código" />
              <div class="input-group-btn">
                  <button type="button" class="btn btn-info" onclick="consultar()" >
                  <span class="fa fa-search"></span>
            </div>
          </div>
        </div>


    </div>


    <div class="row">
			<div class="col-md-5">
						<label for="NomFan">* Nome  </label>
						<input class="form-control" type="text" id="NomFan" name="NomFan" placeholder="Razão Social" required/>
			</div>

   </div>





    <div class="row">
                <div class="col-md-2">
                    <label for="CgcBan">* Cnpj </label>
                    <input class="form-control" type="text" id="CgcBan" name="CgcBan" placeholder="CNPJ"  />
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
              <button  name="btnsalvar"   type="button" class="btn btn-primary btn-sm custom-button-width .navbar-right" onclick="salvar()"><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>
           </div>
      </div>
</div>

</form>
</div>
</div>
</div>



@stop
