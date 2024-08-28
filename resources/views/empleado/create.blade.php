{{-- multipart/form-data nos va a permitir enviar imagenes --}}
{{-- @csrf llave de seguridad para saber si el formulario viene del mismo sistema --}}
{{-- @include('empleado.form'); incluimos el formulario --}}
@extends('layouts.app')

@section('content')
    <div class="container">


        <form action="{{ url('/empleado') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('empleado.form', ['modo' => 'Crear']);
        </form>

    </div>
@endsection
