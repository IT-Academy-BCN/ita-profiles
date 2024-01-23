<?php

namespace App\Http\Controllers\api;

use App\Exceptions\UserNotAuthenticatedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRecruiterRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\RecruiterListResource;
use App\Http\Resources\RecruiterResource;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecruiterController extends Controller
{
    public function index()
    {
        try {
            $recruitersList = Recruiter::all();

            if ($recruitersList->isEmpty()) {

                throw new ModelNotFoundException(__('No hi ha reclutadors a la base de dades.'), 404);

            }

            return response()->json([
                'data' => RecruiterListResource::collection($recruitersList)], 200);

        } catch(ModelNotFoundException $modelNotFoundException) {
            return response()->json(['message' => $modelNotFoundException->getMessage()], $modelNotFoundException->getCode());
        }

    }

    public function store(UserRequest $request)
    {

        $recruiter = DB::transaction(function () use ($request) {

            $user = User::create([
                'name' => Str::lower($request->name),
                'surname' => Str::lower($request->surname),
                'dni' => Str::lower($request->dni),
                'email' => Str::lower($request->email),
                'password' => bcrypt($request->password),
                'active' => true,
            ]);

            $recruiter = $user->recruiter()->create([
                'company' => $request->company,
                'sector' => $request->sector,
            ]);

            $user->assignRole('recruiter');

            return $recruiter;

        });

        if (!$recruiter) {
            throw new HttpResponseException(response()->json([
                'message' => __(
                    'Registre no efectuat. Si us plau, torna-ho a provar.'
                )], 404));
        }

        return response()->json([
            'message' => __(
                'Registre realitzat amb èxit.'
            )], 201);
    }

    public function show($id)
    {
        try {
            $recruiter = Recruiter::where('id', $id)->first();

            if (!$recruiter) {
                throw new ModelNotFoundException(__('Usuari no trobat.'), 404);
            }

            return response()->json([
                'data' => RecruiterResource::make($recruiter)], 200);

        } catch(ModelNotFoundException $recruiterNotFoundExep) {
            return response()->json(['message' => $recruiterNotFoundExep->getMessage()], $recruiterNotFoundExep->getCode());
        }
    }

    public function update(UpdateRecruiterRequest $request, $id)
    {
        try {

            $user = Auth::User();

            $recruiterId = $user->recruiter->id;

            if ($recruiterId != $id) {
                throw new UserNotAuthenticatedException(__('Usuari no autenticat'));

            }

            $updatedRecruiter = DB::transaction(function () use ($request, $id) {

                $recruiter = Recruiter::where('id', $id)->first();
                $recruiter->user->name = Str::lower($request->name);
                $recruiter->user->surname = Str::lower($request->surname);
                $recruiter->user->email = Str::lower($request->email);
                $recruiter->company = $request->company;
                $recruiter->sector = $request->sector;
                $recruiter->user->save();
                $recruiter->save();

                return $recruiter;
            });

            if (!$updatedRecruiter) {
                throw new HttpResponseException(response()->json(['message' => __('Alguna cosa ha anat malament.
                Torna-ho a intentar més tard.')], 404));
            }

            return response()->json(
                [
                    'data' => RecruiterResource::make($updatedRecruiter)],
                200
            );
        } catch(UserNotAuthenticatedException $userNotAuth) {

            return response()->json(['message' => $userNotAuth->getMessage()], $userNotAuth->getHttpCode());

        }


    }

    public function destroy($id)
    {
        try {

            $user = Auth::User();

            $recruiterId = $user->recruiter->id;

            if ($recruiterId != $id) {
                throw new UserNotAuthenticatedException(__('Usuari no autenticat'));

            }

            $deletedRecruiter = DB::transaction(function () use ($id) {
                $recruiter = Recruiter::where('id', $id)->first();
                $user = $recruiter->user;
                $recruiter->delete();
                $user->delete();

                return true;
            });

            if (!$deletedRecruiter) {
                throw new HttpResponseException(response()->json([
                    'message' => __(
                        'Alguna cosa ha anat malament. Torna-ho a intenar més tard.'
                    )], 404));
            }

            return response()->json([
                'message' => __(
                    "T'has donat de baixa com a reclutador d'It Profiles."
                )], 200);
        } catch(UserNotAuthenticatedException $authException) {
            return response()->json(['message' => $authException->getMessage()], $authException->getHttpCode());

        }



    }


}
