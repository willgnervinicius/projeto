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

            <a href="{{ url(config('adminlte.logarempresa', 'selecione')) }}">{!! config('adminlte.logo', '<b>Appollo</b> & Zeus') !!}</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg" Recuperação de Senha </p>
            <form action="" method="post">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('CgcCpf') ? 'has-error' : '' }}">
                   <label> CPF / CNPJ </label>
                    <input type="text" name="CgcCpf" class="form-control inputgerais"  autofocus 
                           placeholder="CPF / CNPJ">
                    <span class="fa fa-user-circle-o form-control-feedback"></span>
                </div>
               
                <div class="row">

                    <!-- /.col -->
                    <div class="col-sm-4">
                        <button type="submit"
                                class="btn btn-primary btn-block btn-flat">{{ trans('adminlte::adminlte.sign_in') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <div class="auth-links">
                <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}"
                   class="text-center redessociais"
                >{{ trans('adminlte::adminlte.i_forgot_my_password') }}</a>
                <br>
                @if (config('adminlte.register_url', 'register'))
                    <a href="{{ url(config('adminlte.register_url', 'register')) }}"
                       class="text-center redessociais"
                    >{{ trans('adminlte::adminlte.register_a_new_membership') }}</a>
                @endif
            </div>

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
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    @yield('js')
@stop
