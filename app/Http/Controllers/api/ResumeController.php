<?php

namespace App\Http\Controllers\api;

use App\Exceptions\UserNotAuthenticatedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResumeRequest;
use App\Http\Resources\ResumeShowResource;
use App\Models\Resume;
use App\Service\Resume\ResumeDeleteService;
use App\Service\Resume\ResumeUpdateService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;
use Symfony\Component\CssSelector\Exception\InternalruntimeException;

class ResumeController extends Controller
{
    private ResumeUpdateService $resumeUpdateService;
    private ResumeDeleteService $resumeDeleteService;

    public function __construct(ResumeUpdateService $resumeUpdateService, ResumeDeleteService $resumeDeleteService)
    {
        $this->resumeUpdateService = $resumeUpdateService;
        $this->resumeDeleteService = $resumeDeleteService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
       
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
    public function update(ResumeRequest $request, string $id)
    {
        try {
            $data = $request->all();
          $this->resumeUpdateService->execute(
                $id,
                $data['subtitle'] ?? null,
                $data['linkedin_url'] ?? null,
                $data['github_url'] ?? null,
                $data['specialization'] ?? null
            );
            return response()->json(['message' => __('Currículum actualitzat.')], 200);
        } catch (ModelNotFoundException $resumeNotFoundExeption) {

            throw new HttpResponseException(response()->json([
                'message' => __(
                    $resumeNotFoundExeption->getMessage()
                )
            ], $resumeNotFoundExeption->getCode()));
        } catch (UserNotAuthenticatedException $userNotAuthException) {
            throw new HttpResponseException(response()->json([
                'message' => __(
                    $userNotAuthException->getMessage()
                )
            ], $userNotAuthException->getHttpCode()));
        }catch(Exception $exception){
            throw new HttpResponseException(response()->json([
                'message' => __(
                    $exception->getMessage()
                )
            ], $exception->getCode()));
        }
    }

    public function destroy(string $id)
    {
        try {
           $this->resumeDeleteService->execute($id);
          

            return response()->json(['message' => __('Currículum eliminat.')], 200);
        } catch (ModelNotFoundException $resumeNotFoundExeption) {

            throw new HttpResponseException(response()->json([
                'message' => __(
                    $resumeNotFoundExeption->getMessage()
                )
            ], $resumeNotFoundExeption->getCode()));
        }
    }
}
