<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes

|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/empleado', function () {
//     return view('empleado.index'); //agregamos la ruta de nuestros archivo de la carpeta views
// });


// Route::get('/empleado/create', [EmpleadoController::class, 'create']); //accedemos al fichero create.blade

// ->middleware('auth'); esta instruccion no permite que un usuario se salte el login y acceda al sistema
Route::resource('empleado', EmpleadoController::class)->middleware('auth'); //con esta instruccion accedemos a todas las url


//"php artisan route:list" usamos este comando para mostrar las rutas por consola
Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');
// cuando el usario se logee se irá a la ruta empleado controler en el metodo index.blade
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [EmpleadoController::class, 'index'])->name('home');
});
