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
    private ResumeTagDeleteService $resumeTagDeleteService;


    public function __construct(ResumeTagAddService $resumeTagAddService, ResumeTagDeleteService $resumeTagDeleteService)
    {
        $this->resumeTagAddService = $resumeTagAddService;
        $this->resumeTagDeleteService = $resumeTagDeleteService;
      

    }

    public function store(Request $request)
    {
        try{

            $tagIds = $request->input('tags_ids');

            $this->resumeTagAddService->execute($tagIds);

            return response()->json(['message' => __(' Etiquetas asignadas')], 201);
        }catch(BadRequestException $invalidArgumentException){
            throw new HttpResponseException(response()->json(['error' => $invalidArgumentException->getMessage()], $invalidArgumentException->getCode())); 
        }
     
    }

  

public function destroy(Request $request)
{
    try{
        $this->resumeTagDeleteService->removespecifiedTags($request->input('tags_ids'));

        return response()->json(['message' => __(' Etiquetas eliminadas')], 200);
    }catch(BadRequestException $invalidArgumentException){
        throw new HttpResponseException(response()->json(['error' => $invalidArgumentException->getMessage()], $invalidArgumentException->getCode()));
    }
   
}
}
