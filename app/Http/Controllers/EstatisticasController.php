<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Product;
use App\Models\Promocoe;
use App\Models\User;
use Illuminate\Http\Request;

class EstatisticasController extends Controller
{
    public function index() {
        $productsTotal = Product::count();
        $pedidosTotal = Pedido::count();
        $promocoesTotal = Promocoe::count();
        $users = User::count();

        return response()->json([
            "produtos" => $productsTotal,
            "pedidos" => $pedidosTotal,
            "promocoes" => $promocoesTotal,
            "users" => $users,
        ],  200);
    }
}
