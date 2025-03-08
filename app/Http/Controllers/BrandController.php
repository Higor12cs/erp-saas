<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::query()
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return inertia('Brands/Index', [
            'brands' => $brands,
            'filters' => request()->only(['search']),
        ]);
    }

    public function create()
    {
        return inertia('Brands/Create');
    }

    public function store(BrandRequest $request)
    {
        Brand::create($request->validated());

        return to_route('brands.index');
    }

    // public function show(Brand $brand)
    // {
    //     //
    // }

    public function edit(Brand $brand)
    {
        return inertia('Brands/Edit', [
            'brand' => $brand,
        ]);
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());

        return to_route('brands.index');
    }

    public function destroy(Brand $brand)
    {
        // TODO: Check if the brand has any related data before deleting it

        abort(403, 'Forbidden');

        $brand->delete();

        return to_route('brands.index');
    }
}
