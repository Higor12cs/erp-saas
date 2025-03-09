<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

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

    public function search(Request $request)
    {
        if ($request->has('ids')) {
            $ids = explode(',', $request->ids);
            $products = Product::with(['brand', 'group.section'])
                ->whereIn('id', $ids)
                ->get();
            return response()->json([
                'data' => $products->map(function (Product $product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'code' => $product->code,
                        'price' => $product->price,
                        'cost_price' => $product->cost_price,
                        'brand' => $product->brand ? $product->brand->name : null,
                        'group' => $product->group ? $product->group->name : null,
                        'section' => $product->group && $product->group->section ? $product->group->section->name : null,
                    ];
                })
            ]);
        }

        $query = $request->search ?? '';
        $products = Product::with(['brand', 'group.section'])
            ->where('name', 'like', "%{$query}%")
            ->orWhere('code', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json([
            'data' => $products->map(function (Product $product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'code' => $product->code,
                    'price' => $product->price,
                    'cost_price' => $product->cost_price,
                    'brand' => $product->brand ? $product->brand->name : null,
                    'group' => $product->group ? $product->group->name : null,
                    'section' => $product->group && $product->group->section ? $product->group->section->name : null,
                ];
            })
        ]);
    }
}
