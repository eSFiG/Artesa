<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function create(CategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return response()->json($category, 201);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json($category);
    }

    public function update(Category $category, CategoryRequest $request): JsonResponse
    {
        $category->update($request->validated());

        return response()->json($category);
    }

    public function delete(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
