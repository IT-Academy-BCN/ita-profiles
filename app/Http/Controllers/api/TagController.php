<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Resources\TagIndexResource;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();

        if ($tags->isEmpty()) {
            throw new HttpResponseException(response()->json(['message' => __('No hi ha tags a la base de dades')], 404));
        }

        return response()->json(['data' => TagIndexResource::collection($tags)], 200);
    }

    public function store(TagRequest $request)
    {
        $tag = Tag::create($request->validated());

        if ($tag) {
            return response()->json(['message' => __('Registre realitzat amb èxit.'), 'tag' => $tag], 201);
        } else {
            return response()->json(['message' => __('Error en crear el tag. Si-us-plau, torna-ho a provar.')], 500);
        }
    }
}
