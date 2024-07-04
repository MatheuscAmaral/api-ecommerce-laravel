<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PedidosController extends Controller
{
    public function index() {
        $pedidos = Pedido::all();

        return $pedidos;
    }

    public function store (Request $request) {
        try {
            $pedido = new Pedido;
            $produtos = new Product;
            
            $pedido->cliente_id = $request->cliente_id;
            $pedido->total = $request->total;
            $pedido->descontos = $request->descontos;
            $pedido->valor_frete = $request->valor_frete;
            $pedido->formapag_id = $request->formapag_id;
            $pedido->cep = $request->cep;
            $pedido->cidade = $request->cidade;
            $pedido->rua = $request->rua;
            $pedido->numero = $request->numero;
            $pedido->bairro = $request->bairro;
            $pedido->uf = $request->uf;
            $pedido->status = $request->status;

            $pedido->save();

            $pedidoId = $pedido->id;
            
            if (isset($request->produto_id) && is_array($request->produto_id)) {
                foreach ($request->produto_id as $index => $produto_id) {
                    $pedidoItem = new PedidoItem;
                    $pedidoItem->pedido_id = $pedidoId;
                    $pedidoItem->produto_id = $produto_id;

                    foreach($request->qtd_pedida as $key => $qtd) {
                        if($index == $key) {
                            $pedidoItem->qtd_pedida = $qtd;
                        }
                    }

                    foreach($request->qtd_atendida as $key => $qtd) {
                        if($index == $key) {
                            $pedidoItem->qtd_atendida = $qtd;
                            $produto = Product::find($produto_id);
                            $produto->stock -= $qtd;
                            $produto->save();
                        }
                    }

                    foreach($request->tipo_desconto as $key => $qtd) {
                        if($index == $key) {
                            $pedidoItem->tipo_desconto = $qtd;
                        }
                    }
                    
                    foreach($request->valor_desconto as $key => $qtd) {
                        if($index == $key) {
                            $pedidoItem->valor_desconto = $qtd;
                        }
                    }

                    $pedidoItem->save();
                }
            } else {
                return response()->json(['message' => 'Nenhum produto fornecido ou formato inválido.']);
            }

        
            return response()->json([
                'pedido'=>  $pedido,
                'numero_pedido'=> $pedidoId
            ]);
        }

        catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function showOrdersUser ($cliente_id, $status) {
        if($status != 0) {
            $pedidos = Pedido::where([
                "cliente_id" => $cliente_id,
                "status" => $status
            ])->get();
        } else {
            $pedidos = Pedido::where([
                "cliente_id" => $cliente_id,
            ])->get();
        }

        return response()->json(["pedidos" => $pedidos]);
    }

    public function show($id) {
        $pedido = Pedido::join("users", "users.id", "pedidos.cliente_id")->
        where([
            "pedido_id" => $id
        ])->
        select(
            "pedidos.*",
            "users.*",
            "users.status as cliente_status"
        )->get();

        return response()->json($pedido);
    }

    public function showItems($id) {
        $itemsPedidos = PedidoItem::join("products", "products.produto_id", "pedido_item.produto_id")->
        where([
            "pedido_id" => $id
        ])->
        select(
            "pedido_item.*",
            "products.*"
        )->get();

        return response()->json($itemsPedidos);
    }
}
