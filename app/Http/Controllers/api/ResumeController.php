<?php

namespace App\Http\Controllers\api;

use App\Exceptions\UserNotAuthenticatedException;
use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Service\Resume\ResumeUpdateService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    private ResumeUpdateService $resumeUpdateService;

    public function __construct(ResumeUpdateService $resumeUpdateService)
    {
        $this->resumeUpdateService = $resumeUpdateService;
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
    public function store(Request $request) {}

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
        try {
            $data = $request->all();
            $this->resumeUpdateService->execute(
                $id,
                $data['subtitle'] ?? null,
                $data['linkedin_url'] ?? null,
                $data['github_url'] ?? null,
                $data['specialization'] ?? null
            );

            return response('', 200);
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Resume::deleteResume($id);

            return response()->json(['message' => __('Resumen eliminat.')], 200);
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
}
