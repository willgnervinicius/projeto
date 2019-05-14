@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    <link href="{!! asset('css/style.css') !!}" media="all" rel="stylesheet" type="text/css" />





    @yield('css')
    <style type="text/css">
        body{
            overflow-y:hidden;
            overflow-x:hidden;
        }

       

        select:focus {
            border-top:none;
            border-right:none;
            border-left:none;
            border-bottom:2px solid #125cac !important; /* borda sólida */
        }
    </style>

@stop


@section('body_class', 'login-page' ,'fundo')


@section('body')


    <div class="login-box">
        <div class="login-logo">

            <a href="">{!! config('adminlte.logo', '<b>Cronus</b>') !!}</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Selecione a Empresa e Filial para Acessar o Sistema</p>
            <form action=""  id="SelecionarEmpresaeFilial" method="post">
                {!! csrf_field() !!}

                <div class="form-group has-feedback ">
                   <label> Empresa </label>
                   <select class="form-control " data-size="5" data-live-search="true" data-width="100%" id="CodEmp" name="CodEmp" onchange="consultarFilial()" >
                   <option selected value="999999"  disabled > Selecione </option>
                        
                 </select>  
                </div>
                <div class="form-group has-feedback">
                  <label> Filial </label>
                  <select class="form-control " data-size="5" data-live-search="true" data-width="100%" id="CodFil" name="CodFil">
                            <option selected value="99999" disabled >Selecione</option>
                          
                    </select>
                </div>
                <div class="row">

                    <!-- /.col -->
                    <div class="col-sm-4">
                    <button  name="btnsalvar"   type="button"  onclick="salvar()" class="btn btn-primary btn-sm custom-button-width .navbar-right"> Acessar</button>
                    </div>
                    <!-- /.col -->
                </div>

                <input type="hidden" name="CodUsu" value="{{ Auth::user()->CodUsu }}">
            </form>
            

            <div class="row">
                <div class="col-xs-12" >
                        <center>
                        <p> Acesse nossas Redes Sociais </p>
                        <strong>
                        <a target="_blank" href="https://api.whatsapp.com/send?phone=5514981588212&text=Olá.%20Gostaria%20de%20mais%20Informações%20sobre%20o%20Sistema" alt="Whatsapp">
                          <i class="menu-icon fa fa-whatsapp redessociais"></i>
                        </a>

                        <a target="_blank" href="https://www.facebook.com/willgnervinicius" >
                          <i class="menu-icon fa fa-facebook-official redessociais"></i>
                        </a>

                        <a target="_blank" href="https://api.whatsapp.com/send?phone=5514988053244&text=Gostaria%20de%20Informações" >
                          <i class="menu-icon fa fa-instagram redessociais"></i>
                        </a>

                        <a target="_blank" href="https://api.whatsapp.com/send?phone=5514988053244&text=Gostaria%20de%20Informações" >
                          <i class="menu-icon fa fa-linkedin redessociais"></i>
                        </a>

                      </strong>
                      <br>

                      <strong>Copyright &copy; 2018-2019 <a href="https://adminlte.io" class="redessociais">Appollo Sistemas</a></strong><p> Direitos reservados.</p>
                      </center>
                </div>
                <!-- /.col -->
            </div>


        </div>



        <!-- /.login-box-body -->
    </div><!-- /.login-box -->


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class=" modal-dialog modal-sm  modal-dialog-centered" role="document">
    <div class="modal-content">
      <center>
      <img src="/img/aguarde.gif" width="100px" height="100px" >
    </center>
    </div>
  </div>
</div>



@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });


$(document).ready(function(){
            /*var options = $("#CodEmp option");
            
            let flags = []
            let output = []
            let l = options.length
            let i;
            
            for( i=0; i<l; i++) {
                if( flags[options[i].value]) continue;
                flags[options[i].value] = true;
                output.push(options[i]);
            }
            
            $("#CodEmp").html(output);

            $("#CodEmp").val("999999").change();*/

            listarempresa();

});


function salvar(){
    CodigoEmpresa = $("#CodEmp").val();
    CodigoFilial = $("#CodFil").val();
	
    if ((CodigoEmpresa != null)|( CodigoEmpresa !=undefined )| (CodigoFilial !='0') | (CodigoFilial != null)| (CodigoFilial != null)){
                var json = ConvertFormToJSON("#SelecionarEmpresaeFilial");
                var Form = this;
 
            $.ajax({

                    type: "POST",
                    dataType : "json",
                    data : json,
                    context : Form,
                    url: "/logar",
                    success: function(Retorno) {
                        var status = (Retorno.Status);
                        if (status =='OK'){
                            window.location = 'home';
                        }
                    }


            });
    }
};

function listarempresa(){
             var dadosajax = {
                            "_token": "{{ csrf_token() }}"
            }

            $('#myModal').modal('show');

            $.ajax({
                

                        type: "GET",
                        dataType : "json",
                        data : dadosajax,
                        
                        url: "/seleciona/empresa/",
                    
                        success: function(RetornoGrupo) {
                            var option = new Array();//resetando a variável
                            resetaCombo('CodEmp');
                                        //resetaCombo('CodEmp');//resetando o combo
                                        $.each(RetornoGrupo, function(i, obj){
                                            
                                            option[i] = document.createElement('option');//criando o option
                                            $( option[i] ).attr( {value : obj.CodEmp} );//colocando o value no option
                                            $( option[i] ).append( obj.NomFan );//colocando o 'label'

                                            $("select[name='CodEmp']").append( option[i] );//jogando um à um os options no próximo combo
                         });

         
             }
        });

        $('#myModal').modal('hide');
}

function consultarFilial(){

   CodigoEmpresa = $("#CodEmp").val();

   
   
   var json = ConvertFormToJSON("#SelecionarEmpresaeFilial");
   var Form = this;

   if ((CodigoEmpresa != null)||  CodigoEmpresa !=undefined){
    $('#myModal').modal('show');

   $.ajax({


             type: "GET",
             dataType : "json",
           data : json,
           context : Form,
             
             url: "/seleciona/filial/" + {CodEmp : CodigoEmpresa} ,

             success: function(RetornoGrupo) {
         var option = new Array();//resetando a variável
         resetaCombo('CodFil');
                      //resetaCombo('CodEmp');//resetando o combo
                      $.each(RetornoGrupo, function(i, obj){
                          
                          option[i] = document.createElement('option');//criando o option
                          $( option[i] ).attr( {value : obj.CodFil} );//colocando o value no option
                          $( option[i] ).append( obj.NomFan );//colocando o 'label'

                          $("select[name='CodFil']").append( option[i] );//jogando um à um os options no próximo combo
                  });

         
             }

     });

     $('#myModal').modal('hide');
   }
}


function resetaCombo( el )
    	{
    		$("select[name='"+el+"']").empty();//retira os elementos antigos
    		var option = document.createElement('option');
    		$( option ).attr( {value : '99999'} );
    		$( option ).append( 'Selecione' );
    		$("select[name='"+el+"']").append( option );
}
 //Converter Formulario em JSON
 function ConvertFormToJSON(form){
       
        var array = jQuery(form).serializeArray();
        var json = {};

        jQuery.each(array, function() {
          json[this.name] = this.value || '';
        });

        
        return json;
}
    </script>

    @yield('js')
@stop
