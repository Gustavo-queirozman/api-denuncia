<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Denuncia\CriarController AS CriarDenunciaController;
use App\Http\Controllers\Denuncia\EditarController AS EditarDenunciaController;
use App\Http\Controllers\Denuncia\ListarController AS ListarDenunciaController;
use App\Http\Controllers\Denuncia\MostrarController AS MostrarDenunciaController;
use App\Http\Controllers\Resposta\CriarRespostaController;
use App\Http\Controllers\Resposta\ListarController AS ListarRespostaController;
use App\Http\Controllers\Usuario\CriarController AS CriarUsuarioController;
use App\Http\Controllers\Usuario\EditarController AS EditarUsuarioController;
use App\Http\Controllers\Usuario\ExcluirController AS ExcluirUsuarioController;
use App\Http\Controllers\Usuario\ListarController AS ListarUsuarioController;
use App\Http\Controllers\Usuario\MostrarController AS MostrarUsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login'])/*->name('login')*/;
Route::post('register', CriarUsuarioController::class );
Route::post('forgot', [AuthController::class, 'forgot']);
Route::post('reset', [AuthController::class, 'reset']);
//rotas abaixo para acesso administrativo
Route::get('usuarios', ListarUsuarioController::class);
Route::post('usuario/{id}', EditarUsuarioController::class);
Route::post('usuario', ExcluirUsuarioController::class);
Route::get('usuario', MostrarUsuarioController::class);
Route::get('denuncias', ListarDenunciaController::class);
Route::post('denuncia/{id}', EditarDenunciaController::class);

Route::post('denuncia', CriarDenunciaController::class);
Route::get('denuncia', MostrarDenunciaController::class);
Route::get('respostas', ListarRespostaController::class);
Route::post('resposta', CriarRespostaController::class);
