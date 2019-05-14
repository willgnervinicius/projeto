@extends('adminlte::page')

@section('title', 'Cronus (ERP) - Títulos Pagar')

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
  ConsultaBanco();
  ConsultaTipo();

});



function ConsultaFavorecido(){
        var json = ConvertFormToJSON("#TituloPagar");
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

        var json = ConvertFormToJSON("#TituloPagar");
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

function ConsultaBanco(){
      var json = ConvertFormToJSON("#TituloPagar");
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


function ConsultaTipo(){
      var json = ConvertFormToJSON("#TituloPagar");
      var Form = this;

                $.ajax({


                    type: "GET",
                    dataType : "json",
                    data : json,
                    context : Form,
                    url: "/consulta/tipo/titulo/pagar/"+{CodTip:1},

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
  var json = ConvertFormToJSON("#TituloPagar");
  var Form = this;
  $('#loading').modal('show');
	$.ajax({

			type: "POST",
			dataType : "json",
		  data : json,
		  context : Form,
			
			url: "/novo/titulo/pagar",
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
                     var json = ConvertFormToJSON("#TituloPagar");
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
                                     
                                    });
                            }


                   			}


                   	});

                     

           }   

      };


 $("#CodFor").focusout(function(){     
        consultarFornecedorcodigo();
 });

  //Consulta de Fornecedor
  function consultarFornecedorcodigo(){
                     var json = ConvertFormToJSON("#TituloPagar");
                     var Form = this;
                     var CodFor = $('#CodFor').val();

   

                    
           if ((CodFor =='')|| (CodFor == undefined) || (CodFor == null)){
                return false ;
           } else {
            
                   	$.ajax({
                   

                   			type: "GET",
                   			dataType : "json",
                   		  data : json,
                   		  context : Form,
                   			url: "/consulta/cadastro/fornecedor/gerais/" +{CodFor : CodFor} ,

                   			success: function(RetornaFornecedor) {
                            var status = (RetornaFornecedor.Status);

                            if(status == "OK"){
                                  $('#RazSoc').val(RetornaFornecedor.RazSoc);
                                  $('#CgcCpf').val(RetornaFornecedor.CgcCpf);

                                  ConsultaFavorecido();

                                  $('#NumTit').focus();
                                  
                                  
                            }else if(status=="ER"){
                                 var Msg = (RetornaFornecedor.Msg);


                                 swal({
                                        title: "Advertência!",
                                        text: Msg,
                                        type: "warning",
                                        closeOnConfirm: true // ou mesmo sem isto
                                    }, function() {
                                      $("#CodFor").val("");
                                      $("#CgcCpf").val("");
                                    });
                            }


                   			}


                   	});
                    
           }   

      };



$("#CgcCpf").focusout(function(){     
  consultarFornecedor();
});

function empty(data)
{
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

  //Consulta de Fornecedor
  function consultarFornecedor(){
                     var json = ConvertFormToJSON("#TituloPagar");
                     var Form = this;
                     var CnpjCpf = $('#CgcCpf').val();
                     var CodFor = $('#CodFor').val();
         
                    
       if( CodFor == ''){
                    
           if ( (CnpjCpf =='')|| (CnpjCpf == undefined) || (CnpjCpf == null)){
                   return false ;
           } else {
             
                $.ajax({


                    type: "GET",
                    dataType : "json",
                    data : json,
                    context : Form,
                    url: "/consulta/cadastro/fornecedor/gerais/cnpj/" +{CgcCpf : CnpjCpf} ,

                    success: function(RetornaFornecedor) {
                      var status = (RetornaFornecedor.Status);

                      if(status == "OK"){
                            $('#RazSoc').val(RetornaFornecedor.RazSoc);
                            $('#CodFor').val(RetornaFornecedor.CodFor);

                            ConsultaFavorecido();
                            
                            
                      }else if(status=="ER"){
                            var Msg = (RetornaFornecedor.Msg);


                            swal({
                                  title: "Advertência!",
                                  text: Msg,
                                  type: "warning",
                                  closeOnConfirm: true // ou mesmo sem isto
                              }, function() {
                                $("#CodFor").val("");
                                $("#CgcCpf").val("");
                              });
                      }


                    }


                    });

                   

           }
       }  

      };


//Funcoes Modal Código Barras
function incluircodigobarras(){
    var CodBar = $('#TitBan').val();
    $('#CodBar').val(CodBar);
    
}


$('#CodigoBarras').on('shown.bs.modal', function(event) {
  $("#TitBan").focus();
  var CodBar = $('#CodBar').val();
    $('#TitBan').val(CodBar);
})


//*----*

$("#TipTit").focusout(function(){     
    consultarTitulo();
});
      //Consulta de Titulo
  function consultarTitulo(){
                     var json = ConvertFormToJSON("#TituloPagar");
                     var Form = this;
                     var CodFor = $('#CodFor').val();

                     
                     

                    
           if ((CodFor !='')|| (CodFor != undefined) || (CodFor != null)){
                    
                   $('#loading').modal('show');

                   	$.ajax({


                   			type: "GET",
                   			dataType : "json",
                   		  data : json,
                   		  context : Form,
                   			url: "/consulta/titulo/pagar/" +{CodFor : CodFor} ,

                   			success: function(Retorno) {
                            var status = (Retorno.Status);

                            if(status == "OK"){
                                  $('#SitTit').val(Retorno.SitTit);
                                  $('#CodCcu').val(Retorno.CodCcu);
                                  $('#DtaEnt').val(Retorno.DtaEnt);
                                  $('#DtaVct').val(Retorno.DtaVct);
                                  $('#ProPag').val(Retorno.ProPag);
                                  $('#VlrOri').val(Retorno.VlrOri);
                                  $('#VlrJur').val(Retorno.VlrJur);
                                  $('#VlrMul').val(Retorno.VlrMul);
                                  $('#VlrDes').val(Retorno.VlrDes);
                                  $('#VlrPag').val(Retorno.VlrPag);
                                  $('#CodPor').val(Retorno.CodPor);
                                  $('#CodCar').val(Retorno.CodCar);
                                  $('#CodBan').val(Retorno.CodBan);
                                  $('#AgeCta').val(Retorno.AgeCta);
                                  $('#NumCta').val(Retorno.NumCta);
                                  $('#CodBar').val(Retorno.CodBar);
                                  $('#CtrInt').val(Retorno.CtrInt);
                                  $('#NumRem').val(Retorno.NumRem);
                                  $('#OrdCom').val(Retorno.OrdCom);
                                  $('#NumNfe').val(Retorno.NumNfe);
                                  $('#SerNfe').val(Retorno.SerNfe);
                                  $('#DtaApr').val(Retorno.DtaApr);

                                  $('#DtaEnt').prop('readonly', true);
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
  $('#TituloPagar').each (function(){
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
  $("#VlrDes").maskMoney({
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
  $("#VlrApr").maskMoney({
            decimal: ",",
            thousands: ".",
            precision: 2
  });


  function chamacodigobarras(){
    $('#CodigoBarras').modal('show');

  }

 </script>



@stop

@section('content')

<!--Inicio-->
<center>
  <h3> Entrada / Manutenção Titulo Pagar</h3>
</center>



<div>
<body>

<form class="form"  id="TituloPagar" method="post"  action="">


{!! csrf_field() !!}




<div class"container">

<div class="row">

        <div class="col-md-2">
              <label for="CodEmp">Código </label>
              <input class="form-control" type="text" id="CodFor" name="CodFor" placeholder="Código Fornecedor" />
        </div>
		

        <div class="col-md-3">
            <label for="GruEmp">* CNPJ / CPF Fornecedor </label>
            <input class="form-control" type="text" id="CgcCpf" autocomplete="off" autofocus name="CgcCpf" placeholder="CNPJ / CPF"  >
        </div>


          <div class="col-md-5">
						<label for="NomFan">* Razão Social </label>
						<input class="form-control" type="text" id="RazSoc" name="RazSoc" placeholder="Nome Completo / Razão Social" disabled/>
			    </div>

					

  </div>
  
    <div class="row">

        <div class="col-md-3">
          <label for="CodEmp"> Título </label>
         
              <input class="form-control" type="text" id="NumTit" name="NumTit" placeholder="Título" />
            
        </div>


        <div class="col-md-2">
                        <div class="form-group">
                            <label for="TipTit">Tipo</label>
                            <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="TipTit" name="TipTit" required>
                                <option value="01" disabled selected >Selecione ... </option>
                               
                            </select>
                        </div>
          </div>

          <div class="col-md-2">
                        <div class="form-group">
                            <label for="SitTit">Situação</label>
                            <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="SitTit" name="SitTit" required>
                                <option selected value="AB">Aberto Normal</option>
                                <option value="AC" disabled >Aberto Cartório</option>
                                <option value="AI" disabled >Aberto Imposto</option>
                                <option value="AJ" disabled >Aberto Júridico</option>
                                <option value="AX" >Aberto Externo</option>
                                <option value="CA" >Cancelado</option>
                                <option value="LQ" disabled >Liquidado</option>
                                <option value="PE" disabled >Pagamento Eletrônico</option>
                            </select>
                        </div>
          </div>

    </div>


    <div class="row">

      <div class="col-md-2">
        <label for="CodTri">Código Tributação Darfe </label>
      
            <input class="form-control" type="text" id="TriDar" name="TriDar" placeholder="Código Tributação Darfe" />
          
      </div>
   
        <div class="col-md-3">
            <label for="GruEmp">* Centro de Custo </label>
            <input class="form-control" type="text" id="CodCcu" autocomplete="off"  name="CodCcu" placeholder="Centro de Custo"  >
        </div>


          <div class="col-md-5">
            <label for="NomFan">Descrição </label>
            <input class="form-control" type="text" id="DesCcu" name="DesCcu" placeholder="Descrição" disabled/>
          </div>
  </div>

  <div class="row">
                      <div class="col-md-2">
                              <label for="GruEmp">*Data Entrada</label>
                              <input class="form-control" type="date" id="DtaEnt" name="DtaEnt"  placeholder="Data Entrada"  />
                      </div>

                      <div class="col-md-2">
                              <label for="GruEmp">*Data Vencimento</label>
                              <input class="form-control" type="date" id="DtaVct" name="DtaVct"  placeholder="Data Vencimento"  />
                      </div>

                      <div class="col-md-2">
                              <label for="GruEmp">*Data Provável Pagamento</label>
                              <input class="form-control" type="date" id="ProPag" name="ProPag"  placeholder="Provável Pagamento"  />
                      </div>

                      <div class="col-md-2">
                              <label for="GruEmp">Data Aprovação</label>
                              <input class="form-control" type="date" id="DtaApr" name="DtaApr"  placeholder="Data Aprovação"  disabled/>
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
                                        <label for="VIcmSt"> Desconto</label>
                                        <input class="form-control" type="text" id="VlrDes" name="VlrDes"  placeholder="Desconto" />
                                    </div>

                                    <div class="col-md-2">
                                        <label for="TotPro"> Valor Pagar </label>
                                        <input class="form-control" type="text" id="VlrPag" name="VlrPag"   placeholder="Valor Pagar" readonly />
                                      </div>


                                  </div>


                


  <div class="row">
        <div class="col-md-3">
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
            <label for="CodCar">* Carteira </label>
            <input class="form-control" type="text" id="CodCar" name="CodCar" placeholder="Carteira" />
        </div>

        <div class="col-md-3">
                        <div class="form-group">
                            <label for="CodBan">Banco</label>
                            <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="CodBan" name="CodBan" required>
                                <option selected  disabled value="SE">Selecione...</option>
                            </select>
                        </div>
          </div>


        <div class="col-md-2">
             <label for="CodEmp">Agência </label>
              <input class="form-control" type="text" id="AgeCta" name="AgeCta" placeholder="Agência" readonly/>
        </div>

        <div class="col-md-2">
             <label for="CodEmp">Conta </label>
              <input class="form-control" type="text" id="NumCta" name="NumCta" placeholder="Conta" readonly />
        </div>


    </div>

    <div class="row">

    

        <div class="col-md-5">
                      <label for="CodBar">Código Barras </label>
                      <div class="input-group">
                          <input class="form-control" type="text" id="CodBar" name="CodBar" maxlength="48"    placeholder="Código" readonly />
                          <div class="input-group-btn">
                           

                             <button class="btn btn-info"  id="btnCodigoBarras" type="button" onclick="chamacodigobarras()">
                                   <span class="fa fa-barcode"></span>
                            </button>
                           </div>
                         </div>
        </div>
     
        <div class="col-md-2">
          <label for="CtlInt">Controle Interno</label>
         
              <input class="form-control" type="text" id="CtrInt" name="CtrInt" placeholder="Controle Interno" readonly />
            
        </div>

        <div class="col-md-2">
          <label for="NumRem">Remesa</label>
         
              <input class="form-control" type="text" id="NumRem" name="NumRem" placeholder="Remesa" readonly />
            
        </div>

    </div>

    <div class="row">

        <div class="col-md-3">
          <label for="OrdCom">Ordem de Compra</label>
         
              <input class="form-control" type="text" id="OrdCom" name="OrdCom" placeholder="Ordem de Compra" readonly  />
            
        </div>

        <div class="col-md-3">
          <label for="NumNfe">Nota Fiscal</label>
         
              <input class="form-control" type="text" id="NumNfe" name="NumNfe" placeholder="Nota Fiscal" readonly />
            
        </div>

        <div class="col-md-3">
          <label for="SerNfe">Série</label>
         
              <input class="form-control" type="text" id="SerNfe" name="SerNfe" placeholder="Série" readonly />
            
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
              <button  name="btnsalvar" id="btnsalvar"   type="button" class="btn btn-primary btn-sm custom-button-width .navbar-right" onclick="salvar()"><i class="fa fa-check" aria-hidden="true"></i> Salvar</button>
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


<div class="modal fade" id="CodigoBarras" tabindex="-1" role="dialog" aria-labelledby="alterarLabel" style="z-index: 1100;" data-backdrop="static" >
    <div class="modal-dialog" role="document">
       <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title"><label> Informe o Código de Barras abaixo</label></h4>
           </div>
            <div class="modal-body">
                 <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="text" id="TitBan" name="TitBan" maxlength="48" autocomplete="off" autofocus placeholder="Código de Barras"/>
                      </div> 
                </div>
                 <br>
                <div class="container-fluid">
                      <div class="row">
                          <div class="col-md-12 text-right">
                              <button  name="btnCodigoBarras" id="btnCodigoBarras"   type="button" class="btn btn-primary btn-sm custom-button-width .navbar-right"  data-dismiss="modal" onclick="incluircodigobarras()"><i class="fa fa-check" aria-hidden="true"></i> Incluir</button>
                          </div>
                      </div>
                </div>
            </div>
       </div>  
 </div>  

 



@stop
