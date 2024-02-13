<?php

namespace App\Http\Controllers\api;

use App\Exceptions\UserNotAuthenticatedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResumeUpdateRequest;
use App\Models\Resume;
use App\Service\Resume\ResumeDeleteService;
use App\Service\Resume\ResumeUpdateService;
use App\Service\Resume\ResumeCreateService;
use App\Http\Resources\ResumeShowResource;
use App\Http\Requests\ResumeRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;


class ResumeController extends Controller
{
    private ResumeUpdateService $resumeUpdateService;
    private ResumeCreateService $resumeCreateService;
    private ResumeDeleteService $resumeDeleteService;

    public function __construct( ResumeCreateService $resumeCreateService,
                                 ResumeUpdateService $resumeUpdateService, 
                                 ResumeDeleteService $resumeDeleteService
                             )
    {
        $this->resumeUpdateService = $resumeUpdateService;
        $this->resumeCreateService = $resumeCreateService;
        $this->resumeDeleteService = $resumeDeleteService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Resume::collection(
            Resume::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        try {
            $resume = Resume::where('id', $id)->first();
            return response()->json(
                [
                    'data' => ResumeShowResource::make($resume)],
                200
            );
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
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResumeUpdateRequest $request, string $id)
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
