<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('term');
        $categories = Category::where('name', 'LIKE', "%{$search}%")->get();

        $results = [];

        foreach ($categories as $category) {
            $results[] = ['id' => $category->id, 'text' => $category->name];
        }

        return response()->json($results);
    }

    public function index()
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json(['message' => 'Category created successfully', 'category' => $category]);
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json(['message' => 'Category updated successfully']);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
