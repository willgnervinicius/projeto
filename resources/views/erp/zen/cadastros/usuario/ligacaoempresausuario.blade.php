@extends('adminlte::page')

@section('title', 'Cronus (ERP) - Ligação Usuário x Filial')

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

$(document).on('click', '.bexcluir', function(e) {
        e.preventDefault;
        var CodEmp = $(this).closest('tr').find('td[data-codemp]').data('codemp');
        var CodFil = $(this).closest('tr').find('td[data-codfil]').data('codfil');
        var CodUsu = $(this).closest('tr').find('td[data-codusu]').data('codusu');

        excluirligacao(CodEmp,CodFil,CodUsu);
        
        
}); 

$("#CodFil").focusout(function(){    
    consultarFilial();
});

function consultarFilial(){
    var CodFil = $('#CodFil').val();

            var dadosajax = {
                            "_token": "{{ csrf_token() }}",
                            'CodFil' : CodFil,
            }


            $.ajax({
                

                        type: "GET",
                        dataType : "json",
                        data : dadosajax,
                        
                        url: "/consulta/filial/ligacao/"+{CodFil:CodFil},
                    
                    success: function(Retorno) {
                            var status = (Retorno.Status);

                            if(status == 'OK'){
                                $('#NomFan').val(Retorno.NomFan);
                            } else {
                                var Msg = (Retorno.Msg);
                                swal({
                                                title: "Atenção",
                                                text: Msg,
                                                type: "warning",
                                                showCancelButton: false,
                                                confirmButtonColor: '#063370',
                                                confirmButtonText: 'OK',
                                                closeOnConfirm: false,
                                                closeOnCancel: false
                                            },
                                            function(isConfirm){

                                                    if (isConfirm){
                                                        $('#NomFan').val('');
                                                        

                                                        swal.close();

                                                        $('#CodFil').focus();

                                                    } 
                                            });
                            }

                    }
        });
}


$("#CgcCpf").focusout(function(){    
    consultarUsuario();
});

function consultarUsuario(){
    var CgcCpf = $('#CgcCpf').val();
    var CodFil = $('#CodFil').val();

            var dadosajax = {
                            "_token": "{{ csrf_token() }}",
                            'CgcCpf' : CgcCpf,
                            'CodFil' : CodFil,
            }

            $("#ligafilialusuario td").remove();

            $.ajax({
                

                        type: "GET",
                        dataType : "json",
                        data : dadosajax,
                        
                        url: "/consulta/nome/usuario/"+{CgcCpf:CgcCpf},
                    
                    success: function(Retorno) {
                        $.each(Retorno, function(i, obj){
                                        var Status = obj.Status;
                                        

                                        if(Status == 'OK'){
                                                        var newRow = $("<tr>");	    
                                                        var cols = "";	
                                                        cols += '<td  data-codemp="'+obj.CodEmp+'" codemp attr data->'+obj.CodEmp+'</td>';
                                                        cols += '<td>'+obj.NomEmp+'</td>';	 
                                                        cols += '<td  data-codfil="'+obj.CodFil+'" codfil attr data->'+obj.CodFil+'</td>';	 	 	 
                                                        cols += '<td>'+obj.NomFil+'</td>';	
                                                        cols += '<td  data-codusu="'+obj.CodUsu+'" codusu attr data->'+obj.CodUsu+'</td>'; 	 	 	 
                                                        cols += '<td>'+obj.NomUsu+'</td>';	 	 
                                                        cols += '<td>'+obj.CgcCpf+'</td>';	 	 
                                                    
                                                        cols += '<td> <button  name="bexcluir"   type="button"   class="btn btn-danger btn-sm custom-button-width .navbar-right bexcluir"><i class="fa fa-trash" aria-hidden="true"></i></button></td>';

                                                        
                                        
                                                        newRow.append(cols);	
                                                        
                                                        $("#ligafilialusuario").append(newRow);
                                       } else {
                                          
                                           swal('Advertência','Nenhum Cliente Localizado com o parâmetro informado.', "error");
                                           LimparFormulario();
                                       }
                                            
                                       $('#NomUsu').val(obj.NomUsu);     

                                });
                            
                    }
        });
}


function excluirligacao(CodEmp,CodFil,CodUsu){
    var Empresa = CodEmp ;
    var Filial  = CodFil ;
    var Usuario = CodUsu ;

            var dadosajax = {
                            "_token": "{{ csrf_token() }}",
                            'CodEmp' : Empresa,
                            'CodFil' : Filial,
                            'CodUsu' : Usuario,
            }


            $.ajax({
                

                        type: "GET",
                        dataType : "json",
                        data : dadosajax,
                        
                        url: "/excluir/ligacao/filial/usuario/"+{CodUsu:CodUsu},
                    
                    success: function(Retorno) {
                         consultarUsuario();


                    }
        });
}


function adicionar(){
    var Filial  = $('#CodFil').val() ;
    var Usuario =  $('#CgcCpf').val() ;

            var dadosajax = {
                            "_token": "{{ csrf_token() }}",
                            'CodFil' : Filial,
                            'CgcCpf' : Usuario,
            }


            $.ajax({
                

                        type: "POST",
                        dataType : "json",
                        data : dadosajax,
                        
                        url: "/ligacao/usuario/filial",
                    
                    success: function(Retorno) {
                         var Status = Retorno.Status;

                         if(Status == 'OK'){
                            var Msg = (Retorno.Msg);
                            swal({
                                                title: "Atenção",
                                                text: Msg,
                                                type: "warning",
                                                showCancelButton: false,
                                                confirmButtonColor: '#063370',
                                                confirmButtonText: 'OK',
                                                closeOnConfirm: false,
                                                closeOnCancel: false
                                            },
                                            function(isConfirm){

                                                    if (isConfirm){
                                                        
                                                        swal.close();

                                                        consultarUsuario();

                                                    } 
                                            });
                            
                         } else {
                            var Msg = (Retorno.Msg);
                                swal({
                                                title: "Atenção",
                                                text: Msg,
                                                type: "warning",
                                                showCancelButton: false,
                                                confirmButtonColor: '#063370',
                                                confirmButtonText: 'OK',
                                                closeOnConfirm: false,
                                                closeOnCancel: false
                                            },
                                            function(isConfirm){

                                                    if (isConfirm){
                                                        
                                                        swal.close();

                                                        $('#CgcCpf').focus();

                                                    } 
                                            });
                         }
                        


                    }
        });
}







function LimparFormulario(){
  $('#LigacaoFilialxUsuario').each (function(){
      this.reset();
      $('#CodFil').focus();
    });

   
}


</script>


@stop

@section('content')
<form class="form"  id="LigacaoFilialxUsuario" method="post"  action="">

  {{csrf_field() }}

<div class="container-fluid">
  <div class="row"  rows="50">
  	<div class="col-md-12 ">
          <div class="panel panel-info">
              <div class="panel-heading">
                <h3> Ligação Usuário x Filial </h3>
                

               <div class="row" >
                     <div class="col-md-2 ">
                        <label for="CodFil">  Filial  </label>
                        <input class="form-control" type="text" id="CodFil" autofocus name="CodFil" placeholder="Código" value="{{$CodFil}}"  />
                      </div>

                      <div class="col-md-6 ">
                        <label for="NomFan"> Fantasia Filial  </label>
                        <input class="form-control" type="text" id="NomFan" name="NomFan" placeholder="Razão Social" style="text-transform: uppercase;"  readonly  value="{{$NomFil}}" />
                      </div>
                </div>     
                
                <div class="row" >
                      <div class="col-md-2 ">
                        <label for="CgcCpf">  CNPJ/CPF  </label>
                        <input class="form-control" type="text" id="CgcCpf" name="CgcCpf" placeholder="CPF/CNPJ"  />
                      </div>


                      <div class="col-md-6 ">
                        <label for="NomUsu"> Usuário  </label>
                        <input class="form-control" type="text" id="NomUsu" name="NomUsu" placeholder="Usuário" style="text-transform: uppercase;"  readonly />
                      </div>

            </div>
               <br>

                <div class="container-fluid">
                      <div class="row">
                          <div class="col-md-8 text-right">
                            <button  name="btnadicionar"   type="button" onclick="adicionar()" class="btn btn-primary btn-sm custom-button-width .navbar-right"> Adicionar</button>

                           </div>
                      </div>
                </div>






</div>
<div class="panel-body">
      <div class="row ">
        <div class="table-responsive">
                  <table id="ligafilialusuario" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Empresa</th>
                      <th>Razão Social</th>
                      <th>Filial</th>
                      <th>Razão Social</th>
                      <th>Usuário </th>
                      <th>Nome </th>
                      <th>CNPJ/CPF </th>
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
