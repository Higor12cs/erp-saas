<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }

    public function store(ColorRequest $request)
    {
        Color::create($request->validated());

        return response()->json(['message' => 'Color created successfully'], 201);
    }

    public function show(Color $color)
    {
        return response()->json($color);
    }

    public function update(ColorRequest $request, Color $color)
    {
        $color->update($request->validated());

        return response()->json(['message' => 'Color updated successfully']);
    }

    public function destroy(Color $color)
    {
        $color->delete();

        return response()->json(['message' => 'Color deleted successfully']);
    }
}
