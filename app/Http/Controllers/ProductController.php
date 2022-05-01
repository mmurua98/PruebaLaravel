<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Response;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products/index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required',
            'impuesto' => 'required',
            ]);

        $product = new Product();
        $product->nombre = $request->nombre;
        $product->precio = $request->precio;
        $product->impuesto = $request->impuesto;
        $product->save();

        return Response()->json($product);
    }

    public function update(Product $product, Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required',
            'impuesto' => 'required',
            ]);

        $product->nombre = $request->nombre;
        $product->precio = $request->precio;
        $product->impuesto = $request->impuesto;
        $product->save();

        return Response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return Response()->json($product);
    }
}
