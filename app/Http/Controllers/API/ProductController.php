<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'nullable|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0'
        ]);

        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'nullable|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0'
        ]);

        $product->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}
