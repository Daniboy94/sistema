{{-- pasamos la variable $modo para que cambie si estamos editando o creando --}}
<h1>{{ $modo }} empleado</h1>
@if (count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>

@endif

<div class="form-group">
    <label for="Nombre">Nombre</label>
    <input type="text" class="form-control" name="Nombre"
        value="{{ isset($empleado->Nombre) ? $empleado->Nombre : old('Nombre') }}" id="Nombre">

</div>
<div class="form-group">
    <label for="ApellidoPaterno">Apellido Paterno</label>
    <input type="text" class="form-control" name="ApellidoPaterno"
        value="{{ isset($empleado->ApellidoPaterno) ? $empleado->ApellidoPaterno : old('ApellidoPaterno') }}"
        id="ApellidoPaterno">

</div>
<div class="form-group">
    <label for="ApellidoMaterno">Apellido Materno</label>
    <input type="text" class="form-control" name="ApellidoMaterno"
        value="{{ isset($empleado->ApellidoMaterno) ? $empleado->ApellidoMaterno : old('ApellidoMaterno') }}"
        id="ApellidoMaterno">

</div>
<div class="form-group">
    <label for="Correo">Correo</label>
    <input type="text" class="form-control" name="Correo"
        value="{{ isset($empleado->Correo) ? $empleado->Correo : old('Correo') }}" id="Correo">

</div>
<div class="form-group">
    <label for="Foto"></label>
    @if (isset($empleado->Foto))
        <img class="img-thumbnail img-fluid" src="{{ asset('storage') . '/' . isset($empleado->Foto) }}" alt="Foto"
            width="100">
    @endif

    <input type="file" class="form-control" name="Foto" value="" id="Foto">

</div>
<input class="btn btn-success" type="submit" value="{{ $modo }} datos">
<a class="btn btn-primary" href="{{ url('empleado/') }}">Regresar</a>


{{-- value="{{ $empleado->Nombre }}" usamos este codigo para recuperar los datos de la BBDD --}}
{{-- si existe ese valor imprimelo, si no no imprimas nada = {{ isset($empleado->Nombre) ? $empleado->Nombre : '' }}"para evitar el error $empleado undefined, ya que  la variable $empleado no existe en create.blade --}}

{{-- npm run dev --}}
