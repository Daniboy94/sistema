<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // usamos el metodo index para consultar informacion de la BBDD
        //$datos variable de ambito local
        //vamos a tomar los primeros 5 registros
        $datos['empleados'] = Empleado::paginate(1);
        return view('empleado.index', $datos);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // le damos al controlador la información de la vista

        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validamos los campos
        $campos = [
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email',
            'Foto' => 'required|max:10000|mines:jpeg,png,jpg'
        ];
        //enviamos un mensaje de error

        $mensaje = [
            'required' => 'El :attribute es requerido',
            'Foto.required' => 'La foto es requerida'
        ];

        //$this->validate($request, $campos, $mensaje);

        //-> es para llamar a la función de ese objeto, $objeto->funcion(parámetros)
        //va a obtener toda la informacion enviada por el formulario y va a responder en formato JSON
        //$datosEmpleado es una variable de ambito local
        $datosEmpleado = request()->except('_token'); //quitamos el valor token, ya que no queremos para la base de datos
        //si el campo file tiene una imagen, guardala en store uploads/public
        if ($request->hasFile('Foto')) {
            $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }

        Empleado::insert($datosEmpleado); //inserta los valores en la base de datos

        // return  response()->json($datosEmpleado);
        // redireccionamos para que imprima el mensaje del index.blade
        return redirect('empleado')->with('mensaje', 'Empleado agregado con éxito');
    }


    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //el controlador redirecciona a la vista edit.blade
        //recuperamos los datos a partir del $id
        //findOrfail nos permite recuperar un registro de un modelo a partir de su ID sin necesidad de comprobar si existe.
        //retornamos a la vista la información
        $empleado = Empleado::findOrfail($id);

        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        //validamos los campos
        $campos = [
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email',

        ];
        //enviamos un mensaje de error
        $mensaje = [
            'required' => 'El :attribute es requerido',

        ];
        //el usuario no tiene que incluir una nueva foto en la edición
        if ($request->hasFile('Foto')) {
            $campos = ['Foto' => 'required|max:10000|mines:jpeg,png,jpg'];
            $mensaje = ['Foto.required' => 'La foto es requerida'];
        }

        $this->validate($request, $campos, $mensaje);


        //recepcionamos los datos y quitamos el token y el metodo
        //buscamos el registro con where y actualizamos con update
        //buscamos la informarcion con findOrFail y la retornamos a la vista empleado.edit
        //borramos la foto con Storage::delete y actualizamos la foto con $request->file
        $datosEmpleado = request()->except('_token', '_method');

        if ($request->hasFile('Foto')) {
            $empleado = Empleado::findOrFail($id);
            Storage::delete('public/' . $empleado->Foto);
            $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }

        Empleado::where('id', '=', $id)->update($datosEmpleado);
        $empleado = Empleado::findOrFail($id);
        //return view('empleado.edit', compact('empleado'));
        return redirect('empleado')->with('mensaje', 'Empleado Modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // recibimos el parametro $id desde el formulario index.blade
        //metodo que permite borrar registros de la BBDD
        //Storage::delete borramos la foto de la carpeta upload
        $empleado = Empleado::findOrFail($id);
        if (Storage::delete('public/' . $empleado->Foto)) {
            Empleado::destroy($id);
        }

        //redireccionamos a nuestro lugar de despliegue, donde se muestran los registros  del index
        return redirect('empleado')->with('mensaje', 'Empleado Borrado con éxito');
    }
}
