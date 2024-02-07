<?php

namespace App\Http\Controllers\api;

use App\Exceptions\UserNotAuthenticatedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResumeStoreRequest;
use App\Models\Resume;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
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
    public function store(Request $request)
    {
        //
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
    public function update(ResumeStoreRequest $request, string $id)
    {
        try {
            $data = $request->all();
            $resume = Resume::updateResume($data, $id);

            return response()->json(['resume' => $resume], 200);

        } catch (ModelNotFoundException $resumeNotFoundExeption) {

            throw new HttpResponseException(response()->json([
                'message' => __(
                    $resumeNotFoundExeption->getMessage()
                )], $resumeNotFoundExeption->getCode()));
        } catch (UserNotAuthenticatedException $userNotAuthException) {
            throw new HttpResponseException(response()->json([
                'message' => __(
                    $userNotAuthException->getMessage()
                )], $userNotAuthException->getHttpCode()));
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
                )], $resumeNotFoundExeption->getCode()));
        } catch (UserNotAuthenticatedException $userNotAuthException) {
            throw new HttpResponseException(response()->json([
                'message' => __(
                    $userNotAuthException->getMessage()
                )], $userNotAuthException->getHttpCode()));
        }

    }
}
