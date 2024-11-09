<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }

    public function store(SupplierRequest $request)
    {
        Supplier::create($request->validated());

        return response()->json(['message' => 'Supplier created successfully'], 201);
    }

    public function show(Supplier $supplier)
    {
        return response()->json($supplier);
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        return response()->json(['message' => 'Supplier updated successfully']);
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return response()->json(['message' => 'Supplier deleted successfully']);
    }
}
