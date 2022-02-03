@extends('app')

@section('topright')
<div class="d-flex dropdown p-2">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ $name }} 
    </button>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="index.php?botonpetlogout">Logout</a>
    </div>
</div>
@endsection

@section('content')
<div class="d-flex justify-content-center mt-4">
    <img width='100px' height='100px' src="{{$picture}}" />
    Bienvenido {{ $name }} !!
</div>
@endsection
