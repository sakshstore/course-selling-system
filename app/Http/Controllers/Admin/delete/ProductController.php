<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $product = new Product($request->all());
        $product->user_id = $user->id;
        $product->save();

        return response()->json($product, 201);
    }

    public function show($id)
    {
        $user = Auth::user();
        $product = Product::where('id', $id)->where('user_id', $user->id)->first();
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $product = Product::where('id', $id)->where('user_id', $user->id)->first();
        if ($product) {
            $product->update($request->all());
            return response()->json($product);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $product = Product::where('id', $id)->where('user_id', $user->id)->first();
        if ($product) {
            $product->delete();
            return response()->json(['message' => 'Product deleted']);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
}
