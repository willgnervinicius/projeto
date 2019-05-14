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
<script src="{{ asset('js/bootstrap.min.js') }}"></script>>
<script src="{{ asset('js/jquery.maskedinput.js') }}"></script>
<script src="{{ asset('js/jquery.maskMoney.js') }}"></script>

<script type="text/javascript">

  $("#CodPro").focusout(function(){
      var CodPro = document.getElementById('CodPro').value;
      ConsultarProduto(CodPro);

  });

   
















function LimparFormulario(){
  $('#EnviarCadastroProdutos').each (function(){
      this.reset();
    });



}

function validar(){
  var DepartamentoSelecionado = $('#CodDep').val();
  var GrupoSelecionado = $('#CodGru').val();
  var SubGrupoSelecionado = $('#CodSub').val();
  var Produto = $('#CodPro').val();
  var Descricao =  $('#DesPro').val();
  var Embalagem =  $('#DesEmb').val();
  var DescricaoNota =  $('#DesNfe').val();




  if ((DepartamentoSelecionado == '0') || (DepartamentoSelecionado =='null'))  {
      swal('Advertência'," Selecione um Departamento", "error");
  } else if ((GrupoSelecionado =='0') || (GrupoSelecionado =='9999999999')){
      swal('Advertência'," Selecione um Grupo", "error");
  } else if ((SubGrupoSelecionado =='0') || (SubGrupoSelecionado =='9999999999')){
      swal('Advertência'," Selecione um SubGrupo", "error");
  }else if((Produto == '') || (Descricao == '')  || (Embalagem ='') || (DescricaoNota == '') ) {
          swal('Advertência'," Campos com * são Obrigatórios", "error");
  } else{
    salvar();
  }






}




function salvar(){
	//var data = {}
    var json = ConvertFormToJSON("#EnviarCadastroProdutos");
    var Form = this;


    //9999999999
 $('#myModal').modal('show');
	$.ajax({

			type: "POST",
			dataType : "json",
		  data : json,
		  context : Form,
			//data: {CgcMat: $("#CgcMat").val()},
			url: "/novo/produto",
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

window.CodDep = "";

function ConsultarProduto(CodPro){
  //var data = {}
  var json = ConvertFormToJSON("#EnviarCadastroProdutos");
  var Form = this;
  var CodigoProduto = CodPro;
$('#myModal').modal('show');

	$.ajax({


			type: "GET",
			dataType : "json",
		  data : json,
		  context : Form,
			//data: {CgcMat: $("#CgcMat").val()},
			url: "/consulta/cadastro/produto/" + {CodPro: CodigoProduto} ,

			success: function(RetornaProduto) {
            var status = (RetornaProduto.Status);
            var DesPro = (RetornaProduto.DesPro);
            var DesEmb = (RetornaProduto.DesEmb);
            var UniMed = (RetornaProduto.UniMed);
            var TipPro = (RetornaProduto.TipPro);
            var TipMer = (RetornaProduto.TipMer);
            var CtlEst = (RetornaProduto.CtlEst);
             CodDep = (RetornaProduto.CodDep);
            var CodGru = (RetornaProduto.CodGru);
            var CodSub = (RetornaProduto.CodSub);
             var DesNfe = (RetornaProduto.DesNfe);
             var SitPro = (RetornaProduto.SitPro);



            if (status =="Ok") {
              document.getElementById('DesPro').value = DesPro;
              document.getElementById('DesEmb').value = DesEmb;
              document.getElementById('UniMed').value = UniMed;
              document.getElementById('TipPro').value = TipPro;
              document.getElementById('TipMer').value = TipMer;
              document.getElementById('CtlEst').value = CtlEst;
              document.getElementById('CodDep').value = CodDep;
              document.getElementById('DesNfe').value = DesNfe;
              document.getElementById('SitPro').value = SitPro;

              resetaCombo('CodGru');//resetando o combo
              resetaCombo('CodSub');//resetando o combo





            }

//7895000318483


consultaGrupoProduto(CodDep,CodGru,CodSub);


			}




	});


	 $('#myModal').modal('hide');


}


//Função Cadastro Realizado com Sucesso

function consultaGrupoProduto(CodDep,CodGru,CodSub){
    var CodDep1 = CodDep;
    var CodGru1 = CodGru;
    var CodSub1 = CodSub;

    var json = ConvertFormToJSON("#EnviarCadastroProdutos");
    var Form = this;

    $.ajax({


  			type: "GET",
  			dataType : "json",
  		  data : json,
  		  context : Form,
  			//data: {CgcMat: $("#CgcMat").val()},
  			url: "/novo/produto/grupo/" + {CodDep: CodDep1} ,

  			success: function(RetornoGrupo) {
          var option = new Array();//resetando a variável

   					resetaCombo('CodGru');//resetando o combo
   					$.each(RetornoGrupo, function(i, obj){

   						option[i] = document.createElement('option');//criando o option
   						$( option[i] ).attr( {value : obj.CodGru} );//colocando o value no option
   						$( option[i] ).append( obj.NomGru );//colocando o 'label'

   						$("select[name='CodGru']").append( option[i] );//jogando um à um os options no próximo combo
   				});

           document.getElementById('CodGru').value = CodGru1;
            consultaSubGrupoProduto(CodGru,CodSub);
  			}

  	});





}


function consultaSubGrupoProduto(CodGru,CodSub){
  var CodGru1 = CodGru;
  var CodSub1 = CodSub;

  var json = ConvertFormToJSON("#EnviarCadastroProdutos");
  var Form = this;


  $.ajax({


      type: "GET",
      dataType : "json",
      data : json,
      context : Form,
      //data: {CgcMat: $("#CgcMat").val()},
      url: "/novo/produto/subgrupo/" + {CodGru: CodGru1} ,

      success: function(RetornoSubGrupo) {
        var option = new Array();//resetando a variável


          $.each(RetornoSubGrupo, function(i, obj){

            option[i] = document.createElement('option');//criando o option
            $( option[i] ).attr( {value : obj.CodSub} );//colocando o value no option
            $( option[i] ).append( obj.NomSub );//colocando o 'label'

            $("select[name='CodSub']").append( option[i] );//jogando um à um os options no próximo combo
        });

           document.getElementById('CodSub').value = CodSub1;
      }


  });

  $('#NomPro').focus();


}



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

jQuery("#CodDep").change(function(){
      var CodDep = jQuery(this).val();
      resetaCombo('CodGru');//resetando o combo
      resetaCombo('CodSub');//resetando o combo
       consultargrupo(CodDep);
    });

function consultargrupo(CodDep){
	//var data = {}
  var json = ConvertFormToJSON("#EnviarCadastroProdutos");
  var Form = this;
  var CodigoDepartamento = CodDep;
$('#myModal').modal('show');

	$.ajax({


			type: "GET",
			dataType : "json",
		  data : json,
		  context : Form,
			//data: {CgcMat: $("#CgcMat").val()},
			url: "/novo/produto/grupo/" + {CodDep: CodigoDepartamento} ,

			success: function(RetornoGrupo) {
        var option = new Array();//resetando a variável

 					resetaCombo('CodGru');//resetando o combo
 					$.each(RetornoGrupo, function(i, obj){

 						option[i] = document.createElement('option');//criando o option
 						$( option[i] ).attr( {value : obj.CodGru} );//colocando o value no option
 						$( option[i] ).append( obj.NomGru );//colocando o 'label'

 						$("select[name='CodGru']").append( option[i] );//jogando um à um os options no próximo combo
 				});


			}


	});

	 $('#myModal').modal('hide');


};





jQuery("#CodGru").change(function(){
          var CodGru = jQuery(this).val();
          resetaCombo('CodSub');//resetando o combo
          consultarsubgrupo(CodGru);
});


function consultarsubgrupo(CodGru){
        	//var data = {}
          var json = ConvertFormToJSON("#EnviarCadastroProdutos");
          var Form = this;
          var CodigoSubGrupo = CodGru;
        $('#myModal').modal('show');

        	$.ajax({


        			type: "GET",
        			dataType : "json",
        		  data : json,
        		  context : Form,
        			//data: {CgcMat: $("#CgcMat").val()},
        			url: "/novo/produto/subgrupo/" + {CodGru: CodigoSubGrupo} ,

        			success: function(RetornoSubGrupo) {
                var option = new Array();//resetando a variável


         					$.each(RetornoSubGrupo, function(i, obj){

         						option[i] = document.createElement('option');//criando o option
         						$( option[i] ).attr( {value : obj.CodSub} );//colocando o value no option
         						$( option[i] ).append( obj.NomSub );//colocando o 'label'

         						$("select[name='CodSub']").append( option[i] );//jogando um à um os options no próximo combo
         				});


        			}


        	});

        	 $('#myModal').modal('hide');


        };


        function resetaCombo( el )
    	{
    		$("select[name='"+el+"']").empty();//retira os elementos antigos
    		var option = document.createElement('option');
    		$( option ).attr( {value : '0'} );
    		$( option ).append( 'Selecione' );
    		$("select[name='"+el+"']").append( option );
    	}



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
<div class="page-header">

<center>
  <h3> Cadastro de Produtos</h3>
</center>
</div>
<div>
<body >



<form class="form" name="CadastroProdutos" id="EnviarCadastroProdutos" method="post"  >

{!! csrf_field() !!}



     <div class="container">
     			<div id="CadastroProdutos">

              <div class="row">
                    <div class="col-md-2">
                      <label for="CodEmp">*Código / EAN / GTIN </label>
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
                          <label for="DesPro">*Descrição </label>
                          <input class="form-control" type="text" id="DesPro" name="DesPro"  placeholder="Descrição" style="text-transform: uppercase;" />
                    </div>
              </div>

    


             <div class="row">


               <div class="col-md-2">
                       <label for="DesEmb">*Descrição Embalagem</label>
                       <input class="form-control" type="text" id="DesEmb" name="DesEmb"  placeholder="Descrição Embalagem" style="text-transform: uppercase;"   />
               </div>
                  <div class="col-md-2">
                      <div class="form-group">
                                        <label for="UniMed">*Unidade Medida</label>
                                        <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="UniMed" name="UniMed" required>
                                            <option value="UN" selected >UN - Unidade</option>
                                            <option value="CT">CT - Cartela</option>
                                            <option value="DZ">DZ - Duzia</option>
                                            <option value="CX">CX - Caixa</option>
                                            <option value="KG">KG - Kilograma</option>
                                            <option value="LT">LT - Litros</option>
                                        </select>
                      </div>
                  </div>


            </div>

            <div class="row">
              <div class="col-md-2">
                  <div class="form-group">
                      <label for="TipPro">*Tipo Produção</label>
                      <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="TipPro" name="TipPro" >
                          <option  value="P" selected>Própria</option>
                          <option value="T">Terceiro</option>
                      </select>
                   </div>
                </div>

                   <div class="col-md-2">
                       <div class="form-group">
                           <label for="TipMer">*Tipo Produto</label>
                           <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="TipMer" name="TipMer" >
                               <option value="R" selected>Revenda</option>
                               <option value="C">Consumo</option>
                               <option value="A">Consumo / Revenda </option>
                           </select>
                        </div>
                     </div>

                     <div class="col-md-2">
                         <div class="form-group">
                             <label for="CtlEst">*Controla Estoque</label>
                             <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="CtlEst" name="CtlEst" >
                                 <option value="S" selected >Sim</option>
                                 <option value="N">Não</option>
                             </select>
                          </div>
                       </div>

            </div>


            <div class="row">
              <div class="col-md-3">
                  <div class="form-group">
                      <label for="CodDep">*Depto / Seção </label>
                      <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="CodDep" name="CodDep" onkeydown="consultargrupo()"> >
                          <option selected value="0" > Selecione </option>
                          @if(isset($listaDept))
                          @foreach($listaDept as $dadosdepartamento)
                                   <option value="{{$dadosdepartamento -> CodDep}}"> {{$dadosdepartamento -> NomDep}} </option>
                         @endforeach
                         @endif
                      </select>
                   </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="CodGru">*Grupo</label>
                        <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="CodGru" name="CodGru" >
                            <option selected disabled value="0" > Selecione </option>

                        </select>
                     </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="CodSub">*SubGrupo</label>
                          <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="CodSub" name="CodSub" >
                              <option selected disabled value="0" > Selecione </option>
                          </select>
                       </div>
                    </div>
             </div>

            <div class="row">

            </div>


              <div class="row">
                <div class="col-md-8">
                      <label for="DesNfe">*Descrição Nota NF-e / NFC-e / S@T </label>
                      <input class="form-control" type="text" id="DesNfe" name="DesNfe" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="Descrição" style="text-transform: uppercase;" required/>
                </div>
             </div>

              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                      <label for="SitPro">Situação</label>
                      <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="SitPro" name="SitPro" required>
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
                                    <button  name="btnsalvar"  onclick="validar()" type="button" class="btn btn-primary btn-sm custom-button-width .navbar-right"><i class="fa fa-check" aria-hidden="true"></i>  Salvar</button>
                                 </div>
                            </div>




 </div>
     		</div>


</div>
    <input type="hidden" name="CodUsu" value="{{ Auth::user()->CodUsu }}">
    <input type="hidden" name="CodEmp" value="{{$CodEmp}}">
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
