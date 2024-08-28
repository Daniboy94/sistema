{{-- usamos el metodo PATCH para enviar la informacion al controlador --}}
{{-- El método HTTP PATCH se utiliza para realizar una actualización parcial de un recurso --}}

@extends('layouts.app')

@section('content')
    <div class="container">


        <form action="{{ url('/empleado/' . $empleado->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{ method_field('PATCH') }}
            {{-- creamos la variable modo para pasar informacion --}}
            @include('empleado.form', ['modo' => 'Editar']);

        </form>

    </div>
@endsection
