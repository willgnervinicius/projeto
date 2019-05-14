@extends('adminlte::page')

@section('title', 'Cronus (ERP) - Consulta  Cadastro de Fornecedor')

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

$(document).on('click', '.bconsultarFornecedor', function(e) {
        e.preventDefault;
        var Fornecedor = $(this).closest('tr').find('td[data-codfor]').data('codfor');
        
        var dados = JSON.stringify(Fornecedor);

        sessionStorage.setItem('CodigoFornecedor', dados );

        window.location = "/cadastro/fornecedor";
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
    var CodFor = $('#CodFor').val();
    var RazSoc = $('#RazSoc').val();
    var CgcCpf = $('#CgcCpf').val();
    var json = ConvertFormToJSON("#ConsultaFornecedor");
    var Form = this;

    

    $("#consultarfornecedores td").remove();

    if((CodFor == '') & (RazSoc == '') & (CgcCpf == '')){
      swal('Advertência','Informe um parâmetro de Busca', "error");
        return false;
    }
    
    if((CodFor != '') & (RazSoc != '') & (CgcCpf == '')){
      swal('Advertência','Informe apenas um  parâmetro de Busca', "error");
        return false;
    }

    if((CodFor == '') & (RazSoc != '') & (CgcCpf != '')){
      swal('Advertência','Informe apenas um parâmetro de Busca', "error");
        return false;
    }

    if((CodFor != '') & (RazSoc == '') & (CgcCpf != '')){
      swal('Advertência','Informe apenas um parâmetro de Busca', "error");
        return false;
    }


    if((CodFor != '') & (RazSoc != '') & (CgcCpf != '')){
      swal('Advertência','Informe apenas um parâmetro de Busca', "error");
        return false;
    }


    $.ajax({


            type: "GET",
            dataType : "json",
            data : json,
            context : Form,
            url: "/consulta/cadastro/fornecedor/" +{CodFor :CodFor} ,

            success: function(Retorno) {
                                
                                $.each(Retorno, function(i, obj){
                                        var Status = obj.Status;
                                        

                                        if(Status == 'OK'){
                                                        var newRow = $("<tr>");	    
                                                        var cols = "";	
                                                        cols += '<td  data-codfor="'+obj.CodFor+'" codfor attr data->'+obj.CodFor+'</td>';	 
                                                        cols += '<td>'+obj.RazSoc+'</td>';	 	 
                                                        cols += '<td>'+obj.CgcCpf+'</td>';	 	 
                                                        cols += '<td>'+obj.TelFor+'</td>';	 	 
                                                        cols += '<td>'+obj.IntNet+'</td>';	 	 
                                                        cols += '<td>'+obj.SitFor+'</td>';	 	 
                                                    
                                                        cols += '<td> <button  name="bconsultarFornecedor"   type="button"   class="btn btn-default btn-sm custom-button-width .navbar-right bconsultarFornecedor"><i class="fa fa-check" aria-hidden="true"></i></button></td>';

                                                        
                                        
                                                        newRow.append(cols);	
                                                        
                                                        $("#consultarfornecedores").append(newRow);
                                       } else {
                                          
                                           swal('Advertência','Nenhum Fornecedor Localizado com o parâmetro informado.', "error");
                                           LimparFormulario();
                                       }
                                            
                                            

                                });
            }

                                    
        });
    
}

function LimparFormulario(){
  $('#ConsultaFornecedor').each (function(){
      this.reset();
      $('#CodCli').focus();
    });

    $('#CodCli').focus();
}


</script>


@stop

@section('content')
<form class="form"  id="ConsultaFornecedor" method="post"  action="">

  {{csrf_field() }}

<div class="container-fluid">
  <div class="row"  rows="50">
  	<div class="col-md-12 ">
          <div class="panel panel-info">
              <div class="panel-heading">
                <h3> Consulta  Cadastro de Fornecedor </h3>
                

               <div class="row" >
                     <div class="col-md-2 ">
                        <label for="CodFor">  Código  </label>
                        <input class="form-control" type="text" id="CodFor" autofocus name="CodFor" placeholder="Código"  />
                      </div>

                      <div class="col-md-6 ">
                        <label for="RazSoc"> Razão Social  </label>
                        <input class="form-control" type="text" id="RazSoc" name="RazSoc" placeholder="Razão Social"  style="text-transform: uppercase;" />
                      </div>
                    

                      <div class="col-md-3 ">
                        <label for="CgcCpf">  CNPJ/CPF  </label>
                        <input class="form-control" type="text" id="CgcCpf" name="CgcCpf" placeholder="CPF/CNPJ" />
                      </div>

            </div>

            

            <div class="row">
                

                    <div class="col-md-12">
                      <h5>** Informe apenas um parâmetro de Busca</h5>
                    </div>
                   

            </div>
           
            

           

               <br>

                <div class="container-fluid">
                      <div class="row">
                          <div class="col-md-11 text-right">
                            <button  name="btnconsulta"   type="button" onclick="consultar()" class="btn btn-primary btn-sm custom-button-width .navbar-right"><i class="fa fa-search" aria-hidden="true"></i> Consultar</button>

                           </div>
                      </div>
                </div>






</div>
<div class="panel-body">
      <div class="row ">
        <div class="table-responsive">
                  <table id="consultarfornecedores" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Código</th>
                      <th>Razão Social</th>
                      <th>CNPJ/CPF </th>
                      <th>Telefone</th>
                      <th>E-mail </th>
                      <th>Situacao </th>
                      <th>Ações </th>
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
