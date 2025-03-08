<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->with(['group', 'group.section'])
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return inertia('Products/Index', [
            'products' => $products,
            'filters' => request()->only(['search']),
        ]);
    }

    public function create()
    {
        return inertia('Products/Create');
    }

    public function store(ProductRequest $request)
    {
        Product::create($request->validated());

        return to_route('products.index');
    }

    // public function show(Product $product)
    // {
    //     //
    // }

    public function edit(Product $product)
    {
        return inertia('Products/Edit', [
            'product' => $product,
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return to_route('products.index');
    }

    public function destroy(Product $product)
    {
        // TODO: Check if the product has any related data before deleting it

        abort(403, 'Forbidden');

        $product->delete();

        return to_route('products.index');
    }
}
