<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function create(ProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());

        return response()->json($product, 201);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    public function update(Product $product, ProductRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $product->update($validated);

        return response()->json($product);
    }

    public function delete(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(null, 204);
    }

    public function addProductToCategory(Product $product, Category $category): JsonResponse
    {
        $product->categories()->syncWithoutDetaching([$category->id]);

        return response()->json($product->categories->where('id', $category->id));
    }

    public function removeProductFromCategory(Product $product, Category $category): JsonResponse
    {
        $product->categories()->detach($category->id);

        return response()->json(null, 204);
    }

    public function addTagToProduct(Product $product, Tag $tag): JsonResponse
    {
        $product->tags()->syncWithoutDetaching([$tag->id]);

        return response()->json($product->tags->where('id', $tag->id));
    }

    public function removeTagFromProduct(Product $product, Tag $tag): JsonResponse
    {
        $product->tags()->detach($tag->id);

        return response()->json(null, 204);
    }
}
