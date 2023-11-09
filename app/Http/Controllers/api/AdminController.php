<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Resources\AdminIndexResource;
use App\Http\Resources\AdminShowResource;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="IT Profiles"
 * )
 */


class AdminController extends Controller
{
    /**
     * @OA\Get(
     *      path="api/v1/admins",
     *      operationId="getAllAdmins",
     *      tags={"Admins"},
     *      summary="Get all admins",
     *      description="Get a list of all admins. Requires admin role and valid token.",
     *      security={ {"bearerAuth": {} } },
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation. Returns a list of admins.",
     *
     *          @OA\JsonContent(
     *              type="array",
     *
     *              @OA\Items(
     *                  type="object",
     *
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="John"),
     *                  @OA\Property(property="surname", type="string", example="Doe"),
     *                  @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *
     *              )
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized. Token is missing or invalid."
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden. User does not have the necessary permissions (admin role)."
     *      ),
     * )
     */
    public function index()
    {
        $admins = Admin::all();

        if ($admins->isEmpty()) {
            throw new HttpResponseException(response()->json(['message' => __('No hi ha administradors a la base de dades')], 404));
        }

        return response()->json(['data' => AdminIndexResource::collection($admins)], 200);
    }
/**
 * @OA\Post(
 *      path="/api/v1/admins",
 *      operationId="createAdmin",
 *      tags={"Admins"},
 *      summary="Create a new admin",
 *      description="Creates a new admin user with an invitation code.",
 *
 *      @OA\RequestBody(
 *          required=true,
 *
 *          @OA\JsonContent(
 *              @OA\Property(property="name", type="string", example="John"),
 *              @OA\Property(property="surname", type="string", example="Doe"),
 *              @OA\Property(property="email", type="string", format="email", example="john@example.com"), 
 *              @OA\Property(property="dni", type="string", example="12345678Y, X7959970T"), 
 *              @OA\Property(property="password", type="string", format="password", example="secretpassword"),
 *              @OA\Property(property="invitation_code", type="string", example="abcd1234")
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=201,
 *          description="Admin created successfully. No token is returned.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Admin created successfully.")
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=422,
 *          description="Validation error",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="The given data was invalid."),
 *              @OA\Property(property="errors", type="object",
 *                  example={
 *                      "name": {"The name field is required."},
 *                      "surname": {"The surname field is required."},
 *                      "email": {"The email must be unique."},
 *                      "dni": {"The dni/nie must be unique."}
 *                  }
 *              )
 *          )
 *      ),
 *
 *      @OA\Parameter(
 *          name="invitation_code",
 *          in="query",
 *          required=true,
 *          description="Invitation code for creating a new admin.",
 *          @OA\Schema(type="string")
 *      ),
 *
 *   
 * )
 */


    public function store(UserRequest $request)
    {
        $transaction = DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => Str::lower($request->name),
                'surname' => Str::lower($request->surname),
                'dni' => Str::lower($request->dni),
                'email' => Str::lower($request->email),
                'password' => bcrypt($request->password),
                'active' => true,
            ]);
            Admin::create([
                'user_id' => $user->id,
            ]);
            $user->assignRole('admin');

            return $user;
        });

        return response()->json(['message' => __('Registre realitzat amb èxit.')], 201);
    }
   
     /**
 * @OA\Get(
 *      path="api/v1/admins/{id}",
 *      operationId="getAdminDetails",
 *      tags={"Admins"},
 *      summary="Get details of an administrator",
 *      description="Get the details of a specific administrator. Requires admin role and valid token.",
 *      security={ {"bearerAuth": {} } },
 *
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          description="ID of the administrator",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *      ),
 *
 *      @OA\Parameter(
 *          name="token",
 *          in="query",
 *          required=true,
 *          description="Token for authentication.",
 *          @OA\Schema(type="string")
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Success. Returns administrator details.",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="id", type="integer", example=1),
 *              @OA\Property(property="name", type="string", example="John"),
 *              @OA\Property(property="surname", type="string", example="Doe"),
 *              @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=403,
 *          description="Unauthorized. Missing authentication token or admin role."
 *      ),
 *
 *      @OA\Response(
 *          response=404,
 *          description="Not Found. Administrator with specified ID not found."
 *      ),
 * )
 */

    public function show($id)
    {
        $loggeuser = Auth::user();
        $admin = $this->findAdmin($id);

        if (! $admin) {
            throw new HttpResponseException(response()->json(['message' => __('No hi ha administradors a la base de dades')], 404));
        }
        if ($admin->id !== $loggeuser->admin->id) {
            return response()->json(['message' => 'no tienes permisos para ver este usuario'], 401);
        }

        return response()->json(['data' => new AdminShowResource($admin)], 200);
    }

    private function findAdmin($id)
    {
        $admin = Admin::findOrFail($id);

        return $admin;
    }
  /**
     * @OA\Put(
     *      path="api/v1/admins/{id}",
     *      operationId="updateAdmin",
     *      tags={"Admins"},
     *      summary="Update an administrator",
     *      description="Update the details of a specific administrator. Requires admin role and valid token.",
     *      security={ {"bearerAuth": {} } },
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the administrator",
     *          required=true,
     *
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *
     *      @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(property="name", type="string", example="John"),
     *              @OA\Property(property="surname", type="string", example="Doe"),
     *              @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Success. Returns updated administrator details.",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="John"),
     *              @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="You do not have permission to modify this user"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found. Administrator with specified ID not found."
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        $loggeuser = Auth::user();
        $admin = $this->findAdmin($id);
        if ($admin->id !== $loggeuser->admin->id) {
            throw new HttpResponseException(response()->json(['message' => __('No tens permís per modificar aquest usuari')], 401));
        }

        if (! $admin) {
            throw new HttpResponseException(response()->json(['message' => __('No hi ha administradors a la base de dades')], 404));
        }

        if ($request->surname) {
            $admin->user->surname = $request->surname;

        }if ($request->name) {
            $admin->user->name = $request->name;
        }
        if ($request->email) {
            $admin->user->email = $request->email;
        }
        $admin->save();

        return response()->json(['message' => 'Usuari actualitzat amb èxit', 'data' => new AdminshowResource($admin)], 200);

    }
/**
 * @OA\Delete(
 *      path="/api/v1/admins/{id}",
 *      operationId="deleteAdmin",
 *      tags={"Admins"},
 *      summary="Delete an admin",
 *      description="Delete a specific admin by their ID",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          description="ID of the admin to be deleted",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Admin deleted successfully",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Admin deleted successfully")
 *          )
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized. Missing authentication token or admin role.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Unauthorized. Missing authentication token or admin role.")
 *          )
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Admin not found",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="No admins found in the database")
 *          )
 *      )
 * )
 */
    public function destroy($id)
    {

        $admin = $this->findAdmin($id);
        $loggeuser = Auth::user();
        $id = $this->findAdmin($id);
        if ($admin->id !== $loggeuser->admin->id) {
            throw new HttpResponseException(response()->json(['message' => __('No tens permís per modificar aquest usuari')], 401));
        }
        $admin->user->delete();

        return response()->json(['message' => __('La seva compte ha estat eliminada amb èxit')], 200);
    }
}


