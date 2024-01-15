<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Exceptions\HttpResponseException;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::get();

        if ($tags->isEmpty()) {
            throw new HttpResponseException(response()->json(['message' => __('No hi ha tags a la base de dades')], 404));
        }

        return response()->json(['data' => TagResource::collection($tags)], 200);
    }

    public function store(TagRequest $request)
    {
        $tag = Tag::create($request->validated());

        if ($tag) {
            return response()->json(['data' => $tag, 'message' => __('Registre realitzat amb èxit.')], 201);
        } else {
            return response()->json(['message' => __('Error en crear el tag. Si-us-plau, torna-ho a provar.')], 500);
        }
    }

    private function findTag($id)
    {
        $tag = Tag::findOrFail($id);

        return $tag;
    }

    public function show($id)
    {
        $tag = $this->findTag($id);

        return response()->json(['data' => new TagResource($tag)], 200);
    }

    public function update(TagRequest $request, $id)
    {
        $tag = $this->findTag($id);

        $tag->update($request->validated());

        return response()->json(['data' => new TagResource($tag), 'message' => __('Tag updated successfully')], 200);
    }

    public function destroy($id)
    {
        $tag = $this->findTag($id);

        $tag->delete();

        return response()->json(['message' => __('Tag deleted successfully')], 200);
    }
}
