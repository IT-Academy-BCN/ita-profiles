<?php

namespace App\Http\Controllers\api\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::get();

        if ($tags->isEmpty()) {
            throw new HttpResponseException(response()->json(['message' => __('Not found')], 404));
        }

        return response()->json(['data' => TagResource::collection($tags)], 200);
    }

    public function store(TagRequest $request)
    {
        try {
            $tag = Tag::create($request->validated());

            return response()->json(['data' => $tag, 'message' => __('Tag created successfully.')], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => __('Failed to create tag. Please try again.')], 500);
        }
    }

    public function show($id)
    {
        try {
            $tag = Tag::findOrFail($id);

            return response()->json(['data' => new TagResource($tag)], 200);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'Tag not found'], 404);
        }
    }

    public function update(TagRequest $request, $id)
    {
        try {
            $tag = Tag::findOrFail($id);

            $tag->update($request->validated());

            return response()->json(['data' => new TagResource($tag), 'message' => __('Tag updated successfully')], 200);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'Tag not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $tag = Tag::findOrFail($id);

            $tag->delete();

            return response()->json(['message' => __('Tag deleted successfully')], 200);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'Tag not found'], 404);
        }
    }
}
