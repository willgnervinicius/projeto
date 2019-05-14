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

    $(document).on('click', '.bestornartitulo', function(e) {
        e.preventDefault;
        var CodFor = $(this).closest('tr').find('td[data-codfor]').data('codfor');
        var NumTit = $(this).closest('tr').find('td[data-numtit]').data('numtit');
        var TipTit = $(this).closest('tr').find('td[data-tiptit]').data('tiptit');
       

          estornar(CodFor,NumTit,TipTit);
        
        
      
        
    }); 

    
});

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


function somenteNumeroDecimal(objTextBox, e) {
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    if (e.which) {
        var whichCode = e.which;
    } else {
        var whichCode = e.keyCode;
    }
    if ((whichCode == 13) || (whichCode == 0) || (whichCode == 8)) return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida
    len = objTextBox.value.length;
    for (i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != ",")) break;
    aux = '';
    for (; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i)) != -1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0' + "," + '0'  + aux;
    if (len == 2) objTextBox.value = '0' + "," + '0' + '0' + aux;
    if (len == 3) objTextBox.value = '0' + "," + aux;
    if (len > 3 && len < 13) {
        aux2 = '';
        for (j = 0, i = len - 4; i >= 0; i--) {
            if (j == 3) {
                aux2 += ".";
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len3 = aux2.length;
        for (i = len3 - 1; i >= 0; i--)
            objTextBox.value += aux2.charAt(i);
        objTextBox.value += "," + aux.substr(len - 3, len);
    }
    return false;
}

function somenteNumeroDecimalDuasCasasaposvirgula(objTextBox, e) {
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    if (e.which) {
        var whichCode = e.which;
    } else {
        var whichCode = e.keyCode;
    }
    if ((whichCode == 13) || (whichCode == 0) || (whichCode == 8)) return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida
    len = objTextBox.value.length;
    for (i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != ",")) break;
    aux = '';
    for (; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i)) != -1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0' + "," + '0' + aux;
    if (len == 2) objTextBox.value = '0' + "," + aux;
    if (len > 2 && len < 13) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += ".";
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
            objTextBox.value += aux2.charAt(i);
        objTextBox.value += "," + aux.substr(len - 2, len);
    }
    return false;
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

                
                 if (Tipo == 'B'){
                          if((Titulo != '') || (Titulo == '') || (Portador != '') || (Portador == '') && (DataInicial != '') && (DataFinal !='') ) {
                                    $("#baixatitulo td").remove();
                                    $.ajax({
                                          url: "/consulta/titulo/baixa/a/pagar/"+{CodFor : 1} , 
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
                                                                      cols += '<td  data-codfor="'+obj.CodFor+'" codfor attr data->'+obj.CodFor+'</td>';	 
                                                                      cols += '<td>'+obj.NomFor+'</td>';	 
                                                                      cols += '<td  data-numtit="'+obj.NumTit+'" numtit attr data-">'+obj.NumTit+'</td>';	  
                                                                      cols += '<td  data-tiptit="'+obj.TipTit+'" tiptit attr data-">'+obj.DesTip+'</td>';	     
                                                                      cols += '<td>'+obj.DtaVct+'</td>';	   
                                                                      cols += '<td>'+obj.VlrPag+'</td>';	 
                                                                      cols += '<td> <input type="text" id="VlrPgt"   name="VlrPgt" onkeypress="return somenteNumeroDecimalDuasCasasaposvirgula(this,event);"  value='+obj.VlrPag+'></td>';  
                                                                      cols += '<td> <input type="date" id="DtaPgt"   name="DtaPgt"    value='+obj.DtaPgt+'></td>';  
                                                                    
                                                                      cols += '<td>'+obj.CodPor+'</td>';
                                                                      cols += '<td> <button  name="bbaixartitulo"   type="button"   class="btn btn-default btn-sm custom-button-width .navbar-right  bbaixartitulo"><i class="fa fa-check" aria-hidden="true"></i></button></td>';

                                                                      
                                                      
                                                                      newRow.append(cols);	
                                                                      
                                                                      $("#baixatitulo").append(newRow);

                                                                    
                                                              }    

                                                      });
                                                    }     

                                  
                                          });


                          } 
                 }else{
                    if ((Titulo != '') || (Titulo == '') || (Portador != '') || (Portador == '') && (DataInicial != '') && (DataFinal !='') && (Tipo == 'E')){
                                  $("#baixatitulo td").remove();
                                  $.ajax({
                                                url: "/consulta/titulo/baixa/a/pagar/"+{CodFor : 1} , 
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
                                                                                    cols += '<td  data-codfor="'+obj.CodFor+'" codfor attr data->'+obj.CodFor+'</td>';	 
                                                                                    cols += '<td>'+obj.NomFor+'</td>';	 
                                                                                    cols += '<td  data-numtit="'+obj.NumTit+'" numtit attr data-">'+obj.NumTit+'</td>';	  
                                                                                    cols += '<td  data-tiptit="'+obj.TipTit+'" tiptit attr data-">'+obj.DesTip+'</td>';	     
                                                                                    cols += '<td>'+obj.DtaVct+'</td>';	   
                                                                                    cols += '<td>'+obj.VlrPag+'</td>';	 
                                                                                    cols += '<td>'+obj.VlrPag+'</td>';	 
                                                                                    cols += '<td>'+obj.DtaPgt+'</td>';	 
                                                                                  
                                                                                  
                                                                                    cols += '<td>'+obj.CodPor+'</td>';
                                                                                    cols += '<td> <button  name="bestornartitulo"   type="button"   class="btn btn-default btn-sm custom-button-width .navbar-right  bestornartitulo"><i class="fa fa-check" aria-hidden="true"></i></button></td>';

                                                                                    
                                                                    
                                                                                    newRow.append(cols);	
                                                                                    
                                                                                    $("#baixatitulo").append(newRow);

                                                                            }
                                                                          

                                                            });
                                                          }     

                                        
                                                });


                                }
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
             var json = ConvertFormToJSON("#BaixaTituloPagar");
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
<form class="form"  id="BaixaTituloPagar" method="post"  action="">

  {{csrf_field() }}

<div class="container-fluid">
  <div class="row"  rows="50">
  	<div class="col-md-12 ">
          <div class="panel panel-info">
              <div class="panel-heading">
                <h3> Baixa de Títulos Manual </h3>
                <div class="row">

                      <div class="col-md-2">
                        <div class="form-group">
                            <label for="SitBai">* Opções</label>
                            <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="SitBai" name="SitBai" required>
                                <option selected value="B">Baixar</option>
                                <option value="E" >Estornar</option>
                            </select>
                        </div>
                     </div>

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
                  <th>Fornecedor</th>
                  <th>Título </th>
                  <th>Tipo </th>
                  <th>Vencimento</th>
                  <th>Valor</th>
                  <th>Valor Pago</th>
                  <th>Data Baixa</th>
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



</form>

@stop
