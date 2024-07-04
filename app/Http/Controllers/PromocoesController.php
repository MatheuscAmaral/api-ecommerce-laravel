<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Promocoe;
use Illuminate\Http\Request;

class PromocoesController extends Controller
{
    public function index() {
        $promocoes = Promocoe::all();

        return $promocoes;
    }

    public function show($id) {
        $promocao = Promocoe::where([
            "promocao_id" => $id
        ])->get();

        return response()->json($promocao, 200);
    }

    public function create(Request $request) {
        $promocao = new Promocoe;

        $promocao->title_promo = $request->title_promo;
        $promocao->produto_id = $request->produto_id;
        $promocao->tipo_desconto = $request->tipo_desconto;
        $promocao->valor_desconto = $request->valor_desconto;
        $promocao->status = $request->status;

        $promocao->save();

        return response()->json($promocao, 200);
    }

    public function destroy($id) {
        $promocao = Promocoe::findOrFail($id);
        Promocoe::findOrFail($id)->delete();

        return response()->json($promocao, 200);
    }

    public function update(Request $request, $id) {
        $promocao = Promocoe::findOrFail($id);

        $promocao->update($request->all());

        return response()->json($promocao, 200);
    }
}
