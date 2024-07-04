<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index() {
        $products = Product::leftJoin("promocoes", "promocoes.produto_id", "products.produto_id")
            ->where("products.status", 1)
            ->select(
                "products.*",
                "products.produto_id as prod_id",
                "products.status as prod_status",
                "promocoes.*"
            )
            ->get();
    
        return $products;
    }
    
    public function store(Request $request) {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048'
            ]);
        
            $fileName = time() . "." . $request->image->extension();
    
            $request->image->storeAs('public/images', $fileName);
    
            $imageUrl = asset('storage/images/' . $fileName);
    
            $product = new Product;
            $product->image = $imageUrl;
            $product->title = $request->input('title');
            $product->price = $request->input('price');
            $product->size = $request->input('size');
            $product->category = $request->input('category');
            $product->flavor = $request->input('flavor');
            $product->type_pack = $request->input('type_pack');
            $product->stock = $request->input('stock');
            $product->status = $request->input('status');
    
            $product->save();
    
            return response()->json("success");
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }
    

    public function show($id) {
        $product = Product::leftJoin("promocoes", "products.produto_id", "promocoes.produto_id")
        ->where("products.produto_id", $id)
        ->where("products.status", 1)
        ->select(
            "products.*",
            "products.produto_id as prod_id",
            "products.status as prod_status",
            "promocoes.*"
        )->get();

        return response()->json( $product, 200);
    }

    public function destroy($id) {
        $product = Product::findOrFail($id)->delete();

        return response()->json( $product, 200); 
    }
    
    public function update(Request $request, $produto_id) {
        $product = Product::findOrFail($produto_id);
        $productRequest = $request;

        Log::debug($request->image);

        if($request->image == "") {
            $productRequest['image'] = $product->image;
        } else {
            $request->validate([
                'image'=> 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048'
            ]);
        
            $fileName = time() . "." . $request->image->extension();
    
            $request->image->storeAs('public/images', $fileName);
    
            $imageUrl = asset('storage/images/' . $fileName);
    
            $productRequest['image'] = $imageUrl;
        }

        Log::debug($productRequest);

        $product->update($productRequest->all());
    
        return response()->json($product, 200);
    }
}
    
