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
