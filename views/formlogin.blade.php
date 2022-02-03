@extends('app')

@section('title')
Formulario login
@endsection


@section('content')

@section('content')
<div class="row justify-content-center" style='margin-top: 50px'>
    <div class="col-md-8">
        <div class="panel panel-default">
            @if (isset($error)) 
            <div class="alert alert-danger" role="alert">Error Credenciales</div>
            @endif
            <div class="panel-heading">Login</div>
            <div class="panel-body mt-3">
                <form class="form-horizontal" action='{{ $url }}' method ="POST">
                    <input type="submit" style="padding: 15px 32px;margin: 5px; font-size: 32px;" value = 'Validar con Google' />
                </form>
            </div>
        </div>
    </div>
</div>
@endSection

