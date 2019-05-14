@extends('adminlte::page')

@section('title', 'Cronus (ERP) - Aprovação de Título Pagar')

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

$(document).ready(function(){
    var date = new Date();

    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var today = year + "-" + month + "-" + day;       
    $("#ProPgt").attr("value", today);
    $("#VctIni").attr("value", today);
    $("#VctFim").attr("value", today);

    

});

document.getElementById("estorno").style.display = "none";
document.getElementById("msgestorno").style.display = "none";




$("#SitApr").focusout(function(){
         var SituacaoAprovacao = $('#SitApr').val();

         if(SituacaoAprovacao == 'A'){
          document.getElementById("estorno").style.display = "none";
          document.getElementById("aprovacao").style.display = "";
          document.getElementById("aprovar").style.display = "";
          document.getElementById("aprovardata").style.display = "";
          document.getElementById("msgaprovacao").style.display = "";
          document.getElementById("msgestorno").style.display = "none";
         } else if (SituacaoAprovacao == 'D'){
          document.getElementById("estorno").style.display = "";
          document.getElementById("aprovacao").style.display = "none";
          document.getElementById("aprovar").style.display = "none";
          document.getElementById("aprovardata").style.display = "none";
          document.getElementById("msgaprovacao").style.display = "none";
          document.getElementById("msgestorno").style.display = "";
         }
          

   });

  
$("#CodPor").focusout(function(){

        consultarPortador();
});

    //Consulta de Fornecedor
  function consultarPortador(){
                     var json = ConvertFormToJSON("#AprovacaoTituloPagar");
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
                                    
                            }


                   			}


                   	});

           }   

      };




$(function(){
    $(document).on('click', '.bbaixartitulo', function(e) {
        e.preventDefault;
        var CodFor = $(this).closest('tr').find('td[data-codfor]').data('codfor');
        var NumTit = $(this).closest('tr').find('td[data-numtit]').data('numtit');
        var TipTit = $(this).closest('tr').find('td[data-tiptit]').data('tiptit');
        var ProPgt = $(this).closest('tr').find('input[name=ProPgt]').val();
        var DtaApr = $(this).closest('tr').find('input[name=DtaApr]').val();
        var VlrApr = $(this).closest('tr').find('input[name=VlrApr]').val();
        var CodPor = $(this).closest('tr').find('input[name=PorPgt]').val();

        if((DtaApr == '') | (DtaApr == null) | (DtaApr == undefined)){
         
        }else if((VlrApr == '') | (VlrApr == null) | (VlrApr == undefined)){
          
        } else if((ProPgt == '') | (ProPgt == null) | (ProPgt == undefined)){

        } else if((CodPor == '') | (CodPor == null) | (CodPor == undefined)){

        } else {
            aprovar(CodFor,NumTit,TipTit,ProPgt,DtaApr,VlrApr,CodPor);
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

                     var json = ConvertFormToJSON("#AprovacaoTituloPagar");
                     var Form = this;
                     var CodPor = $('#CodPor').val();
                     var ProPgt = $('#ProPgt').val();
                     var VctIni = $('#VctIni').val();
                     var VctFim = $('#VctFim').val();

                     var SituacaoAprovacao = $('#SitApr').val();

                     if(SituacaoAprovacao == 'A'){
                            if((CodPor == '') | (CodPor == null) | (CodPor == undefined)){
                                 swal("Atenção","Código do Portador não informado.", "error");
                                 return false;
                            } else if((ProPgt == '') | (ProPgt == null) | (ProPgt == undefined)){
                                 swal("Atenção","Data de Pagamento não informado.", "error");
                                 return false;
                            } else if((VctIni == '') | (VctIni == null) | (VctIni == undefined)){
                                swal("Atenção","Data Inicial não informado.", "error");
                                return false;
                            } else if((VctFim == '') | (VctFim == null) | (VctFim == undefined)) {
                                 swal("Atenção","Data Final não informado.", "error");
                                 return false;
                            }
                     } else {
                            if((VctIni == '') | (VctIni == null) | (VctIni == undefined)){
                                swal("Atenção","Data Inicial não informado.", "error");
                                return false;
                            } else if((VctFim == '') | (VctFim == null) | (VctFim == undefined)) {
                                 swal("Atenção","Data Final não informado.", "error");
                                 return false;
                            }
                     }


                     if(SituacaoAprovacao == 'A' ){
                          $("#aprovacaotitulo td").remove();
                    
          
                            $.ajax({


                                type: "GET",
                                dataType : "json",
                                data : json,
                                context : Form,
                                url: "/consulta/titulo/aprovacao/pagar/" +{CodFor : 1} ,

                                
                                  success: function(Retorno) {
                                  
                                      $.each(Retorno, function(i, obj){
                                                      var Status = obj.Status;

                                                      if(Status == 'OK'){
                                                              var newRow = $("<tr>");	    
                                                              var cols = "";	
                                                              cols += '<td  data-codfor="'+obj.CodFor+'" codfor attr data->'+obj.CodFor+'</td>';	 
                                                              cols += '<td>'+obj.NomFor+'</td>';	 
                                                              cols += '<td  data-numtit="'+obj.NumTit+'" numtit attr data-">'+obj.NumTit+'</td>';	  
                                                              cols += '<td  data-tiptit="'+obj.TipTit+'" tiptit attr data-">'+obj.DesTit+'</td>';	 
                                                              cols += '<td> <input type="date" id="ProPgt"   name="ProPgt" maxlength="10"   value='+$('#ProPgt').val()+' readonly></td>';    	     
                                                              cols += '<td>'+obj.DtaVct+'</td>';	   
                                                              cols += '<td>'+obj.VlrPag+'</td>';	 
                                                              cols += '<td> <input type="text" id="VlrApr"   name="VlrApr" onkeypress="return somenteNumeroDecimalDuasCasasaposvirgula(this,event);"  value='+obj.VlrPag+'></td>';  
                                                              cols += '<td> <input type="date" id="DtaApr"   name="DtaApr" maxlength="10"   value='+obj.DtaApr+'></td>';  
                                                              cols += '<td> <input type="text" id="PorPgt"   name="PorPgt" maxlength="10"   value='+$('#CodPor').val()+' readonly></td>';  
                                                              cols += '<td> <button  name="bbaixartitulo"   type="button"   class="btn btn-default btn-sm custom-button-width .navbar-right  bbaixartitulo"><i class="fa fa-check" aria-hidden="true"></i></button></td>';

                                                              
                                              
                                                              newRow.append(cols);	
                                                              
                                                              $("#aprovacaotitulo").append(newRow);
                                                      }
                                                  
                                                  

                                      });
                                    }

                                          
                                });

                     } else if(SituacaoAprovacao == 'D'){
                            $("#estornoaprovacaotitulo td").remove();
                          
                
                          $.ajax({


                              type: "GET",
                              dataType : "json",
                              data : json,
                              context : Form,
                              url: "/consulta/titulo/aprovacao/pagar/" +{CodFor : 1} ,

                              
                                success: function(Retorno) {
                                
                                    $.each(Retorno, function(i, obj){
                                                    var Status = obj.Status;

                                                    if(Status == 'OK'){
                                                            var newRow = $("<tr>");	    
                                                            var cols = "";	
                                                            cols += '<td  data-codfor="'+obj.CodFor+'" codfor attr data->'+obj.CodFor+'</td>';	 
                                                            cols += '<td>'+obj.NomFor+'</td>';	 
                                                            cols += '<td  data-numtit="'+obj.NumTit+'" numtit attr data-">'+obj.NumTit+'</td>';	  
                                                            cols += '<td  data-tiptit="'+obj.TipTit+'" tiptit attr data-">'+obj.DesTit+'</td>';	    	     
                                                            cols += '<td>'+obj.DtaVct+'</td>';	   
                                                            cols += '<td>'+obj.VlrPag+'</td>';	 
                                                            cols += '<td>'+obj.DtaApr+'</td>';  
                                                            cols += '<td>'+obj.CodPor+'</td>';  
                                                            cols += '<td> <button  name="bestornartitulo"   type="button"   class="btn btn-default btn-sm custom-button-width .navbar-right  bestornartitulo"><i class="fa fa-check" aria-hidden="true"></i></button></td>';

                                                            
                                            
                                                            newRow.append(cols);	
                                                            
                                                            $("#estornoaprovacaotitulo").append(newRow);
                                                    }
                                                
                                                

                                    });
                                  }

                                        
                              });
                     }
                    
                 

                    

};




function aprovar(CodFor,NumTit,TipTit,ProPgt,DtaApr,VlrApr,CodPor){
        var Fornecedor = CodFor;
        var Titulo = NumTit;
        var Tipo = TipTit;
        var ValorAprovado = VlrApr;
        var DataAprovacao = DtaApr;
        var ProvavelPgt = ProPgt;
        var Portador = CodPor;

        var dadosajax = {
                        "_token": "{{ csrf_token() }}",
                        'CodFor' : Fornecedor,
                        'NumTit' : Titulo,
                        'TipTit' : Tipo,
                        'ProPgt' : ProvavelPgt,
                        'DtaApr' : DataAprovacao,
                        'VlrApr' : ValorAprovado,
                        'CodPor' : Portador,
                }


        $.ajax({
                url: '/aprovacao/titulo/pagar',
                data: dadosajax,
                type: 'POST',
                cache: false,
                success: function(Retorno) {
                        var status = (Retorno.Status);

                        if(status == 'Erro'){
                            var Msg = (Retorno.Mensagem);
                            swal("Atenção","Título não Aprovado", "error");
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
        

        var dadosajax = {
                        "_token": "{{ csrf_token() }}",
                        'CodFor' : Fornecedor,
                        'NumTit' : Titulo,
                        'TipTit' : Tipo,
                        
                }


        $.ajax({
                url: '/estornar/aprovacao/titulo/pagar',
                data: dadosajax,
                type: 'POST',
                cache: false,
                success: function(Retorno) {
                        var status = (Retorno.Status);

                        if(status == 'Erro'){
                            var Msg = (Retorno.Mensagem);
                            swal("Atenção","Título não Estornado", "error");
                        } else {
                          consultar();
                        }

       }
      });

}




</script>


@stop

@section('content')
<form class="form"  id="AprovacaoTituloPagar" method="post"  action="">

  {{csrf_field() }}

<div class="container-fluid">
  <div class="row"  rows="50">
  	<div class="col-md-12 ">
          <div class="panel panel-info">
              <div class="panel-heading">
                <h3> Aprovação de Títulos  </h3>
                

               <div class="row" >
                    <div class="col-md-2 " id="aprovar">
                            <label for="inputEmail4"> * Portador(Pagamento) </label>
                            <input class="form-control" type="text" id="CodPor" name="CodPor" placeholder="Portador" />
                     </div>
                     
                     <div class="col-md-2">
                        <div class="form-group">
                            <label for="SitApr">* Opções</label>
                            <select class="form-control" data-size="5" data-live-search="true" data-width="100%" id="SitApr" name="SitApr" required>
                                <option selected value="A">Aprovar</option>
                                <option value="D" >Desaprovar</option>
                            </select>
                        </div>
                     </div>

                    <div class="col-md-2 " id="aprovardata">
                        <label for="inputEmail4"> * Data Pagamento  </label>
                        <input class="form-control" type="date" id="ProPgt" name="ProPgt" placeholder="Data Pagamento" />
                      </div>


                      <div class="col-md-2 ">
                        <label for="inputEmail4"> * Data Inicial  </label>
                        <input class="form-control" type="date" id="VctIni" name="VctIni" placeholder="Vencimento Inicial" />
                      </div>

                      <div class="col-md-2 ">
                        <label for="inputEmail4"> * Data Final  </label>
                        <input class="form-control" type="date" id="VctFim" name="VctFim" placeholder="Vencimento Final" />
                      </div>

            </div>

            <div class="row">
                   <div class="col-md-12 " id="msgaprovacao">
                       <h5> * Para Aprovação informe a Data de Vencimento Inicial e Final. </h5>
                   </div>

                   <div class="col-md-12 " id="msgestorno">
                       <h5> * Para Estorno informe a Data de Aprovação Inicial e Final. </h5>
                   </div>
            </div>

              
           

               

                <div class="container-fluid">
                      <div class="row">
                          <div class="col-md-10 text-right">
                            <button  name="btnsalvar"   type="button" onclick="consultar()" class="btn btn-primary btn-sm custom-button-width .navbar-right"><i class="fa fa-search" aria-hidden="true"></i> Consultar</button>

                           </div>
                      </div>
                </div>






</div>
<div class="panel-body">
    <div id="aprovacao">
      <div class="row ">
        <div class="table-responsive">
                  <table id="aprovacaotitulo" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Código</th>
                      <th>Fornecedor</th>
                      <th>Título </th>
                      <th>Tipo </th>
                      <th>Pagamento </th>
                      <th>Vencimento</th>
                      <th>Valor</th>
                      <th>Valor Aprovado</th>
                      <th>Data Aprovação</th>
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
      
    

    <div id="estorno">
      <div class="row ">
        <div class="table-responsive">
                  <table id="estornoaprovacaotitulo" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Código</th>
                      <th>Fornecedor</th>
                      <th>Título </th>
                      <th>Tipo </th>
                      <th>Vencimento</th>
                      <th>Valor Aprovado</th>
                      <th>Data Aprovação</th>
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
  </div>
  </div>



</div>



</form>

@stop
