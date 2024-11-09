<?php

namespace App\Http\Controllers;

use App\Http\Requests\SizeRequest;
use App\Models\Size;

class SizeController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }

    public function store(SizeRequest $request)
    {
        Size::create($request->validated());

        return response()->json(['message' => 'Size created successfully'], 201);
    }

    public function show(Size $size)
    {
        return response()->json($size);
    }

    public function update(SizeRequest $request, Size $size)
    {
        $size->update($request->validated());

        return response()->json(['message' => 'Size updated successfully']);
    }

    public function destroy(Size $size)
    {
        $size->delete();

        return response()->json(['message' => 'Size deleted successfully']);
    }
}
