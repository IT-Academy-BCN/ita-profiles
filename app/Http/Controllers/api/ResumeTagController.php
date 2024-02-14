<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Service\ResumeTagService\ResumeTagAddService;
use App\Service\ResumeTagService\ResumeTagDeleteService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ResumeTagController extends Controller
{
    private ResumeTagAddService $resumeTagAddService;


    public function __construct(ResumeTagAddService $resumeTagAddService)
    {
        $this->resumeTagAddService = $resumeTagAddService;
      

    }
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $tagIds = $request->input('tags_ids');

            $this->resumeTagAddService->execute($tagIds);

            return response()->json(['message' => __(' Etiquetas asignadas')], 201);
        }catch(BadRequestException $invalidArgumentException){
            throw new HttpResponseException(response()->json(['error' => $invalidArgumentException->getMessage()], $invalidArgumentException->getCode())); // response()->json(['error' => $invalidArgumentException->getMessage()], $invalidArgumentException->getCode());
        }
     
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
/**
 * Remove the specified resource from storage.
 */
public function destroy(Request $request, string $id)
{
    
}
}
