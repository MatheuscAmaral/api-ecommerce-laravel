<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FormaPagamento;
use Illuminate\Http\Request;

class FormaController extends Controller
{
    public function index() {
       try {
            $forma = FormaPagamento::all();
            return response()->json($forma);
       }

       catch (\Exception $e) {
            return response()->json(['message'=> $e->getMessage()]);
       }
    }

    public function show ($id) {
        try {
            $forma = FormaPagamento::where([
                'id'=> $id
            ])->first();

            return response()->json($forma);
        }

        catch (\Exception $e) {
            return response()->json(["message"=> $e->getMessage()]);
        }
    }

    public function store (Request $request) {
        try {
            $forma = new FormaPagamento;

            $forma->descricao = $request->descricao;
            $forma->tipo = $request->tipo;
            $forma->status = $request->status;

            $forma->save();

            return response()->json($forma);
        }

        catch (\Exception $e){
            return response()->json(["message" => $e->getMessage()]);
        }
    }

    public function update (Request $request, $id) {
        try {
            $forma = FormaPagamento::findOrFail($id);

            $forma->update($request->all());

            return response()->json($forma);
        }

        catch (\Exception $e){
            return response()->json(["message" => $e->getMessage()]);
        }
    }

    public function destroy ($id) {
        try {
            $forma = FormaPagamento::where([
                'id'=>$id
            ])->first();

            $forma->delete();

            return response()->json($forma);
        }

        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }
}
