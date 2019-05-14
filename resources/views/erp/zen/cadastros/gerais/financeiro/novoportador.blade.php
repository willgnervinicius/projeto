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

$(document).ready(function(){
  ConsultaBanco();

});
function ConvertFormToJSON(form){
            var array = jQuery(form).serializeArray();
            var json = {};

            jQuery.each(array, function() {
                    json[this.name] = this.value || '';
            });

            
            return json;
}

function resetaCombo( el ){
    		$("select[name='"+el+"']").empty();//retira os elementos antigos
    		var option = document.createElement('option');
    	
}

function ConsultaBanco(){
      var json = ConvertFormToJSON("#CadastroPortador");
      var Form = this;

                $.ajax({


                    type: "GET",
                    dataType : "json",
                    data : json,
                    context : Form,
                    url: "/consulta/cadastro/banco/"+{CodBan:237},

                    success: function(RetornaBanco) {
                        var status = (RetornaBanco.Status);

                        
                             var option = new Array();//resetando a variável

                              resetaCombo('CodBan');//resetando o combo
                              $.each(RetornaBanco, function(i, obj){

                                option[i] = document.createElement('option');//criando o option
                                $( option[i] ).attr( {value : obj.CodBan} );//colocando o value no option
                                $( option[i] ).append( obj.CodBan + '-' + obj.NomFan );//colocando o 'label'

                                $("select[name='CodBan']").append( option[i] );//jogando um à um os options no próximo combo
                              });

                            
                        

                    }


                });

}

function consultar(){
        var Portador = $('#CodPor').val();

        var dadosajax = {
                        "_token": "{{ csrf_token() }}",
                        'CodPor' : Portador,
        }


        $.ajax({
            

                    type: "GET",
                    dataType : "json",
                    data : dadosajax,
                    
                    url: "/consulta/portador/"+{CodPor:Portador},
                
                success: function(Retorno) {
                        var status = (Retorno.Status);

                        if(status == 'OK'){
                            var GeraRemessa = Retorno.GerRem;

                            if(GeraRemessa == 'N'){
                                $('#NumCta').prop('readonly', true);
                                $('#AgeCta').prop('readonly', true);
                                $('#CtlRem').prop('readonly', true);
                            } else if(GeraRemessa =='S'){
                                $('#NumCta').prop('readonly', false);
                                $('#AgeCta').prop('readonly', false);
                                $('#CtlRem').prop('readonly', false);
                            }

                            $('#NomPor').val(Retorno.DesPor);
                            $('#CodBan').val(Retorno.CodBan);
                            $('#AgeCta').val(Retorno.AgeCta);
                            $('#NumCta').val(Retorno.NumCta);
                            $('#SitPor').val(Retorno.SitPor);
                            $('#GerRem').val(Retorno.GerRem);
                            $('#CtlRem').val(Retorno.CtlRem);
                        } 

                }
      });

}


function salvar(){

    var json = ConvertFormToJSON("#CadastroPortador");
    var Form = this;

    $.ajax({

            type: "POST",
            dataType : "json",
            data : json,
            context : Form,
            url: "/novo/portador",
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
  $('#CadastroPortador').each (function(){
        this.reset();
        $('#NumCta').prop('readonly', false);
        $('#AgeCta').prop('readonly', false);
        $('#CtlRem').prop('readonly', false);
    });
}

$("#GerRem").focusout(function(){ 
    var GeraRemessa =   $("#GerRem").val();
    
    if (GeraRemessa == 'N'){
        $('#NumCta').prop('readonly', true);
        $('#AgeCta').prop('readonly', true);
        $('#CtlRem').prop('readonly', true);
    }
    
});

$("#CodPor").focusout(function(){    
    consultar()
});

 </script>



@stop

@section('content')

<!--Inicio-->
<center>
  <h3> Cadastro de Portador</h3>
</center>



<div>
<body>

<form class="form"  id="CadastroPortador" method="post"  action="">


{!! csrf_field() !!}




<div class"container">
  
    <div class="row">

        <div class="col-md-2">
          <label for="CodEmp">* Portador </label>
          <div class="input-group">
              <input class="form-control" type="number" id="CodPor" name="CodPor" placeholder="Código" />
              <div class="input-group-btn">
                  <button type="button" class="btn btn-info" onclick="consultar()" >
                  <span class="fa fa-search"></span>
            </div>
          </div>
        </div>


    </div>


    <div class="row">
			<div class="col-md-5">
						<label for="NomPor">* Nome Portador </label>
						<input class="form-control" type="text" id="NomPor" name="NomPor" placeholder="Nome Completo / Razão Social" required/>
			</div>

   </div>

   <div class="row">


        <div class="col-md-3">
                        <div class="form-group">
                            <label for="CodBan">* Banco</label>
                            <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="CodBan" name="CodBan" required>
                                <option selected  disabled value="SE">Selecione...</option>
                            </select>
                        </div>
          </div>


        <div class="col-md-2">
             <label for="CodEmp">** Agência </label>
              <input class="form-control" type="text" id="AgeCta" name="AgeCta" placeholder="Agência"/>
        </div>

        <div class="col-md-2">
             <label for="CodEmp">** Conta </label>
              <input class="form-control" type="text" id="NumCta" name="NumCta" placeholder="Conta"  />
        </div>


    </div>

    <div class="row">
				<div class="col-md-2">
					<div class="form-group">
							<label for="GerRem">* Gera Remessa</label>
							<select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="GerRem" name="GerRem" required>
									<option selected value="S">Sim</option>
									<option value="N">Não</option>
							</select>
					</div>
				</div>

                <div class="col-md-2">
                    <label for="CtlRem">** Controle Remessa </label>
                    <input class="form-control" type="text" id="CtlRem" name="CtlRem" placeholder="Controle Remessa"  />
                </div>

                <div class="col-md-3">
                        <div class="form-group">
                            <label for="ModRem">* Modelo Remessa </label>
                            <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="ModRem" name="ModRem" >
                                <option selected  selected  value="NG">Não Gera Remessa</option>
                            </select>
                        </div>
          </div>
		</div>


    

		<div class="row">
				<div class="col-md-2">
					<div class="form-group">
							<label for="SitPor">Situação</label>
							<select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="SitPor" name="SitPor" required>
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
              <button  name="btnsalvar"   type="button" class="btn btn-primary btn-sm custom-button-width .navbar-right" onclick="salvar()"><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>
           </div>
      </div>
</div>

</form>
</div>
</div>
</div>



@stop
