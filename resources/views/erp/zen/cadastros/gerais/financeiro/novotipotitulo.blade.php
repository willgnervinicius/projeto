@extends('adminlte::page')

@section('title', 'Cronus (ERP) - Cadastro de Tipo de Título')

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




function ConvertFormToJSON(form){
            var array = jQuery(form).serializeArray();
            var json = {};

            jQuery.each(array, function() {
                    json[this.name] = this.value || '';
            });

            
            return json;
}



function consultar(){
        var Tipo = $('#CodTip').val();

        var dadosajax = {
                        "_token": "{{ csrf_token() }}",
                        'CodTip' : Tipo,
        }

        if(Tipo == ''){
            return false;
            $('#CodTip').focus();
        }


        $.ajax({
            

                    type: "GET",
                    dataType : "json",
                    data : dadosajax,
                    
                    url: "/consulta/tipo/titulo/"+{CodTip:Tipo},
                
                success: function(Retorno) {
                        var status = (Retorno.Status);

                       if(status == 'OK'){
                            
                            $('#NomTip').val(Retorno.NomTip);
                            $('#ModTip').val(Retorno.ModTip);
                            $('#ForPgt').val(Retorno.ForPgt);
                           
                          
                        } 

                }
      });

}


function salvar(){

    var json = ConvertFormToJSON("#CadastroTipo");
    var Form = this;

    $.ajax({

            type: "POST",
            dataType : "json",
            data : json,
            context : Form,
            url: "/novo/tipo/titulo",
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
  $('#CadastroTipo').each (function(){
        this.reset();
    });
}



$("#CodTip").focusout(function(){    
    consultar()
});

 </script>



@stop

@section('content')

<!--Inicio-->
<center>
  <h3> Cadastro de Tipo de Título </h3>
</center>



<div>
<body>

<form class="form"  id="CadastroTipo" method="post"  action="">


{!! csrf_field() !!}




<div class"container">
  
    <div class="row">

        <div class="col-md-2">
          <label for="CodTip">* Tipo </label>
          <div class="input-group">
              <input class="form-control" type="text" id="CodTip" name="CodTip" placeholder="Código" style="text-transform: uppercase;" />
              <div class="input-group-btn">
                  <button type="button" class="btn btn-info" onclick="consultar()" >
                  <span class="fa fa-search"></span>
            </div>
          </div>
        </div>


    </div>


    <div class="row">
			<div class="col-md-5">
						<label for="NomTip">* Nome  </label>
						<input class="form-control" type="text" id="NomTip" name="NomTip" placeholder="Nome " required/>
			</div>

   </div>





   <div class="row">
        <div class="col-md-2">
          <div class="form-group">
              <label for="ModTip">Módulo</label>
              <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="ModTip" name="ModTip" required>
                  <option selected value="R">Contas a Receber </option>
                  <option value="P">Contas a Pagar</option>
                  <option value="A">Contas a Pagar e Receber</option>
              </select>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
          <div class="form-group">
              <label for="ForPgt">Forma de Pagamento</label>
              <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="ForPgt" name="ForPgt" required>
                  <option  value="01">Dinheiro </option>
                  <option value="02">Cheque</option>
                  <option value="03">Cartão de Crédito</option>
                  <option value="04">Cartão de Débito</option>
                  <option value="05">Crédito Loja</option>
                  <option value="10">Vale Alimentação</option>
                  <option value="11">Vale Refeição</option>
                  <option value="12">Vale Presente</option>
                  <option value="13">Vale Combustível</option>
                  <option value="15" selected>Boleto Bancário</option>
                  <option value="90" disabled>Sem Pagamento</option>
                  <option value="99">Outros</option>
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
