<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    public function create(TagRequest $request): JsonResponse
    {
        $tag = Tag::create($request->validated());

        return response()->json($tag, 201);
    }

    public function show(Tag $tag): JsonResponse
    {
        return response()->json($tag);
    }

    public function update(Tag $tag, TagRequest $request): JsonResponse
    {
        $tag->update($request->validated());

        return response()->json($tag);
    }

    public function delete(Tag $tag): JsonResponse
    {
        $tag->delete();

        return response()->json(null, 204);
    }
}
