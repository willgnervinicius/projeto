@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    <link href="{!! asset('css/style.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">





    @yield('css')
    <style type="text/css">
        body{
            overflow-y:hidden;
            overflow-x:hidden;
        }

        input:focus{
            border-bottom:2px solid #125cac !important; /* borda sólida */
            border-top:none;
            border-right:none;
            border-left:none;
        }
    </style>

@stop


@section('body_class', 'login-page' ,'fundo')


@section('body')


    <div class="login-box ">
        <div class="login-logo">

            <a href="{{ url(config('adminlte.home', 'home')) }}">{!! config('adminlte.logo', '<b>Appollo</b> & Zeus') !!}</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg" >Informe o CNPJ/CPF para Receber nova Senha</p>
            <form action="" id="RecuperarSenha" method="post">
                {!! csrf_field() !!}

                <div class="form-group">
                   <label> CPF / CNPJ </label>
                    <input type="text" name="CgcCpf" id="CgcCpf" class="form-control inputgerais"  autofocus 
                           placeholder="CPF / CNPJ">
                    <span class="fa fa-user-circle-o form-control-feedback"></span>
                   
                </div>
               
                <div class="row">

                    <!-- /.col -->
                    <div class="col-sm-4">
                        <button type="button" onclick="recuperar()"
                                class="btn btn-primary btn-block btn-flat">Recuperar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
           

            <div class="row">
                <div class="col-xs-12" >
                        <center>
                        <p> Acesse nossas Redes Sociais </p>
                        <strong>
                        <a target="_blank" href="https://api.whatsapp.com/send?phone=5514981588212&text=Olá.%20Gostaria%20de%20mais%20Informações%20sobre%20o%20Sistema" alt="Whatsapp">
                          <i class="menu-icon fa fa-whatsapp redessociais" ></i>
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

                      <strong>Copyright &copy; 2018-2019 <a href="https://adminlte.io" class="redessociais">  Appollo Sistemas</a></strong><p> Direitos reservados.</p>
                      </center>
                </div>
                <!-- /.col -->
            </div>


        </div>



        <!-- /.login-box-body -->
    </div><!-- /.login-box -->



@stop

@section('adminlte_js')
    

            <script src="{{ asset('js/jquery.min.js') }}"></script>
            <script src="{{ asset('js/sweetalert.min.js') }}"></script>
            <script src="{{ asset('js/bootstrap.min.js') }}"></script>
            <script src="{{ asset('js/jquery.mask.js') }}"></script>

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

                    function ConvertFormToJSON(form){
                                        
                                        var array = jQuery(form).serializeArray();
                                        var json = {};

                                        jQuery.each(array, function() {
                                                json[this.name] = this.value || '';
                                        });

                                        
                                        return json;
                        }


                    function LimparFormulario(){
                    $('#RecuperarSenha').each (function(){
                        this.reset();
                        });


                    

                    }


                    function recuperar(){
                        var json = ConvertFormToJSON("#RecuperarSenha");
                        var Form = this;

                        var CgcCpf = $('#CgcCpf').val();

                        if(CgcCpf == ''){
                            return false;
                        }
                    
                        
                        $.ajax({
                            type: "POST",
                            dataType : "json",
                            data : json,
                            context : Form,
                                url: "/recuperacao/senha",
                                success: function(Retorno) {
                                    var Status = Retorno.Status;

                                    if(Status == 'OK'){

                                        swal({
                                                title: "Recuperação de Senha",
                                                text: "E-mail de Recuperação de Senha Enviado.",
                                                type: "warning",
                                                showCancelButton: false,
                                                confirmButtonColor: '#063370',
                                                confirmButtonText: 'OK',
                                                closeOnConfirm: false,
                                                closeOnCancel: false
                                            },
                                            function(isConfirm){

                                                    if (isConfirm){
                                                        window.location = "/login";

                                                    } 
                                            });
                                            };
                                    
                                    

                                } 

                        });

                    };




                    

      </script>
    @yield('js')
@stop
