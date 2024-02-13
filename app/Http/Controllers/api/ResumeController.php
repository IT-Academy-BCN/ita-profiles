<?php

namespace App\Http\Controllers\api;

use App\Exceptions\UserNotAuthenticatedException;
use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Service\Resume\ResumeUpdateService;
use App\Service\Resume\ResumeCreateService;
use App\Http\Resources\ResumeShowResource;
use App\Http\Requests\ResumeRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;


class ResumeController extends Controller
{
    private ResumeUpdateService $resumeUpdateService;
    private ResumeCreateService $resumeCreateService;

    public function __construct(ResumeUpdateService $resumeUpdateService, ResumeCreateService $resumeCreateService)
    {
        $this->resumeUpdateService = $resumeUpdateService;
        $this->resumeCreateService = $resumeCreateService;
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
    public function store(ResumeRequest $request) {

        try {
            $data = $request->validated()->all();
            $this->resumeCreateService->execute(
                $data['id'],
                $data['student_id'],
                $data['subtitle'] ?? null,
                $data['linkedin_url'] ?? null,
                $data['github_url'] ?? null,
                $data['tags_ids'] ?? [],
                $data['specialization'] ?? 'Not Set'
            );
            return response()->json($data, 201);
        } catch(UserNotAuthenticatedException $userNotAuthException) {
            throw new HttpResponseException(response()->json([
                'message' => __(
                    $userNotAuthException->getMessage()
                )
            ], $userNotAuthException->getHttpCode()));
            }

    }

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
