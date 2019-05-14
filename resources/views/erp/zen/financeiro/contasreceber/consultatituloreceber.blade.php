@extends('adminlte::page')

@section('title', 'Cronus (ERP) - Baixa Manual Título Pagar')

@section('content_header')
@stop

@section('css')

<link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">
<link href="{{ asset('css/estilos.css') }}" rel="stylesheet">

@stop 

@section('js')

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.maskMoney.js') }}"></script>


<script  type="text/javascript">

$(function(){
    $(document).on('click', '.bbaixartitulo', function(e) {
        e.preventDefault;
        var CodFor = $(this).closest('tr').find('td[data-codfor]').data('codfor');
        var NumTit = $(this).closest('tr').find('td[data-numtit]').data('numtit');
        var TipTit = $(this).closest('tr').find('td[data-tiptit]').data('tiptit');
        var DtaPgt = $(this).closest('tr').find('input[name=DtaPgt]').val();
        var VlrPgt = $(this).closest('tr').find('input[name=VlrPgt]').val();

        if((DtaPgt == '') | (DtaPgt == null) | (DtaPgt == undefined)){
         
        }else if((VlrPgt == '') | (VlrPgt == null) | (VlrPgt == undefined)){
          
        } else {
          baixar(CodFor,NumTit,TipTit,DtaPgt,VlrPgt);
        }
	    
        
      
        
    }); 

    $(document).on('click', '.bbaixar', function(e) {
        e.preventDefault;
        var CodCli = $(this).closest('tr').find('td[data-codcli]').data('codcli');
        var NumTit = $(this).closest('tr').find('td[data-numtit]').data('numtit');
        var TipTit = $(this).closest('tr').find('td[data-tiptit]').data('tiptit');
       
        

        $('#cliente').val(CodCli);
        $('#titulo').val(NumTit);
        $('#tipo').val(TipTit);

        baixarboleto();
        
        
      
        
    }); 


    $(document).on('click', '.benviaremail', function(e) {
        e.preventDefault;
        var CodCli = $(this).closest('tr').find('td[data-codcli]').data('codcli');
        var NumTit = $(this).closest('tr').find('td[data-numtit]').data('numtit');
        var TipTit = $(this).closest('tr').find('td[data-tiptit]').data('tiptit');
       
        

        $('#cliente').val(CodCli);
        $('#titulo').val(NumTit);
        $('#tipo').val(TipTit);

        
        email();
        
      
        
    }); 

    
});


function email(){
  $('#InformeEmail').modal('show');
}


$('#InformeEmail').on('shown.bs.modal', function(event) {
     $('#IntNet').focus();
})


//Funcoes Modal Código Barras
function incluiremail(){
    var Email = $('#IntNet').val();
    $('#email').val(Email);
    enviarboleto();
    
}

$(document).ready(function(){
    var date = new Date();

    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var today = year + "-" + month + "-" + day;       
    $("#DtaIni").attr("value", today);
    $("#DtaFim").attr("value", today);

    

});

function enviarboleto(){
        var Cliente = $('#cliente').val();
        var Titulo = $('#titulo').val();
        var Tipo =  $('#tipo').val();
        var Email = $('#email').val();

        $('#loading').modal('show');


        var dadosajax = {
                                "_token": "{{ csrf_token() }}",
                                'CodCli' : Cliente,
                                'NumTit' : Titulo,
                                'TipTit' : Tipo,
                                'IntNet' : Email,
                        }


                $.ajax({
                        url: '/enviar/boleto',
                        data: dadosajax,
                        type: 'POST',
                        cache: false,
                        success: function(Retorno) {
                                var status = (Retorno.Status);

                                if(status == 'Er'){
                                    var Msg = (Retorno.Mensagem);
                                    $('#loading').modal('hide');
                                    swal("Atenção",$Msg, "error");
                                } else {
                                  $('#loading').modal('hide');
                                  var Msg = (Retorno.Mensagem);
                                  swal({
                                                title: "Envio de Segunda via de Boleto",
                                                text: Msg,
                                                type: "warning",
                                                showCancelButton: false,
                                                confirmButtonColor: '#063370',
                                                confirmButtonText: 'OK',
                                                closeOnConfirm: true,
                                                closeOnCancel: false
                                            },
                                            function(isConfirm){

                                                    if (isConfirm){
                                                      
                                                      consultar();

                                                      swal.close();

                                                    } 
                                            });

                                  
                                }

                        }
              });
        




              

}

function baixarboleto(){
        var Cliente = $('#cliente').val();
        var Titulo = $('#titulo').val();
        var Tipo =  $('#tipo').val();
        var Email = $('#email').val();

        var MSG = 'Deseja baixar o Título' . Titulo;

        swal({
              title: "Confirmação de Baixa de Título",
              text: "Deseja Baixar o Título " + Titulo + '?',
              type: "warning",
              confirmButtonColor: '#063370',
              confirmButtonText: 'Sim',
              showCancelButton: true,
              cancelButtonText: 'Não',
              closeOnConfirm: false,
              closeOnCancel: false
        },
          function(isConfirm){
            if (isConfirm){
              swal.close();
              var dadosajax = {
                                "_token": "{{ csrf_token() }}",
                                'CodCli' : Cliente,
                                'NumTit' : Titulo,
                                'TipTit' : Tipo,
                                'IntNet' : Email,
                              }

                              $.ajax({
                              url: '/baixar/boleto',
                              data: dadosajax,
                              type: 'POST',
                              cache: false,
                              success: function(Retorno) {
                                      var status = (Retorno.Status);

                                      if(status == 'Er'){
                                          var Msg = (Retorno.Mensagem);
                                          $('#loading').modal('hide');
                                          swal("Atenção",$Msg, "error");
                                      } else {
                                        $('#loading').modal('hide');
                                        var Msg = (Retorno.Mensagem);
                                        swal({
                                                      title: "Baixa Manual de Boleto",
                                                      text: Msg,
                                                      type: "warning",
                                                      showCancelButton: false,
                                                      confirmButtonColor: '#063370',
                                                      confirmButtonText: 'OK',
                                                      closeOnConfirm: true,
                                                      closeOnCancel: false
                                                  },
                                                  function(isConfirm){

                                                          if (isConfirm){
                                                            consultar();
                                                            swal.close();

                                                          } 
                                                  });

                                        
                                      }

                              }
                    });

           } 
        });

      

}

function mascaraData(val) {
  var pass = val.value;
  var expr = /[0123456789]/;

  for (i = 0; i < pass.length; i++) {
    // charAt -> retorna o caractere posicionado no índice especificado
    var lchar = val.value.charAt(i);
    var nchar = val.value.charAt(i + 1);

    if (i == 0) {
      // search -> retorna um valor inteiro, indicando a posição do inicio da primeira
      // ocorrência de expReg dentro de instStr. Se nenhuma ocorrencia for encontrada o método retornara -1
      // instStr.search(expReg);
      if ((lchar.search(expr) != 0) || (lchar > 3)) {
        val.value = "";
      }

    } else if (i == 1) {

      if (lchar.search(expr) != 0) {
        // substring(indice1,indice2)
        // indice1, indice2 -> será usado para delimitar a string
        var tst1 = val.value.substring(0, (i));
        val.value = tst1;
        continue;
      }

      if ((nchar != '/') && (nchar != '')) {
        var tst1 = val.value.substring(0, (i) + 1);

        if (nchar.search(expr) != 0)
          var tst2 = val.value.substring(i + 2, pass.length);
        else
          var tst2 = val.value.substring(i + 1, pass.length);

        val.value = tst1 + '/' + tst2;
      }

    } else if (i == 4) {

      if (lchar.search(expr) != 0) {
        var tst1 = val.value.substring(0, (i));
        val.value = tst1;
        continue;
      }

      if ((nchar != '/') && (nchar != '')) {
        var tst1 = val.value.substring(0, (i) + 1);

        if (nchar.search(expr) != 0)
          var tst2 = val.value.substring(i + 2, pass.length);
        else
          var tst2 = val.value.substring(i + 1, pass.length);

        val.value = tst1 + '/' + tst2;
      }
    }

    if (i >= 6) {
      if (lchar.search(expr) != 0) {
        var tst1 = val.value.substring(0, (i));
        val.value = tst1;
      }
    }
  }

  if (pass.length > 10)
    val.value = val.value.substring(0, 10);
  return true;
}



function ConvertFormToJSON(form){
            var array = jQuery(form).serializeArray();
            var json = {};

            jQuery.each(array, function() {
                    json[this.name] = this.value || '';
            });

            
            return json;
}






 function consultar(){
                var Titulo = $('#NumTit').val();
                var Portador = $('#CodPor').val();
                var DataInicial = $('#DtaIni').val();
                var DataFinal = $('#DtaFim').val();
                var Tipo = $('#SitBai').val();

                var dadosajax = {
                        "_token": "{{ csrf_token() }}",
                        'CodPor' : Portador,
                        'NumTit' : Titulo,
                        'DtaIni' : DataInicial,
                        'DtaFim' : DataFinal,
                        'SitBai' : Tipo,
                        
                }

                $("#baixatitulo td").remove();

                
                
                if ((Titulo != '') || (Titulo == '') || (Portador != '') || (Portador == '') && (DataInicial != '') && (DataFinal !='') && (Tipo == 'E')){
                                  $("#baixatitulo td").remove();
                                  $.ajax({
                                                url: "/buscar/titulos/receber/"+{CodCli : 1} , 
                                                type: "GET",
                                                dataType : "json",
                                                data : dadosajax,

                                                success: function(Retorno) {
                                                        var status = (Retorno.Status);

                                                
                                                            $.each(Retorno, function(i, obj){
                                                                            var Situacao = obj.Status;
                                                                            
                                                                            if(Situacao == 'OK'){
                                                                            
                                                                                    var newRow = $("<tr>");	    
                                                                                    var cols = "";	
                                                                                    cols += '<td  data-codcli="'+obj.CodCli+'" codcli attr data->'+obj.CodCli+'</td>';	 
                                                                                    cols += '<td>'+obj.NomCli+'</td>';	 
                                                                                    cols += '<td  data-numtit="'+obj.NumTit+'" numtit attr data-">'+obj.NumTit+'</td>';	  
                                                                                    cols += '<td  data-tiptit="'+obj.TipTit+'" tiptit attr data-">'+obj.DesTip+'</td>';	 
                                                                                    cols += '<td>'+obj.SitTit+'</td>';	    
                                                                                    cols += '<td>'+obj.DtaVct+'</td>';	   
                                                                                    cols += '<td>'+obj.VlrRec+'</td>';	   
                                                                                      
                                                                                 	 
                                                                                  
                                                                                  
                                                                                    cols += '<td>'+obj.CodPor+'</td>';

                                                                                  if((obj.SitTit == 'CA') || (obj.SitTit=='LQ')){
                                                                                        cols += '<td> <button  name="btitulo"   type="button"  data-toggle="tooltip" data-placement="top" title="Editar"   class="btn btn-primary btn-sm custom-button-width .navbar-right  btitulo"><i class="fa fa-pencil" aria-hidden="true"></i></button> '
                                                                                                  +' <button  name="benviaremail"   type="button"  data-toggle="tooltip" data-placement="top" title="Enviar Boleto por E-mail"   class="btn btn-success btn-sm custom-button-width .navbar-right  benviaremail" disabled><i class="fa fa-envelope" aria-hidden="true"></i></button>'
                                                                                                  +' <button  name="bbaixar"   type="button"  data-toggle="tooltip" data-placement="top" title="Baixar"   class="btn btn-danger btn-sm custom-button-width .navbar-right  bbaixar" disabled><i class="fa fa-arrow-circle-o-down"  aria-hidden="true"></i></button></td>';

                                                                                    } else {
                                                                                          cols += '<td> <button  name="btitulo"   type="button"  data-toggle="tooltip" data-placement="top" title="Editar"   class="btn btn-primary btn-sm custom-button-width .navbar-right  btitulo"><i class="fa fa-pencil" aria-hidden="true"></i></button> '
                                                                                                +' <button  name="benviaremail"   type="button"  data-toggle="tooltip" data-placement="top" title="Enviar Boleto por E-mail"   class="btn btn-success btn-sm custom-button-width .navbar-right  benviaremail"><i class="fa fa-envelope" aria-hidden="true"></i></button>'
                                                                                                +' <button  name="bbaixar"   type="button"  data-toggle="tooltip" data-placement="top" title="Baixar"   class="btn btn-danger btn-sm custom-button-width .navbar-right  bbaixar"><i class="fa fa-arrow-circle-o-down"  aria-hidden="true"></i></button></td>';


                                                                                    }
                                                                                    
                                                                                    
                                                                    
                                                                                    newRow.append(cols);	
                                                                                    
                                                                                    $("#baixatitulo").append(newRow);

                                                                            }
                                                                          

                                                            });
                                                          }     

                                        
                                                });


                               
                }

   };


                     

$("#CodPor").focusout(function(){
  consultarPortador();
});


$("#NumTit").focusout(function(){
      var NumTit = $('#NumTit').val();

      if (NumTit != ''){
        $('#CodPor').val('');
        $('#DesPor').val('');
      }
      
});


//Consulta de Fornecedor
function consultarPortador(){
             var CodPor = $('#CodPor').val();
             var dadosajax = {
                                "_token": "{{ csrf_token() }}",
                                'CodPor' : CodPor,
                        }



            
          if ((CodPor =='')|| (CodPor == undefined) || (CodPor == null)){
                return false ;
          } else {
                    $.ajax({
                      url: "/consulta/cadastro/portador/" +{CodPor : CodPor} ,
                      data: dadosajax,
                      type: 'GET',
                      cache: false,


                        success: function(RetornaPortador) {
                            var status = (RetornaPortador.Status);

                            if(status=="ER"){
                                var Msg = (RetornaPortador.Msg);


                                swal({
                                        title: "Advertência!",
                                        text: Msg,
                                        type: "warning",
                                        closeOnConfirm: true // ou mesmo sem isto
                                    }, function() {
                                    
                                      
                                      
                                    
                                    });
                                    $("#CodPor").val("");
                                    
                            } else if(status == "OK"){
                              $("#DesPor").val(RetornaPortador.NomPor);
                            }


                        }


             });

   }   

};





function baixar(CodFor,NumTit,TipTit,VlrPgt,DtaPgt){
        var Fornecedor = CodFor;
        var Titulo = NumTit;
        var Tipo = TipTit;
        var ValorPago = VlrPgt;
        var DataPagamento = DtaPgt;
        var SitBai = $('#SitBai').val();

        
                var dadosajax = {
                                "_token": "{{ csrf_token() }}",
                                'CodFor' : Fornecedor,
                                'NumTit' : Titulo,
                                'TipTit' : Tipo,
                                'DtaPgt' : ValorPago,
                                'VlrPgt' : DataPagamento,
                                'SitBai' : SitBai,
                        }


                $.ajax({
                        url: '/baixa/titulo/pagar',
                        data: dadosajax,
                        type: 'POST',
                        cache: false,
                        success: function(Retorno) {
                                var status = (Retorno.Status);

                                if(status == 'Erro'){
                                    var Msg = (Retorno.Mensagem);
                                    swal("Atenção","Título não Baixado", "error");
                                } else {
                                  consultar();
                                }

              }
              });
        

}


function estornar(CodFor,NumTit,TipTit){
        var Fornecedor = CodFor;
        var Titulo = NumTit;
        var Tipo = TipTit;
        var SitBai = $('#SitBai').val();

        
                var dadosajax = {
                                "_token": "{{ csrf_token() }}",
                                'CodFor' : Fornecedor,
                                'NumTit' : Titulo,
                                'TipTit' : Tipo,
                                'SitBai' : SitBai,
                        }


                $.ajax({
                        url: '/baixa/titulo/pagar',
                        data: dadosajax,
                        type: 'POST',
                        cache: false,
                        success: function(Retorno) {
                                var status = (Retorno.Status);

                                if(status == 'Erro'){
                                    var Msg = (Retorno.Mensagem);
                                    swal("Atenção","Baixa de Título não Estornada", "error");
                                } else {
                                  consultar();
                                }

              }
              });
        

}




</script>


@stop

@section('content')
<form class="form"  id="ConsultaTituloReceber" method="post"  action="">

  {{csrf_field() }}

<div class="container-fluid">
  <div class="row"  rows="50">
  	<div class="col-md-12 ">
          <div class="panel panel-info">
              <div class="panel-heading">
                <h3> Consulta de Títulos a Receber </h3>
                <div class="row">

                     <div class="col-md-1 ">
                        <label for="inputEmail4"> Portador  </label>
                        <input class="form-control" type="text" id="CodPor" name="CodPor" placeholder="Portador" />
                      </div>

                      <div class="col-md-2 ">
                       <label for="inputEmail4"> Descrição </label>
                       <input class="form-control" type="text" id="DesPor" name="DesPor" placeholder="Descrição Portador"  disabled/>
                     </div>

                     
                     <div class="col-md-2 ">
                       <label for="inputEmail4"> Título </label>
                       <input class="form-control" type="text" id="NumTit" name="NumTit" placeholder="Título" />
                     </div>


                      <div class="col-md-2 ">
                        <label for="inputEmail4"> * Data Inicial  </label>
                        <input class="form-control" type="date" id="DtaIni" name="DtaIni" placeholder="Vencimento Inicial" />
                      </div>

                      <div class="col-md-2 ">
                        <label for="inputEmail4"> * Data Final  </label>
                        <input class="form-control" type="date" id="DtaFim" name="DtaFim" placeholder="Vencimento Final" />
                      </div>  
            </div>

               
           

               <div class="row">
                   <div class="col-md-12 ">
                       <h5> * Informe apenas um Filtro para Consulta </h5>
                   </div>
               </div>

               

               

                <div class="container-fluid">
                      <div class="row">
                          <div class="col-md-11 text-right">
                            <button  name="btnsalvar"   type="button" onclick="consultar()" class="btn btn-primary btn-sm custom-button-width .navbar-right"><i class="fa fa-search" aria-hidden="true"></i> Consultar</button>

                           </div>
                      </div>
                </div>






</div>
<div class="panel-body">
  <div class="row ">
    <div class="table-responsive">
              <table id="baixatitulo" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Código</th>
                  <th>Cliente</th>
                  <th>Título </th>
                  <th>Tipo </th>
                  <th>Situação </th>
                  <th>Vencimento</th>
                  <th>Valor</th>
                  <th>Portador</th>
                  <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                

                </tbody>

              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      </div>



</div>

<input type="hidden" name="email" id="email"/>
<input type="hidden" name="cliente" id="cliente"/>
<input type="hidden" name="titulo" id="titulo"/>
<input type="hidden" name="tipo" id="tipo"/>

</form>




<div class="modal fade" id="InformeEmail" tabindex="-1" role="dialog" aria-labelledby="alterarLabel" style="z-index: 1100;" data-backdrop="static" >
    <div class="modal-dialog" role="document">
       <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title"><label> Informe o E-mail abaixo para enviar o Boleto</label></h4>
           </div>
            <div class="modal-body">
                 <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="email" id="IntNet" name="IntNet"  autocomplete="off" autofocus placeholder="E-mail"/>
                      </div> 
                </div>
                 <br>
                <div class="container-fluid">
                      <div class="row">
                          <div class="col-md-12 text-right">
                              <button  name="btnEmailBoleto" id="btnEmailBoleto"   type="button" class="btn btn-primary btn-sm custom-button-width .navbar-right"  data-dismiss="modal" onclick="incluiremail()"><i class="fa fa-check" aria-hidden="true"></i> Enviar </button>
                          </div>
                      </div>
                </div>
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
