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
<script src="{{ asset('js/jquery.maskedinput.js') }}"></script>
<script src="{{ asset('js/jquery.maskMoney.js') }}"></script>


<script type="text/javascript">

  $("#CodPro").focusout(function(){
      var CodPro = document.getElementById('CodPro').value;
      consultarProduto(CodPro);

  });


  $("#VlrIpi").maskMoney({
         decimal: ",",
         thousands: ".",
         precision: 3
     });

  $("#VlrPis").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 3
  });
  $("#VlrCof").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 3
  });
  $("#RedIcm").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 5
  });
  $("#RedIst").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 5
  });
  $("#AliIcm").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 2
  });
  $("#AliIpi").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 2
  });
  $("#TriFed").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 2
  });
  $("#TriMun").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 2
  });
  $("#TriEst").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 2
  });
  $("#AliFcp").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 2
  });
  $("#AliMva").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 2
  });


function LimparFormulario(){
  $('#EnviarCadastroTributacao').each (function(){
      this.reset();
    });
}

function validar(){
    var CodPro = $('#CodPro').val();
    var OriPro = $('#CodOri').val();
    var CodTns = $('#CodTns').val();
    var CodCst = $('#CodCst').val();
    var CstIpi = $('#CstIpi').val();
    var CstPis = $('#CstPis').val();
    var CstCof = $('#CstCof').val();
    var TipIpi = $('#TipIpi').val();
    var TipPis = $('#TipPis').val();
    var TipCof = $('#TipCof').val();
    var AliIcm = $('#AliIcm').val();
    var AliIpi = $('#AliIpi').val();
    var CodNcm = $('#CodNcm').val();
    var CodCes = $('#CodCes').val();

    var VlrIpi = $('#VlrIpi').val();
    var VlrPis = $('#VlrPis').val();
    var VlrCof = $('#VlrCof').val();

    var AliMva = $('#AliMva').val();
    var TriFed = $('#TriFed').val();
    var TriMun = $('#TriMun').val();
    var CodCsn = $('#CodCsn').val();
    var AliFcp = $('#AliFcp').val();
    var BasIcm = $('#BasIcm').val();
    var BasISt = $('#BasISt').val();







    if ((OriPro == '99999')|| (OriPro == null))  {
        swal('Advertência'," Selecione a Origem do Produto", "error");
    }
    else if ((CodCst == '99999') || (CodCst == null))  {
        swal('Advertência'," Selecione o CST do Produto", "error");
    }
    else if ( (CodCst == '10') || (CodCst == '30') || (CodCst == '70') && ((AliMva == '') || (AliMva == null))){
        swal('Advertência',"Informe a Aliquota MVA para Cálculo da Substituição Tributária", "error");
    }
    else if ((CstIpi == '99999')|| (CstIpi == null))  {
        swal('Advertência'," Selecione o CST IPI do Produto", "error");
    }
    else if ((CstPis == '99999')|| (CstPis == null))  {
        swal('Advertência'," Selecione o CST PIS do Produto", "error");
    }
    else if ((CstCof == '99999')|| (CstCof == null))  {
        swal('Advertência',"Selecione o CST Cofins do Produto", "error");
    }
    else if ((TipIpi == '99999')|| (TipIpi == null))  {
        swal('Advertência',"Selecione o Tipo de Cálculo do IPI ", "error");
    }
    else if ((TipIpi == '0') &&  ((AliIpi == null) || (AliIpi == '0')|| (AliIpi == ''))){
          swal('Advertência',"Informe a Aliquota do IPI", "error");
    }
    else if ((TipIpi == '1') &&  ((VlrIpi == null) || (VlrIpi == '0')|| (VlrIpi == ''))){
          swal('Advertência',"Informe o valor unitário do Produto para Cálculo do IPI", "error");
    }
    else if ((TipPis == '99999')|| (TipPis == null))  {
        swal('Advertência',"Selecione o Tipo de Cálculo do PIS", "error");
    }
    else if ((TipPis == '1') &&  ((VlrPis == null) || (VlrPis == '0')|| (VlrPis == ''))){
          swal('Advertência',"Informe o valor unitário do Produto para Cálculo do PIS", "error");
    }
     else if ((TipCof == '99999')|| (TipCof == null))  {
        swal('Advertência',"Selecione o Tipo de Cálculo do Cofins", "error");
    }
    else if ((TipCof == '1') &&  ((VlrCof == null) || (VlrCof == '0')|| (VlrCof == ''))){
          swal('Advertência',"Informe o valor unitário do Produto para Cálculo do Cofins", "error");
    }
    else if ((CodCsn == '99999')|| (CodCsn == null))  {
       swal('Advertência',"Selecione o CSOSN", "error");
   }
   else if ((BasIcm == '99999')|| (BasIcm == null))  {
      swal('Advertência',"Selecione o Mod Base Cálculo ICMS", "error");
   }
    else if ((BasISt == '99999')|| (BasISt == null))  {
     swal('Advertência',"Selecione o Mod Base Cálculo ICMS", "error");
  }
    else if((CodPro =='') || (CodTns=='') || (AliIcm =='')|| (CodNcm =='')|| (CodCes =='')|| (TriFed =='')|| (TriEst =='')|| (AliFcp =='')){
      swal('Advertência'," Campos com * são Obrigatórios", "error");
    }else {
      salvar();
    }
}




function salvar(){
	//var data = {}
    var json = ConvertFormToJSON("#EnviarCadastroTributacao");
    var Form = this;


    //9999999999
 $('#myModal').modal('show');
	$.ajax({

			type: "POST",
			dataType : "json",
		  data : json,
		  context : Form,
			url: "/cadastro/tributacao/produto",
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




//Função Cadastro Realizado com Sucesso
function CadastronaoRealizado(){
  swal ( "Desculpe !","Ocorreu um erro. Tente Novamente" , "error" )   ;
}

//Somente Numeros
function somenteNumeros(num) {
        var er = /[^0-9.]/;
        er.lastIndex = 0;
        var campo = num;
        if (er.test(campo.value)) {
          campo.value = "";
        }
}

//Validações Formulario (Pagina)
$("#CodTns").change(function(){
     var CodigoCfop = $("#CodTns").val();
     consultarCFOP(CodigoCfop);
});

$("#TipIpi").change(function(){
     var TipoIPI = $("#TipIpi").val();



     if(TipoIPI =="1"){
       $('#VlrIpi').prop('readonly', false);
        $('#AliIpi').prop('readonly', true);
        $('#AliIpi').val("");
     } else {
       $('#VlrIpi').prop('readonly', true);
       $('#VlrIpi').val("");
       $('#AliIpi').prop('readonly', false);
     }
});
$("#TipPis").change(function(){
     var TipoPIS = $("#TipPis").val();
     if(TipoPIS =="1"){
       $('#VlrPis').prop('readonly', false);
     } else {
       $('#VlrPis').prop('readonly', true);
       $('#VlrPis').val("");
     }
});
$("#TipCof").change(function(){
     var TipoCofins = $("#TipCof").val();

     if(TipoCofins =="1"){
       $('#VlrCof').prop('readonly', false);

     } else {
       $('#VlrCof').prop('readonly', true);
       $('#VlrCof').val("");
     }
});


$("#CodCst").change(function() {
    var CodCst = $("#CodCst").val();
    if((CodCst =="10") | (CodCst=="30") | (CodCst =="70")){
          $('#AliMva').prop('readonly', false);
    }else {
      $('#AliMva').prop('readonly', true);
    }

});


//Consulta de CFOP
function consultarCFOP(CodTns){

      var json = ConvertFormToJSON("#EnviarCadastroTributacao");
                     var Form = this;
                     var CodigoCfop = CodTns;
                   $('#myModal').modal('show');

                   	$.ajax({


                   			type: "GET",
                   			dataType : "json",
                   		  data : json,
                   		  context : Form,
                   			//data: {CgcMat: $("#CgcMat").val()},
                   			url: "/consulta/cadastro/transacao/" + {CodTns: CodigoCfop} ,

                   			success: function(RetornoDescricaoTransacao) {
                            var status = (RetornoDescricaoTransacao.Status);

                            if(status == "Ok"){
                                  var NomTns = (RetornoDescricaoTransacao.DesTns);
                                  document.getElementById('DesTns').value = NomTns;
                            }else if(status=="ER"){
                                 var Msg = (RetornoDescricaoTransacao.Msg);


                                 swal({
                                        title: "Advertência!",
                                        text: Msg,
                                        type: "warning",
                                        closeOnConfirm: true // ou mesmo sem isto
                                    }, function() {
                                      $("#CodTns").val("");
                                    });
                                //swal ( "Advertência",Msg , "error" )   ;



                            }


                   			}


                   	});

                   	 $('#myModal').modal('hide');


 };

//Consulta de Produto
function consultarProduto(CodPro){

    var json = ConvertFormToJSON("#EnviarCadastroTributacao");
    var Form = this;
    var CodigoProduto = CodPro;

    $('#myModal').modal('show');

    $.ajax({
        type: "GET",
        dataType : "json",
        data : json,
        context : Form,

        url: "/consulta/cadastro/produto/tributacao/" + {CodPro: CodigoProduto} ,
        success: function(RetornaProduto) {
            var status = (RetornaProduto.Status);

            if(status == "OkDescricao"){
                var DesPro = (RetornaProduto.DesPro);
                $('#DesPro').val(DesPro);
            }else if(status =="Ok"){
                //Descricao
                var DesPro = (RetornaProduto.DesPro);
                $('#DesPro').val(DesPro);

                //Origem
                var CodOri = (RetornaProduto.CodOri);
                $('#CodOri').val(CodOri);

                //transacao
                var CodTns = (RetornaProduto.CodTns);
                var DesTns = (RetornaProduto.DesTns);
                $('#CodTns').val(CodTns);
                $('#DesTns').val(DesTns);

                //Cst
                var CodCst = (RetornaProduto.CodCst);
                $('#CodCst').val(CodCst);

                //Cst Ipi
                var CstIpi = (RetornaProduto.CstIpi);
                $('#CstIpi').val(CstIpi);

                //Cst PIS
                var CstPis = (RetornaProduto.CstPis);
                $('#CstPis').val(CstPis);

                //Cst COFINS
                var CstCof = (RetornaProduto.CstCof);
                $('#CstCof').val(CstCof);

                //Tipo de Calculo IPI
                var TipIpi= (RetornaProduto.TipIpi);
                $('#TipIpi').val(TipIpi);

                if (TipIpi == "0"){
                    $('#AliIpi').prop('readonly', false);
                    //Aliquota IPI
                    var AliIpi = (RetornaProduto.AliIpi);
                    if (AliIpi != undefined){
                        $('#AliIpi').val(AliIpi);
                        $("#CodTns").focus();
                    }
                }else {
                    $('#VlrIpi').prop('readonly', false);
                    $('#AliIpi').prop('readonly', true);
                    //Valor por Unidade IPI
                    var VlrIpi = (RetornaProduto.VlrIpi);
                    if (VlrIpi != undefined){
                          $('#VlrIpi').val(VlrIpi);
                    }
                }

                //Tipo Calculo PIS
                var TipPis = (RetornaProduto.TipPis);
                $('#TipPis').val(TipPis);
                if(TipPis =="1"){
                    $('#VlrPis').prop('readonly', false);
                    //Valor por Unidade PIS
                    var VlrPis = (RetornaProduto.VlrPis);
                    if (VlrPis != undefined){
                        $('#VlrPis').val(VlrPis);
                    }
                }

                //Tipo Calculo Cofins
                var TipCof = (RetornaProduto.TipCof);
                $("#TipCof").val(TipCof);
                if(TipCof =="1"){
                  $('#VlrCof').prop('readonly', false);
                //Valor por Unidade IPI
                  var VlrCof = (RetornaProduto.VlrCof);
                  if (VlrCof != undefined){
                        $("#VlrCof").val(VlrCof);
                  }
                }


                //Aliquota ICMS
                var AliIcm = (RetornaProduto.AliIcm);
                if (AliIcm != undefined){
                    $("#AliIcm").val(AliIcm);
                    $("#AliIcm").focus();
                    $("#CodTns").focus();
                }



                //Código Ncm
                var CodNcm = (RetornaProduto.CodNcm);
                $('#CodNcm').val(CodNcm);

                //Código Cest
                var CodCes = (RetornaProduto.CodCes);
                $('#CodCes').val(CodCes);


                //Ex Tipi
                var ExcTip = (RetornaProduto.ExcTip);
                if (!ExcTip){
                      $('#ExcTip').val(ExcTip);
                }

                //Aliquota MVA
                var AliMva = (RetornaProduto.AliMva);
                if(AliMva != undefined){
                      $('#AliMva').val(AliMva);
                }

                //Tributo Federal
                var TriFed = (RetornaProduto.TriFed);
                  $('#TriFed').val(TriFed);

                //Tributo Estadual
                var TriEst = (RetornaProduto.TriEst);
                $('#TriEst').val(TriEst);

                //Tributo Municipal
                var TriMun = (RetornaProduto.TriMun);
                if(TriMun != undefined){
                    $('#TriMun').val(TriMun);
                }

                //CSOSN
                var CodCsn = (RetornaProduto.CodCsn);
                if (CodCsn != undefined){
                    $('#CodCsn').val(CodCsn);
                }

                //Mod Base Cálculo ICMS
                var BasIcm = (RetornaProduto.BasIcm);
                if (BasIcm != undefined){
                    $('#BasIcm').val(BasIcm);
                }


                //Mod Base Cálculo ICMS ST
                var BasISt = (RetornaProduto.BasISt);
                if (BasISt != undefined){
                    $('#BasISt').val(BasISt);
                }


                //Motivo Desoneração do ICMS
                var MotDes = (RetornaProduto.MotDes);
                if (MotDes != undefined){
                    $('#MotDes').val(MotDes);
                }

                //Redução Base de Calculo ICMS
                var RedIcm = (RetornaProduto.RedIcm);
                if (RedIcm != undefined){
                    $('#RedIcm').val(RedIcm);
                }
                //Redução Base de Calculo ST
                var RedISt = (RetornaProduto.RedISt);
                if(RedISt != undefined){
                    $('#RedISt').val(RedISt);
                }

                //Aliquota Fcp
                var AliFcp = (RetornaProduto.AliFcp);
                $('#AliFcp').val(AliFcp);

            }if(status=="ER"){
                var Msg = (RetornaProduto.Msg);
                swal({
                    title: "Advertência",
                    text: Msg,
                    type: "warning",
                    closeOnConfirm: true // ou mesmo sem isto
                    });

                 LimparFormulario();
            }
       }
  });

     $('#myModal').modal('hide');

  };

//Converter Formulario em JSON
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
  <h3> Cadastro de Tributação</h3>
</center>
</div>
<div>
<body >



<form class="form" name="CadastroTributacao" id="EnviarCadastroTributacao" method="post"  >

{!! csrf_field() !!}



     <div class="container">
     			<div id="CadastroTributacao">

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
                          <input class="form-control" type="text" id="DesPro" name="DesPro" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="Descrição" style="text-transform: uppercase;" readonly/>
                    </div>
              </div>

    <div class="row">

                  <div class="col-md-8">
                        <label for="CodOri">*Origem </label>
                        <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="CodOri" name="CodOri"  >
                            <option selected value="99999" > Selecione </option>
                            @if(isset($listaOrigem))
                            @foreach($listaOrigem as $OrigemProdutos)
                                     <option value="{{$OrigemProdutos -> CodOri}}">{{ $OrigemProdutos -> CodOri}} - {{ $OrigemProdutos -> DesOri}} </option>
                           @endforeach
                           @endif
                        </select>
                  </div>

    </div>


             <div class="row">
               <div class="col-md-2">
                     <label for="CodTns">*CFOP </label>
                     <input class="form-control" type="text" id="CodTns" name="CodTns" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="CFOP" onkeyup="somenteNumeros(this);"  required />
               </div>

               <div class="col-md-6">
                       <label for="DesTns">*Descrição CFOP</label>
                       <input class="form-control" type="text" id="DesTns" name="DesTns" value="{{isset($consultarfilial->InsEst) ? $consultarfilial->InsEst : ''}}" placeholder="Descrição CFOP" style="text-transform: uppercase;"  readonly />
               </div>


            </div>


            <div class="row">

                          <div class="col-md-4">
                                <label for="CodCst">*CST </label>
                                <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="CodCst" name="CodCst"  >
                                    <option selected value="99999" disabled> Selecione </option>
                                    @if(isset($listaCST))
                                    @foreach($listaCST as $CSTProdutos)
                                             <option value="{{$CSTProdutos -> CodCst}}">{{ $CSTProdutos -> CodCst}} - {{ $CSTProdutos -> DesCst}} </option>
                                   @endforeach
                                   @endif
                                </select>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="CstIpi">*CST IPI </label>
                                  <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="CstIpi" name="CstIpi" > >
                                      <option selected value="99999" disabled > Selecione </option>
                                      @if(isset($listaIPI))
                                      @foreach($listaIPI as $IPIProduto)
                                               <option value="{{$IPIProduto -> CodCst}}">{{ $IPIProduto -> CodCst}} - {{ $IPIProduto -> DesCst}} </option>
                                     @endforeach
                                     @endif

                                  </select>
                               </div>
                            </div>

            </div>


            <div class="row">
              <div class="col-md-4">
                  <div class="form-group">
                      <label for="CstPis">*CST PIS </label>
                      <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="CstPis" name="CstPis" > >
                          <option selected value="99999" disabled> Selecione </option>
                          @if(isset($listaPISCofins))
                          @foreach($listaPISCofins as $pisProduto)
                                   <option value="{{$pisProduto -> CodCst}}">{{ $pisProduto -> CodCst}} - {{ $pisProduto -> DesCst}} </option>
                         @endforeach
                         @endif

                      </select>
                   </div>
                </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label for="CstCof">*CST Cofins </label>
                      <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="CstCof" name="CstCof" > >
                          <option selected value="99999" > Selecione </option>
                          @if(isset($listaCofins))
                          @foreach($listaCofins as $CofinsProduto)
                                   <option value="{{$CofinsProduto -> CodCst}}">{{ $CofinsProduto -> CodCst}} - {{ $CofinsProduto -> DesCst}} </option>
                         @endforeach
                         @endif

                      </select>
                   </div>
                </div>

             </div>

             <div class="row">
               <div class="col-md-2">
                   <div class="form-group">
                       <label for="TipIpi">*Tipo Cálculo IPI</label>
                       <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="TipIpi" name="TipIpi" >
                           <option value="99999" selected disabled >Selecione</option>
                           <option value="0">Percentual</option>
                           <option value="1">Em Valor</option>
                       </select>
                    </div>
                 </div>
                 <div class="col-md-3">
                     <div class="form-group">
                         <label for="TipPis">*Tipo Cálculo PIS</label>
                         <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="TipPis" name="TipPis" >
                             <option value="99999" selected disabled >Selecione</option>
                             <option value="0">Percentual</option>
                             <option value="1">Em Valor</option>
                         </select>
                      </div>
                   </div>

                   <div class="col-md-3">
                       <div class="form-group">
                           <label for="TipCof">*Tipo Cálculo COFINS</label>
                           <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="TipCof" name="TipCof" >
                               <option value="99999" selected disabled >Selecione</option>
                               <option value="0">Percentual</option>
                               <option value="1">Em Valor</option>
                           </select>
                        </div>
                     </div>


            </div>


             <div class="row">
               <div class="col-md-2">
                 <div class="form-group">
                     <label for="AliIcm">Alíquota ICMS(%)</label>
                     <input class="form-control" type="text" id="AliIcm" name="AliIcm" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="Alíquota ICMS(%)"  />

                 </div>
               </div>

               <div class="col-md-2">
                 <div class="form-group">
                     <label for="AliIpi">Alíquota IPI(%)</label>
                     <input class="form-control" type="text" id="AliIpi" name="AliIpi" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="Alíquota IPI(%)"  readonly/>

                 </div>
               </div>

               <div class="col-md-2">
                   <div class="form-group">
                             <label for="CodNcm">*NCM </label>
                             <input class="form-control" type="text" id="CodNcm" name="CodNcm" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="NCM" style="text-transform: uppercase;" />

                    </div>
                 </div>

                    <div class="col-md-2">
                        <div class="form-group">
                          <label for="CodCes">*CEST </label>
                          <input class="form-control" type="text" id="CodCes" name="CodCes" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="CEST" style="text-transform: uppercase;" />

                         </div>
                      </div>


            </div>



           <div class="row">

             <div class="col-md-2">
               <div class="form-group">
                   <label for="VlrIpi">Valor por Unidade IPI</label>
                   <input class="form-control" type="text" id="VlrIpi" name="VlrIpi" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="Valor por Unidade IPI"  readonly/>

               </div>
             </div>

             <div class="col-md-2">
               <div class="form-group">
                   <label for="VlrPis">Valor por Unidade PIS</label>
                   <input class="form-control" type="text" id="VlrPis" name="VlrPis" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="Valor por Unidade PIS" readonly />

               </div>
             </div>

             <div class="col-md-2">
               <div class="form-group">
                   <label for="VlrCof">Valor por Unidade Cofins</label>
                   <input class="form-control" type="text" id="VlrCof" name="VlrCof" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="Valor por Unidade Cofins" readonly />

               </div>
             </div>

             <div class="col-md-2">
                 <div class="form-group">
                           <label for="ExcTip">(EX) Exceção TIPI   </label>
                           <input class="form-control" type="text" id="ExcTip" name="ExcTip" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="(EX) Exceção TIPI"  />

                  </div>
               </div>
         </div>

         <div class="row">
           <div class="col-md-2">
               <div class="form-group">
                         <label for="AliMva">MVA(%) </label>
                         <input class="form-control" type="text" id="AliMva" name="AliMva" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="MVA(%)"  readonly/>

                </div>
             </div>

           <div class="col-md-2">
             <div class="form-group">
                 <label for="TriFed">*Tributo Federal(%)</label>
                 <input class="form-control" type="text" id="TriFed" name="TriFed" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="Tributo Federal(%)"  />

             </div>
           </div>

           <div class="col-md-2">
             <div class="form-group">
                 <label for="TriEst">*Tributo Estadual(%)</label>
                 <input class="form-control" type="text" id="TriEst" name="TriEst" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="Tributo Estadual(%)"  />

             </div>
           </div>

           <div class="col-md-2">
               <div class="form-group">
                         <label for="TriMun">Tributo Municipal(%) </label>
                         <input class="form-control" type="text" id="TriMun" name="TriMun" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="Tributo Municipal(%)"  />

                </div>
             </div>




        </div>




             <div class="row">

                           <div class="col-md-8">
                                 <label for="CodCsn">*CSOSN </label>
                                 <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="CodCsn" name="CodCsn"  >
                                     <option selected value="99999" disabled> Selecione </option>
                                     @if(isset($listaCSOSN))
                                     @foreach($listaCSOSN as $CSOSNTProdutos)
                                              <option value="{{$CSOSNTProdutos -> CodCst}}">{{ $CSOSNTProdutos -> CodCst}} - {{ $CSOSNTProdutos -> DesCst}} </option>
                                    @endforeach
                                    @endif
                                 </select>
                           </div>

             </div>

              <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="BasIcm">*Mod Base Cálculo ICMS</label>
                        <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="BasIcm" name="BasIcm" >
                            <option value="99999" selected disabled >Selecione</option>
                            <option value="0">0 - Margem Valor Agregado (%)</option>
                            <option value="1">1 - Pauta (Valor)</option>
                            <option value="2">2 - Preço Tabelado Máx. (valor)</option>
                            <option value="3">3 - valor da operação</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label for="BasISt">*Mod Base Cálculo ICMS ST</label>
                          <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="BasISt" name="BasISt" >
                              <option value="99999" selected disabled >Selecione</option>
                              <option value="0">0 - Preço tabelado ou máximo sugerido </option>
                              <option value="1">1 - Lista Negativa (valor)</option>
                              <option value="2">2 - Lista Positiva (valor) </option>
                              <option value="3">3 - Lista Neutra (valor) </option>
                              <option value="4">4 - Margem Valor Agregado (%) </option>
                              <option value="5">5 - Pauta (valor) </option>
                          </select>
                       </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="MotDes">Motivo Desoneração do ICMS</label>
                            <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="MotDes" name="MotDes" >
                                <option value="99999"  disabled >Selecione</option>
                                <option value="0" selected>0 - Não se Aplica </option>
                                <option value="3">3 - Uso na agropecuária </option>
                                <option value="9">9 - Outros</option>
                                <option value="12">12 - Órgão de fomento e desenvolvimento agropecuário. </option>

                            </select>
                         </div>
                      </div>


             </div>


             <div class="row">
               <div class="col-md-3">
                 <div class="form-group">
                     <label for="RedIcm">Redução Base Cálculo ICMS(%)</label>
                     <input class="form-control" type="text" id="RedIcm" name="RedIcm" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="Redução Base Cálculo ICMS (%)"  />

                 </div>
               </div>

               <div class="col-md-3">
                 <div class="form-group">
                     <label for="RedIst">Redução Base Cálculo ST (%)</label>
                     <input class="form-control" type="text" id="RedISt" name="RedISt" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="Redução Base Cálculo ST (%)"  />

                 </div>
               </div>

               <div class="col-md-2">
                 <div class="form-group">
                     <label for="AliFcp">* Alíquota FCP (%) </label>
                     <input class="form-control" type="text" id="AliFcp" name="AliFcp" value="{{isset($consultarfilial->NomFan) ? $consultarfilial->NomFan : ''}}" placeholder="Alíquota FCP (Fundo Combate a Pobreza)"  />

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
