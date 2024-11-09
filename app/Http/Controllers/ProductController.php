<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }

    public function store(ProductRequest $request)
    {
        Product::create($request->validated());

        return response()->json(['message' => 'Product created successfully'], 201);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return response()->json(['message' => 'Product updated successfully']);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
