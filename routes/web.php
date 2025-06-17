<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CorteCajaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CategoriaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    
Route::resource('medicamentos', MedicamentoController::class)->middleware('auth');
    Route::resource('compras', CompraController::class)->middleware(['auth']);
    Route::resource('categorias', CategoriaController::class)->middleware('auth');



  Route::get('/ventas/create', [VentaController::class, 'create'])->name('ventas.create')->middleware('auth');
Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store')->middleware('auth');
Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index')->middleware('auth');


    Route::get('/corte-caja', [CorteCajaController::class, 'index'])->name('corte-caja.index');
Route::post('/corte-caja/abrir', [CorteCajaController::class, 'abrir'])->name('corte-caja.abrir');
Route::post('/corte-caja/cerrar', [CorteCajaController::class, 'cerrar'])->name('corte-caja.cerrar');

});

});

require __DIR__.'/auth.php';
