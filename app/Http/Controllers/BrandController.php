<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('term');
        $brands = Brand::where('name', 'LIKE', "%{$search}%")->get();

        $results = [];

        foreach ($brands as $brand) {
            $results[] = ['id' => $brand->id, 'text' => $brand->name];
        }

        return response()->json($results);
    }

    public function index()
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }

    public function store(BrandRequest $request)
    {
        Brand::create($request->validated());

        return response()->json(['message' => 'Brand created successfully'], 201);
    }

    public function show(Brand $brand)
    {
        return response()->json($brand);
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());

        return response()->json(['message' => 'Brand updated successfully']);
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return response()->json(['message' => 'Brand deleted successfully']);
    }
}
