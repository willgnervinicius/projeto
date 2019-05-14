@extends('adminlte::page')

@section('title', '| Sis Unique |')

@section('content_header')

@stop

@section('content')

@section('css')
    <link  rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
@stop

@section('js')
<script src="http://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
@stop


<div class="page-header">
<small>Consulta Usuários</small>
</div>
                <div class="panel-body">
                  <table class="table table-bordered"  id='myTable'>
                    <thead>
                      <th>Código</th>
                      <th>Nome</th>
                      <th>E-mail</th>
                      <th style="color:red;">Ação</th>
                    </thead>
                    <tbody>
                    @foreach($users as $users)
                    <tr>
                   <td>{{$users->id}}</td>
                   <td>{{ mb_strtoupper(trans($users->name))}}</td>
                   <td>{{$users->email}}</td>
                   <td><a href="" class="actions edit" title="Editar">
                     <button class="btn btn-primary btn-edit">Editar</button>
                   </a>&nbsp;
                   <a href="" class="actions delete" title="Visualizar">
                     <button class="btn btn-danger btn-edit">Deletar</button></a>
                   </td>
                   </tr>
                      @endforeach
</tbody>
</table>
</div>


                  @stop
