@extends('adminlte::page')

@section('title', 'Cronus (ERP)')

@section('content_header')
@stop

@section('css')

<link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

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



    $("#NomPro").focusout(function(){
          document.getElementById('MarPro').disabled = false;
          MarPro.focus();
   });

   $("#MarPro").focusout(function(){
     document.getElementById('Compl1').disabled = false;
     Compl1.focus();
  });

  $("#Compl1").focusout(function(){
    document.getElementById('Compl2').disabled = false;
    Compl2.focus();
 });

 $("#Compl2").focusout(function(){
   VarPro.focus();
});

$("#VarPro").focusout(function(){
  document.getElementById('DesEmb').disabled = false;
  DesEmb.focus();
});




$("#DesEmb").focusout(function(){
  montadescricao();
});

function montadescricao(){
       var DescricaoCompleta = $("#NomPro").val() + " " + $("#MarPro").val() + " " + $("#Compl1").val() + " " + $("#Compl2").val() + " " + $("#DesEmb").val() ;

       document.getElementById('NomPro').disabled = true;
       document.getElementById('MarPro').disabled = true;
       document.getElementById('Compl1').disabled = true;
       document.getElementById('Compl2').disabled = true;
       document.getElementById('DesEmb').disabled = true;

      document.getElementById('DesPro').value = DescricaoCompleta;
      document.getElementById('DesNfe').value = DescricaoCompleta;



}

/*
$(document).ready(function(){
// REMOVER BARRAS DE ROLAGEM
  $("#CadastroCliente").click(function(){
    $("html, body").css({
        'height' : $(window).height() + 'px',
        'width' : $(window).width() + 'px',
        'overflow' : 'hidden'
    });
  });
});*/









function LimparFormulario(){
  $('#EnviarCadastroCliente').each (function(){
      this.reset();
    });



}



//Função Cadastro Realizado com Sucesso



function CadastroRealizado(){

  swal("Registro Salvo com Sucesso"," ", "success");
}

function CadastronaoRealizado(){
  swal ( "Desculpe !","Ocorreu um erro. Tente Novamente" , "error" )   ;
}

function somenteNumeros(num) {
        var er = /[^0-9.]/;
        er.lastIndex = 0;
        var campo = num;
        if (er.test(campo.value)) {
          campo.value = "";
        }
}





 </script>



@stop

@section('content')

<!--Inicio-->
<div class="page-header">

<center>
  <h3> Cadastro de Produtos</h3>
</center>
</div>
<div>
<body >



<form class="form" name="CadastroProdutos" id="EnviarCadastroProdutos" method="post"  >

{!! csrf_field() !!}

<?php if (!empty($_SESSION['type'])) : ?>


    <?php if($_SESSION['type'] == 'sucess') : ?>
         <?php echo $_SESSION['type']; ?>
          <div id="Realizado" class="" onblur="CadastroRealizado()">
            123456
          </div>
    <?php endif; ?>
<?php endif; ?>

     <div class="container">
     			<div id="cadastrocliente">

              <div class="row">
                    <div class="col-md-2">
                      <label for="CodEmp">Código / EAN / GTIN </label>
                      <div class="input-group">
                          <input class="form-control" type="text" id="CodPro" name="CodPro" value="{{isset($consultarfilial->CodCli) ? $consultarfilial->CodCli : ''}}" maxlength="14"  placeholder="Código / EAN / GTIN" onkeyup="somenteNumeros(this);" />
                          <a  href="{{ route('cadastro.cliente','') }}" id="consultaCodigo"></a>
                          <div class="input-group-btn">
                            <button  class="btn btn-info">
                               <span class="fa fa-search"></span>
                             </button>
                           </div>
                         </div>
                       </div>

                       <div class="col-md-6">
                             <label for="DesPro">Descrição </label>
                             <input class="form-control" type="text" id="DesPro" name="DesPro" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="Descrição" style="text-transform: uppercase;" disabled/>
                       </div>


              </div>

              <div class="row">
                <div class="col-md-10">
                  <br>
                      <div class="table-responsive no-padding">
                          <table class="table table table-hover table-bordered">
                                    <thead>
                                    <tr class="table-primary">
                                    <th scope="col">UF</th>
                                    <th scope="col">Aliq. ICMS</th>
                                    <th scope="col">IRPJ</th>
                                    <th scope="col">PIS/PASEP</th>
                                    <th scope="col">Cofins</th>
                                    <th scope="col">IPI</th>
                                    <th scope="col">CSLL</th>
                                    <th scope="col">ISS</th>
                                    <th scope="col">CPP</th>
                                    <th scope="col">Combate a Pobreza</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                              <tr>
                                              <th scope="row">AC</th>
                                                    <td><input type="text"  name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                              </tr>
                                              <tr>
                                              <th scope="row">AL</th>
                                                    <td><input type="text"  name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                                    <td><input type="text" name="icms"></td>
                                              </tr>
                                              <tr>
                                              <th scope="row">AP</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">AM</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">BA</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">CE</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">DF</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">ES</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">GO</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">MA</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">MT</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">MS</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">MG</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">PA</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">PB</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">PR</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">PE</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">PI</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">RJ</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">RN</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">RS</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">RO</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">RR</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">SC</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">SP</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">SE</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>
                                              <tr>
                                              <th scope="row">TO</th>
                                              <td colspan="2"></td>
                                              <td>@twitter</td>
                                              </tr>

                                    </tbody>
                            </table>
                          </div>
                          </div>
                        </div>



</div>
    <input type="hidden" name="CodUsu" value="{{ Auth::user()->CodUsu }}">
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
      <img src="/img/carregando.gif" width="200px"  >
    </center>
    </div>
  </div>
</div>

@stop
