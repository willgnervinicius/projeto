@extends('adminlte::page')

@section('title', 'Cronus (ERP) - Títulos Receber')

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
<script src="{{ asset('js/jquery.maskMoney.js') }}"></script>







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




$(document).ready(function(){
    var date = new Date();

    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var today = year + "-" + month + "-" + day;   

    var dia = date.getDate();
    var mes = date.getMonth() + 2;
    var ano = date.getFullYear();

    if (mes < 10) mes = "0" + mes;
    if (dia < 10) dia = "0" + dia;

    var data = ano + "-" + mes + "-" + dia; 

    var diapgt = date.getDate() + 2;
    var mespgt = date.getMonth() + 2;
    var anopgt = date.getFullYear();

    if (mespgt < 10) mespgt = "0" + mespgt;
    if (diapgt < 10) diapgt = "0" + diapgt;

    var datapgt = anopgt + "-" + mespgt + "-" + diapgt;

    

    $("#DtaEmi").attr("value", today);
    $("#DtaVct").attr("value", data);
    $("#ProPag").attr("value", datapgt);
  

    ConsultaTipo();

});



function ConsultaFavorecido(){
        var json = ConvertFormToJSON("#TituloReceber");
        var Form = this;
        var Favorecido = $('#CgcCpf').val();

       
                        
            if ((Favorecido !='')| (Favorecido != undefined) || (Favorecido != null)){
              return false ;
            } else {
            
                        $.ajax({


                            type: "GET",
                            dataType : "json",
                            data : json,
                            context : Form,
                            url: "/consulta/cadastro/favorecido/"+{CgcCpf : Favorecido},

                            success: function(RetornaFavorecido) {
                                var status = (RetornaFavorecido.Status);

                                if(status == "OK"){
                                    $('#CodBan').val(RetornaFavorecido.CodBan);
                                    $('#AgeCta').val(RetornaFavorecido.AgeCta);
                                    $('#NumCta').val(RetornaFavorecido.NumCta);

                                    $('#AgeCta').prop('readonly', true);
                                    $('#NumCta').prop('readonly', true);
     
                                    
                                }else {
                                  swal({
                                            title: "Informação",
                                            text: "Dados Bancários do Favorecido não Cadastrado , não será possível fazer DOC / TED sem este cadastro",
                                            type: "warning",
                                            closeOnConfirm: true // ou mesmo sem isto
                                        }, function() {
                                         
                                          $('#NumTit').focus();
                                          $('#CodBan').val(RetornaFavorecido.CodBan);
                                        });

                                }

                            }


                        });

            }
           



}



function ConvertFormToJSON(form){
            var array = jQuery(form).serializeArray();
            var json = {};

            jQuery.each(array, function() {
                    json[this.name] = this.value || '';
            });

            
            return json;
}



$("#CodCcu").focusout(function(){     
       ConsultaCentroCusto();
});

function ConsultaCentroCusto(){

        var json = ConvertFormToJSON("#TituloReceber");
        var Form = this;
        var CentroCusto = $('#CodCcu').val();

       
                        
            if ((CentroCusto =='')| (CentroCusto == undefined) || (CentroCusto == null)){
              return false ;
            } else {
                    
                        $.ajax({


                            type: "GET",
                            dataType : "json",
                            data : json,
                            context : Form,
                            url: "/consulta/centro/custo/"+{CodCcu : CentroCusto},

                            success: function(RetornaCentroCusto) {
                                var status = (RetornaCentroCusto.Status);

                                if(status == "OK"){
                                    $('#DesCcu').val(RetornaCentroCusto.DesCcu);
                                    
                                }else {
                                  swal({
                                            title: "Advertência!",
                                            text: "Centro de Custo não Localizado",
                                            type: "warning",
                                            closeOnConfirm: true // ou mesmo sem isto
                                        }, function() {
                                          $("#CodCcu").val("");
                                          $('#CodCcu').focus();
                                        });

                                }

                            }


                        });

            }
              



}


function resetaCombo( el ){
    		$("select[name='"+el+"']").empty();//retira os elementos antigos
    		var option = document.createElement('option');
    	
}




function ConsultaTipo(){
      var json = ConvertFormToJSON("#TituloReceber");
      var Form = this;

                $.ajax({


                    type: "GET",
                    dataType : "json",
                    data : json,
                    context : Form,
                    url: "/consulta/tipo/titulo/receber/"+{CodTip:1},

                    success: function(RetornaBanco) {
                        var status = (RetornaBanco.Status);

                        
                             var option = new Array();//resetando a variável

                              resetaCombo('TipTit');//resetando o combo
                              $.each(RetornaBanco, function(i, obj){

                                option[i] = document.createElement('option');//criando o option
                                $( option[i] ).attr( {value : obj.CodTip} );//colocando o value no option
                                $( option[i] ).append( obj.CodTip + ' - ' + obj.NomTip );//colocando o 'label'

                                $("select[name='TipTit']").append( option[i] );//jogando um à um os options no próximo combo
                              });

                            
                        

                    }


                });

    
    



}

function CadastronaoRealizado(){
  swal ( "Desculpe !","Ocorreu um erro. Tente Novamente" , "error" )   ;
}

 function salvar(){
    	//var data = {}
  var json = ConvertFormToJSON("#TituloReceber");
  var Form = this;
  $('#loading').modal('show');
	$.ajax({

			type: "POST",
			dataType : "json",
		  data : json,
		  context : Form,
			
			url: "/novo/titulo/receber",
			success: function(Retorno) {
         var Status = Retorno.Status;
         
         if(Status == 'OK'){
             var Msg = (Retorno.Mensagem);
             swal(Msg," ", "success");
						 LimparFormulario();
         }else {
          CadastronaoRealizado();
         }

			}


	});

  $('#loading').modal('hide');

 }


$("#CodPor").focusout(function(){     
  consultarPortador();
});



  //Consulta de Fornecedor
  function consultarPortador(){
                     var json = ConvertFormToJSON("#TituloReceber");
                     var Form = this;
                     var CodPor = $('#CodPor').val();


                    
           if ((CodPor =='')|| (CodPor == undefined) || (CodPor == null)){
                return false ;
           } else {
                   
                   	$.ajax({


                   			type: "GET",
                   			dataType : "json",
                   		  data : json,
                   		  context : Form,
                   			url: "/consulta/cadastro/portador/" +{CodPor : CodPor} ,

                   			success: function(RetornaPortador) {
                            var status = (RetornaPortador.Status);

                            if(status == "OK"){
                                  $('#NomPor').val(RetornaPortador.NomPor);
                                  $('#CodBan').val(RetornaPortador.CodBan);

                                 
                                  
                                  
                            }else if(status=="ER"){
                                 var Msg = (RetornaPortador.Msg);


                                 swal({
                                        title: "Advertência!",
                                        text: Msg,
                                        type: "warning",
                                        closeOnConfirm: true // ou mesmo sem isto
                                    }, function() {
                                      $("#CodPor").val("");
                                      $("#DesPor").val("");
                                     
                                    });
                            }


                   			}


                   	});

                     

           }   

      };


  $("#CodCli").focusout(function(){     
      consultarClientecodigo();
  });

  //Consulta de Fornecedor
  function consultarClientecodigo(){
                     var json = ConvertFormToJSON("#TituloReceber");
                     var Form = this;
                     var CodCli = $('#CodCli').val();

   

                    
           if ((CodCli =='')|| (CodCli == undefined) || (CodCli == null)){
                return false ;
           } else {
            
                   	$.ajax({
                   

                   			type: "GET",
                   			dataType : "json",
                   		  data : json,
                   		  context : Form,
                   			url: "/consulta/cadastro/cliente/gerais/" +{CodCli : CodCli} ,

                   			success: function(Retorno) {
                            var status = (Retorno.Status);

                            if(status == "OK"){
                                  $('#RazSoc').val(Retorno.RazSoc);
                                  $('#CgcCpf').val(Retorno.CgcCpf);

                                  ConsultaFavorecido();

                                  $('#NumTit').focus();
                                  
                                  
                            }else if(status=="ER"){
                                 var Msg = (Retorno.Msg);


                                 swal({
                                        title: "Advertência!",
                                        text: Msg,
                                        type: "warning",
                                        closeOnConfirm: true // ou mesmo sem isto
                                    }, function() {
                                      $("#CodCli").val("");
                                      $("#CgcCpf").val("");
                                    });
                            }


                   			}


                   	});
                    
           }   

      };



$("#CgcCpf").focusout(function(){     
    consultarCliente();
});

function empty(data){
        if(typeof(data) == 'number' || typeof(data) == 'boolean')
        { 
          return false; 
        }
        if(typeof(data) == 'undefined' || data === null)
        {
          return true; 
        }
        if(typeof(data.length) != 'undefined')
        {
          return data.length == 0;
        }
        var count = 0;
        for(var i in data)
        {
          if(data.hasOwnProperty(i))
          {
            count ++;
          }
        }
        return count == 0;
}

  //Consulta de Cliente
  function consultarCliente(){
                     var json = ConvertFormToJSON("#TituloReceber");
                     var Form = this;
                     var CnpjCpf = $('#CgcCpf').val();
                     var CodCli = $('#CodCli').val();
         
                    
       if( CodCli == ''){
                    
           if ( (CnpjCpf =='')|| (CnpjCpf == undefined) || (CnpjCpf == null)){
                   return false ;
           } else {
             
                $.ajax({


                    type: "GET",
                    dataType : "json",
                    data : json,
                    context : Form,
                    url: "/consulta/cadastro/cliente/gerais/cnpj/" +{CgcCpf : CnpjCpf} ,

                    success: function(Retorno) {
                      var status = (Retorno.Status);

                      if(status == "OK"){
                            $('#RazSoc').val(Retorno.RazSoc);
                            $('#CodCli').val(Retorno.CodCli);

                            ConsultaFavorecido();
                            
                            
                      }else if(status=="ER"){
                            var Msg = (Retorno.Msg);


                            swal({
                                  title: "Advertência!",
                                  text: Msg,
                                  type: "warning",
                                  closeOnConfirm: true // ou mesmo sem isto
                              }, function() {
                                $("#CodCli").val("");
                                $("#CgcCpf").val("");
                              });
                      }


                    }


                    });

                   

           }
       }  

};


//*----*

$("#TipTit").focusout(function(){  

  if($('#CodCli').val() != '' && $('#CgcCpf').val() != '' && $('#NumTit').val() != '' && $('#TipTit').val() != '' ){
    consultarTitulo();
  }

    
});
      //Consulta de Titulo
function consultarTitulo(){
                     var json = ConvertFormToJSON("#TituloReceber");
                     var Form = this;
                     var CodCli = $('#CodCli').val();

                     
                     

                    
           if ((CodCli !='')|| (CodCli != undefined) || (CodCli != null)){
                    
                   $('#loading').modal('show');

                   	$.ajax({


                   			type: "GET",
                   			dataType : "json",
                   		  data : json,
                   		  context : Form,
                   			url: "/consulta/titulo/receber/" +{CodCli : CodCli} ,

                   			success: function(Retorno) {
                            var status = (Retorno.Status);

                            if(status == "OK"){
                                  $('#SitTit').val(Retorno.SitTit);
                                  $('#CodCcu').val(Retorno.CodCcu);
                                  $('#DtaEmi').val(Retorno.DtaEmi);
                                  $('#DtaVct').val(Retorno.DtaVct);
                                  $('#ProPag').val(Retorno.ProPag);
                                  $('#VlrOri').val(Retorno.VlrOri);
                                  $('#VlrJur').val(Retorno.VlrJur);
                                  $('#VlrMul').val(Retorno.VlrMul);
                                  $('#VlrDes').val(Retorno.VlrDes);
                                  $('#VlrRec').val(Retorno.VlrRec);
                                  $('#CodPor').val(Retorno.CodPor);
                                  $('#CodCar').val(Retorno.CodCar);
                                  $('#CodBar').val(Retorno.CodBar);
                                  $('#NosNum').val(Retorno.NosNum);
                                  $('#NumNfe').val(Retorno.NumNfe);
                                  $('#SerNfe').val(Retorno.SerNfe);
                                  $('#CodIns').val(Retorno.CodIns);
                                  $('#InsBan').val(Retorno.InsBan);

                                  $('#DtaEmi').prop('readonly', true);
                                  $('#DtaVct').prop('readonly', true);
                                  $('#VlrOri').prop('readonly', true);

                                  ConsultaCentroCusto();
                                  consultarPortador();

                                  var Situacao = Retorno.SitTit;

                                 /**  if(Situacao == 'CA'){
                                    $("input").prop("disabled", true);
                                    $("select").prop("disabled", true);
                                    $("#btnsalvar").prop("disabled", true);

                                    swal ( "Advertência !","Título consta como Cancelado , alteração não Permitida." , "warning" )   ;
                                    
                                    
                                  } else*/ if(Situacao == 'LQ'){
                                    $("input").prop("disabled", true);
                                    $("select").prop("disabled", true);
                                    $("#btnsalvar").prop("disabled", true);
                                    $("#btnCodigoBarras").prop("disabled", true);

                                    swal ( "Advertência !","Título já Liquidado" , "warning" )   ;
                                    
                                  } else if(Situacao == 'PE'){
                                    $("input").prop("disabled", true);
                                    $("select").prop("disabled", true);
                                    $("#btnsalvar").prop("disabled", true);
                                    $("#btnCodigoBarras").prop("disabled", true);

                                    swal ( "Advertência !","Título já enviado ao Banco.Para atualizar aguarde o Retorno da Remessa." , "warning" )   ;
                                    
                                  }


                                 
                                  
                                  
                            }else if(status=="ER"){
                                 var Msg = (RetornaPortador.Msg);


                                 swal({
                                        title: "Advertência!",
                                        text: Msg,
                                        type: "warning",
                                        closeOnConfirm: true // ou mesmo sem isto
                                    }, function() {
                                      $("#CodPor").val("");
                                     
                                    });
                            }


                   			}


                   	});
                    $('#loading').modal('hide');

           }   

};

function LimparFormulario(){
  $('#TituloReceber').each (function(){
      this.reset();

      $('#AgeCta').prop('readonly', false);
      $('#NumCta').prop('readonly', false);
      $('#DtaEnt').prop('readonly', false);
      $('#VlrOri').prop('readonly', false);
      $("input").prop("disabled", false);
      $("select").prop("disabled", false);
      $("#btnsalvar").prop("disabled", false);
      $("#RazSoc").prop("disabled", true);
      $("#DesCcu").prop("disabled", true);
      $("#NomPor").prop("disabled", true);
      $("#btnCodigoBarras").prop("disabled", false);
      
    });

   

}




$("#VlrPag").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 2
  });
  
  $("#VlrJur").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 2
  });
  $("#VlrMul").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 2
  });
  $("#VlrOri").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 2
  });
 


function validar(){
  if($('#CodCli').val() != '' && $('#NumTit').val() != '' && $('#TipTit').val() != '' && $('#SitTit').val() != '' && $('#CodCcu').val() != '' && $('#DtaEmi').val() != '' && $('#DtaVct').val() != ''  && $('#ProPgt').val() != '' && $('#VlrOri').val() != '' && $('#CodPor').val() != '') {
    salvar();
  } else {
              swal({
                     title: "Advertência!",
                     text: 'Campos com * são Obrigatórios.',
                     type: "warning",
                     closeOnConfirm: true // ou mesmo sem isto
                     }, function() {
                        $("#CodCli").focus();
                                      
                                     
              });
  }

}



 </script>



@stop

@section('content')

<!--Inicio-->
<center>
  <h3> Entrada / Manutenção Titulo Receber</h3>
</center>



<div>
<body>

<form class="form"  id="TituloReceber" method="post"  action="">


{!! csrf_field() !!}




<div class"container">

<div class="row">

        <div class="col-md-2">
              <label for="CodEmp">* Código </label>
              <input class="form-control" type="text" id="CodCli" name="CodCli" placeholder="Código Cliente" />
        </div>
		

        <div class="col-md-3">
            <label for="GruEmp"> CNPJ / CPF Cliente </label>
            <input class="form-control" type="text" id="CgcCpf" autocomplete="off" autofocus name="CgcCpf" placeholder="CNPJ / CPF"  >
        </div>


          <div class="col-md-5">
						<label for="NomFan"> Razão Social </label>
						<input class="form-control" type="text" id="RazSoc" name="RazSoc" placeholder="Nome Completo / Razão Social" disabled/>
			    </div>

					

  </div>
  
    <div class="row">

        <div class="col-md-3">
          <label for="CodEmp"> * Título </label>
         
              <input class="form-control" type="text" id="NumTit" name="NumTit" placeholder="Título" />
            
        </div>


        <div class="col-md-2">
                        <div class="form-group">
                            <label for="TipTit">* Tipo</label>
                            <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="TipTit" name="TipTit" required>
                                <option value="01" disabled selected >Selecione ... </option>
                               
                            </select>
                        </div>
          </div>

          <div class="col-md-2">
                        <div class="form-group">
                            <label for="SitTit">* Situação</label>
                            <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="SitTit" name="SitTit" required>
                                <option selected value="AB">Aberto Normal</option>
                                <option value="AC" disabled >Aberto Cartório</option>
                                <option value="AI" disabled >Aberto Imposto</option>
                                <option value="AJ" disabled >Aberto Júridico</option>
                                <option value="AX" >Aberto Externo</option>
                                <option value="CA" >Cancelado</option>
                                <option value="LQ" disabled >Liquidado</option>
                                <option value="PE" disabled >Pagamento Eletrônico</option>
                                <option value="AG" disabled >Aguardando Pagamento</option>
                                <option value="DE" disabled >Devolvido</option>
                                <option value="CO" disabled >Contestação</option>
                                <option value="LM" disabled >Liquidado Manualmente</option>
                                <option value="VC" disabled >Vencido</option>
                            </select>
                        </div>
          </div>

    </div>


    <div class="row">

     
   
        <div class="col-md-2">
            <label for="GruEmp">* Centro de Custo </label>
            <input class="form-control" type="text" id="CodCcu"   name="CodCcu" placeholder="Centro de Custo"  >
        </div>


          <div class="col-md-5">
            <label for="NomFan">Descrição </label>
            <input class="form-control" type="text" id="DesCcu" name="DesCcu" placeholder="Descrição" disabled/>
          </div>
  </div>


  <div class="row">

     
   
        <div class="col-md-2">
            <label for="CodRep">Representante </label>
            <input class="form-control" type="text" id="CodRep" autocomplete="off"  name="CodRep" placeholder="Representante" disabled >
        </div>


          <div class="col-md-5">
            <label for="NomFan">Razão Social </label>
            <input class="form-control" type="text" id="RazRep" name="RazRep" placeholder="Razão Social" disabled/>
          </div>
  </div>

  <div class="row">
                      <div class="col-md-2">
                              <label for="GruEmp">* Data Emissão</label>
                              <input class="form-control" type="date" id="DtaEmi" name="DtaEmi"  placeholder="Data Entrada"  />
                      </div>

                      <div class="col-md-2">
                              <label for="GruEmp">* Data Vencimento</label>
                              <input class="form-control" type="date" id="DtaVct" name="DtaVct"  placeholder="Data Vencimento"  />
                      </div>

                      <div class="col-md-2">
                              <label for="GruEmp">* Provável Pagamento</label>
                              <input class="form-control" type="date" id="ProPag" name="ProPag"  placeholder="Provável Pagamento"  />
                      </div>


   </div>


   <div class="row">
                                  <div class="col-md-2">
                                      <label for="BasIcm"> * Valor Original</label>
                                      <input class="form-control" type="text" id="VlrOri" name="VlrOri"  placeholder="Valor Original" />
                                    </div>


                                    <div class="col-md-2">
                                        <label for="VlrIcm"> Juros</label>
                                        <input class="form-control" type="text" id="VlrJur" name="VlrJur"  placeholder="Juros" />
                                    </div>

                                    <div class="col-md-2">
                                      <label for="BIcmSt"> Multa</label>
                                      <input class="form-control" type="text" id="VlrMul" name="VlrMul"  placeholder="Multa" />
                                    </div>



                                    <div class="col-md-2">
                                        <label for="TotPro"> Valor Receber </label>
                                        <input class="form-control" type="text" id="VlrRec" name="VlrRec"   placeholder="Valor Receber" disabled />
                                      </div>


                                  </div>


                


  <div class="row">
        <div class="col-md-2">
            <label for="GruEmp">* Portador </label>
            <input class="form-control" type="text" id="CodPor" autocomplete="off"  name="CodPor" placeholder="Portador"  >
        </div>


          <div class="col-md-5">
            <label for="NomFan"> Descrição </label>
            <input class="form-control" type="text" id="NomPor" name="NomPor" placeholder="Descrição" disabled/>
          </div>


          
  </div>

   

    <div class="row">
        <div class="col-md-2">
                <label for="CodCar">Carteira </label>
                <input class="form-control" type="text" id="CodCar" name="CodCar" placeholder="Carteira" />
            </div>
    

        <div class="col-md-5">
                      <label for="CodBar">Código Barras </label>
                      <div class="input-group">
                          <input class="form-control" type="text" id="CodBar" name="CodBar" maxlength="48"    placeholder="Código Barras" readonly />
                          <div class="input-group-btn">
                           

                             <button class="btn btn-info"  id="btnCodigoBarras" type="button" onclick="download()">
                                   <span class="fa fa-cloud-download"></span>
                            </button>
                           </div>
                         </div>
        </div>
     
  

        <div class="col-md-2">
              <label for="NosNum">Nosso Número</label>
              <input class="form-control" type="text" id="NosNum" name="NosNum" placeholder="Nosso Número" disabled />
            
        </div>

    </div>

    <div class="row">
        <div class="col-md-2">
            <label for="CodIns">* Código Instrução </label>
            <input class="form-control" type="text" id="CodIns" autocomplete="off"  name="CodIns" placeholder="Código Instrução"  >
        </div>


          <div class="col-md-5">
            <label for="InsBan"> Instrução Bancária </label>
            <input class="form-control" type="text" id="InsBan" name="InsBan" placeholder="Instrução Bancária" maxlength="100" readonly/>
          </div>


          
  </div>

 

    <div class="row">

        <div class="col-md-3">
          <label for="NumNfe">Nota Fiscal</label>
         
              <input class="form-control" type="text" id="NumNfe" name="NumNfe" placeholder="Nota Fiscal" disabled />
            
        </div>

        <div class="col-md-3">
          <label for="SerNfe">Série</label>
         
              <input class="form-control" type="text" id="SerNfe" name="SerNfe" placeholder="Série" disabled />
            
        </div>

    </div>




</div>


 

<input type="hidden" value="{{$_SERVER['SERVER_NAME']}}" />

</div>

<br>
<div class="container-fluid">
      <div class="row">
            <div class="col-md-2">
                  <button type="button" name="btnlimpar"  onclick="LimparFormulario()"  class="btn btn-danger btn-sm custom-button-width"> <i class="fa fa-refresh" aria-hidden="true"></i> Limpar</button>
            </div>
          <div class="col-md-6 text-right">
              <button  name="btnsalvar" id="btnsalvar"   type="button" class="btn btn-primary btn-sm custom-button-width .navbar-right" onclick="validar()"><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>
           </div>
      </div>
</div>

</form>
</div>
</div>
</div>

<div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-labelledby="alterarLabel" style="z-index: 1100;" data-backdrop="static" >
    <div class="modal-dialog modal-sm" role="document">
       <div class="modal-content">
          <div id="container">
              <div id="loader"></div>
                  <div id="content">
                    <center>
                        <img src="{{ asset('/img/') }}/carregando.gif" width="200" height="200"/>
                    </center>
                  </div>
              </div>
          </div>
       </div>
</div>






@stop
