<?php

use App\Http\Controllers\EstatisticasController;
use App\Http\Controllers\PedidosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromocoesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\FormaController;

Route::group(["prefix"=> "/users"], function () {
    Route::middleware('auth:sanctum')->get('/', function (Request $request) {
        return $request->user();
    });

    Route::get("/list", [UserController::class, "index"]); 
    Route::get("/{cpf}/{email}", [UserController::class, "verifyIfExists"]);
    Route::get("/{id}", [UserController::class, "show"]);
    Route::post("/register", [UserController::class, "register"]);
    // Route::delete("/{id}", [UserController::class, "destroy"]);
    Route::put("/{id}", [UserController::class, "update"]);
    Route::put("/password/{id}/{password}", [UserController::class, "updatePassword"]);
});

Route::group(["prefix"=> "/login"], function () {
    Route::post('/', [AuthController::class, 'login']);
});

Route::group(["prefix"=> "/adm"], function () {
    Route::get("/list", [AdmController::class, "index"]);
    Route::post('/login', [AdmController::class, 'login']);
    Route::post('/', [AdmController::class, 'store']);
    Route::get('/{id}', [AdmController::class, 'show']);
    Route::delete('/{id}', [AdmController::class, 'destroy']);
    Route::put('/{id}', [AdmController::class, 'update']);
});

Route::group(['prefix'=> '/products'], function () {
    Route::get("/", [ProductController::class, "index"]);
    Route::post("/", [ProductController::class, "store"]);
    Route::get("/{id}", [ProductController::class, "show"]);
    Route::delete("/{id}", [ProductController::class, "destroy"]);
    Route::put("/{id}", [ProductController::class, "update"]);
});

Route::group(["prefix"=> "/pedidos"], function ()  {
    Route::get("/", [PedidosController::class, "index"]);
    Route::post("/", [PedidosController::class, "store"]);
    Route::get("/items/{id}", [PedidosController::class, "showItems"]);
    Route::get("/{cliente_id}/{status}", [PedidosController::class, "showOrdersUser"]);
    Route::get("/{id}", [PedidosController::class, "show"]);
});

Route::group(["prefix"=> "/estatisticas"], function ()  {
    Route::get("/", [EstatisticasController::class, "index"]); 
});

Route::group(["prefix"=> "/promocoes"], function () {
    Route::get("/", [PromocoesController::class, "index"]);
    Route::get("/{id}", [PromocoesController::class, "show"]);  
    Route::post("/", [PromocoesController::class, "create"]);
    Route::delete("/{id}", [PromocoesController::class, "destroy"]);
    Route::put("/{id}", [PromocoesController::class, "update"]);
});

Route::group(["prefix"=> "/forma"], function () {
    Route::get("/", [FormaController::class, "index"]);
    Route::get("/{id}", [FormaController::class, "show"]);
    Route::post("/", [FormaController::class, "store"]);
    Route::put("/{id}", [FormaController::class, "update"]);
    Route::delete("/{id}", [FormaController::class, "destroy"]);
});