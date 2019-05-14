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
    $("#DtaIni").attr("value", today);
    $("#DtaFim").attr("value", today);
  

    consultar(); 

});

function ConvertFormToJSON(form){
     var array = jQuery(form).serializeArray();
     var json = {};

     jQuery.each(array, function() {
             json[this.name] = this.value || '';
     });

     
     return json;
}

function consultar(){
    var CodFil = $('#CodFil').val();
    var json = ConvertFormToJSON("#AberturaPeriodo");
    var Form = this;

    $("#periodoaberto td").remove();

    $.ajax({


            type: "GET",
            dataType : "json",
            data : json,
            context : Form,
            url: "/consulta/periodo/aberto/" +{CodFil :CodFil} ,

            success: function(Retorno) {
                      
                      
                      var newRow = $("<tr>");	    
                      var cols = "";	
                      cols += '<td>'+Retorno.CodFil+'</td>';	                                                 
                      cols += '<td>'+Retorno.NomFan+'</td>';	                                                 
                      cols += '<td>'+Retorno.IniEst+'</td>';
                      cols += '<td>'+Retorno.FimEst+'</td>';	                                                 
                      cols += '<td>'+Retorno.IniCom+'</td>';
                      cols += '<td>'+Retorno.FimCom+'</td>';	                                                 
                      cols += '<td>'+Retorno.IniVen+'</td>';
                      cols += '<td>'+Retorno.FimVen+'</td>';	                                                 
                      cols += '<td>'+Retorno.IniFin+'</td>';	                                                                                      
                      cols += '<td>'+Retorno.FimFin+'</td>';	                                                 
                                                                       

                                                                      
                                                      
                      newRow.append(cols);	
                                                                      
                      $("#periodoaberto").append(newRow);
            
            }     
    });

}

function salvar(){
    var json = ConvertFormToJSON("#AberturaPeriodo");
    var Form = this;

    $.ajax({

            type: "POST",
            dataType : "json",
            data : json,
            context : Form,
            url: "/abertura/periodo",
            success: function(Retorno) {
                var status = (Retorno.Status);

               


            }


    });

    consultar();


}


</script>


@stop

@section('content')
<form class="form"  id="AberturaPeriodo" method="post"  action="">

  {{csrf_field() }}

<div class="container-fluid">
  <div class="row"  rows="50">
  	<div class="col-md-12 ">
          <div class="panel panel-info">
              <div class="panel-heading">
                <h3> Abertura de Período para Lançamentos  </h3>
                

               <div class="row" >
                     <div class="col-md-1 ">
                        <label for="inputEmail4"> * Filial  </label>
                        <input class="form-control" type="text" id="CodFil" name="CodFil" placeholder="Filial" value=" {{$CodFil}}" readonly />
                      </div>

                      <div class="col-md-3 ">
                        <label for="inputEmail4"> Fantasia  </label>
                        <input class="form-control" type="text" id="NomFil" name="NomFil" placeholder="Filial" value=" {{$NomFil}}" readonly />
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
                

                    <div class="col-md-2">
                         <center>
                        <input type="checkbox" name="cEstoque">
                        <label for="inputEmail4"> Estoque  </label>
                        
                        </center>
                    </div>

                    <div class="col-md-2">
                         <center>
                         <input type="checkbox" name="cCompras">
                        <label for="inputEmail4"> Compras  </label>
                        </center>
                    </div>

                    <div class="col-md-2">
                         <center>
                         <input type="checkbox" name="cVendas">
                        <label for="inputEmail4"> Vendas  </label>
                        </center>
                    </div>

                    <div class="col-md-2">
                         <center>
                        <input type="checkbox" name="cFinanceiro">
                        <label for="inputEmail4"> Financeiro  </label>
                        </center>
                    </div>
                   
                   

            </div>
           
            

           

               <br>

                <div class="container-fluid">
                      <div class="row">
                          <div class="col-md-8 text-right">
                            <button  name="btnsalvar"   type="button" onclick="salvar()" class="btn btn-primary btn-sm custom-button-width .navbar-right"><i class="fa fa-check" aria-hidden="true"></i> Processar</button>

                           </div>
                      </div>
                </div>






</div>
<div class="panel-body">
      <div class="row ">
        <div class="table-responsive">
                  <table id="periodoaberto" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Filial</th>
                      <th>Nome Filial</th>
                      <th>Inicial Estoque </th>
                      <th>Final Estoque </th>
                      <th>Inicial Compras </th>
                      <th>Final Compras </th>
                      <th>Inicial Vendas </th>
                      <th>Final Vendas </th>
                      <th>Inicial Financeiro</th>
                      <th>Final Financeiro</th>
                    </tr>
                    </thead>
                    <tbody>
                    

                    </tbody>

                  </table>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
     
      
    
     



</form>

@stop
