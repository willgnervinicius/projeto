@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'register-page')

@section('body')
    <div class="register-box">
        <div class="register-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>C</b>ronus') !!}</a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">{{ trans('adminlte::adminlte.register_message') }}</p>
            <form action="{{ url(config('adminlte.register_url', 'register')) }}" method="post">
                {!! csrf_field() !!}



                <div class="form-group has-feedback {{ $errors->has('NomUsu') ? 'has-error' : '' }}">
                    <input type="text" name="NomUsu" class="form-control" value="{{ old('NomUsu') }}"
                           placeholder="{{ trans('adminlte::adminlte.full_name') }}">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('NomUsu'))
                        <span class="help-block">
                            <strong>{{ $errors->first('NomUsu') }}</strong>
                        </span>
                    @endif
                </div>



                <div class="form-group has-feedback {{ $errors->has('CgcCpf') ? 'has-error' : '' }}">
                        <input type="text" name="CgcCpf" class="form-control" value="{{ old('CgcCpf') }}"
                          placeholder="CNPJ/CPF">
                        <span class="glyphicon glyphicon-file form-control-feedback"></span>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('CgcCpf') }}</strong>
                                </span>
                              @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('IntNet') ? 'has-error' : '' }}">
                    <input type="text" name="IntNet" class="form-control" value="{{ old('IntNet') }}"
                           placeholder="{{ trans('adminlte::adminlte.email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('IntNet'))
                        <span class="help-block">
                            <strong>{{ $errors->first('IntNet') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('SenUsu') ? 'has-error' : '' }}">
                    <input type="password" name="SenUsu" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('SenUsu'))
                        <span class="help-block">
                            <strong>{{ $errors->first('SenUsu') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback {{ $errors->has('SitUsu') ? 'has-error' : '' }}">
                  <select class="form-control" data-size="5" data-live-search="true" data-width="100%" name="SitUsu" required>
                      <option selected value="A">Ativo</option>
                      <option value="I">Inativo</option>
                  </select>
                </div>

                <button type="submit"
                        class="btn btn-primary btn-block btn-flat"
                >{{ trans('adminlte::adminlte.register') }}</button>
            </form>
            <div class="auth-links">
                <a href="{{ url(config('adminlte.login_url', 'login')) }}"
                   class="text-center">{{ trans('adminlte::adminlte.i_already_have_a_membership') }}</a>
            </div>
        </div>
        <!-- /.form-box -->
    </div><!-- /.register-box -->
@stop

@section('adminlte_js')
    @yield('js')
@stop
