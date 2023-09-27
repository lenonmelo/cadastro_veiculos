<?php

use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

//Rotas de login e logout
Route::get('login', [AuthUserController::class, 'index'])->name('login');
Route::post('login', [AuthUserController::class, 'login'])->name('login');
Route::post('logout', [AuthUserController::class, 'logout'])->name('logout');

Route::resource('users', UserController::class);
Route::resource('carBrands', CarBrandController::class);
Route::resource('carModels', CarModelController::class);
Route::resource('vehicles', VehicleController::class);

//Rota para exibição de imagens
Route::get('images/{filename}', function ($filename) {
    $path = storage_path("app/images/$filename");

    if (!Storage::exists("images/$filename") || !file_exists($path)) {
        abort(404);
    }

    $file = Storage::get("images/$filename");
    $type = Storage::mimeType("images/$filename");

    return response($file)->header('Content-Type', $type);
})->where('filename', '(.*)');

//Rota para filtrar os modelos conforme a marca escolhida, utilizada no cadastro de veículos
Route::get('/carModelByCarBrand/{carBrandId}', [CarModelController::class, 'getModelsByBrand']);