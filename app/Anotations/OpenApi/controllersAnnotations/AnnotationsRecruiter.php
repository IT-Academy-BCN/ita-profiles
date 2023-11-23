<?php

namespace App\Annotations\OpenApi\controllersAnnotations;

class AnnotationsRecruiter
{
    /**
     * Llista tots els reclutadors
     *
     * @OA\Get(
     *     path="/recruiters",
     *     operationId="getAllRecruiters",
     *     tags={"Recruiter"},
     *     summary="Get a list of all recruiters.",
     *     description="Get a list of all registered recruiters. No authentication is required.",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns a list of registered recruiters.",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *
     *                 @OA\Items(
     *                     type="object",
     *
     *                     @OA\Property(property="name", type="string", example="Laura"),
     *                     @OA\Property(property="surname", type="string", example="González"),
     *                     @OA\Property(property="company", type="string", example="ABC Corporation"),
     *                     @OA\Property(property="sector", type="string", example="Technology"),
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="No recruiters found in the database.",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="No hi ha reclutadors a la base de dades.")
     *         )
     *     )
     * )
     */
    public function index() {}

    /**
     * Crea un reclutador
     *
     * @OA\Post(
     *     path="/recruiters",
     *     operationId="createRecruiter",
     *     tags={"Recruiter"},
     *     summary="Create a new user-recruiter.",
     *     description="Creates a new user-recruiter. Requires an INVITATION.",

     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Recruiter data",
     *
     *         @OA\JsonContent(
     *             ref="#/components/schemas/StoreRecruiterRequest"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation. Returns a success message.",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Registre realitzat amb èxit.")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Registration failed. Please try again.",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Registre no efectuat.
     *              Si us plau, torna-ho a provar.")
     *         )
     *     )
     * )
     */
    public function store() {}

    /**
     * Detalls d'un reclutador
     *
     * @OA\Get(
     *     path="/recruiters/{id}",
     *     operationId="getRecruiterById",
     *     tags={"Recruiter"},
     *     summary="Get recruiter by ID",
     *     description="Returns a single recruiter by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the recruiter",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns a single recruiter",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="object",
     *                 property="data",
     *                 @OA\Property(property="name", type="string", example="Carlos"),
     *                 @OA\Property(property="surname", type="string", example="Martínez"),
     *                 @OA\Property(property="company", type="string", example="ABC Corporation"),
     *                 @OA\Property(property="sector", type="string", example="Technology"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recruiter not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuari no trobat.")
     *         )
     *     )
     * )
     */
    public function show() {}

    /**
     * Actualitza les dades d'un recruiter
     * @OA\Put(
     *     path="/recruiters/{id}",
     *     operationId="updateRecruiter",
     *     tags={"Recruiter"},
     *     summary="Update recruiter by ID",
     *     description="Update a recruiter by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the recruiter",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Recruiter data to be updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="surname", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="company", type="string", example="ABC Corporation"),
     *             @OA\Property(property="sector", type="string", example="Technology"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns the updated recruiter",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="object",
     *                 property="data",
     *                 @OA\Property(property="name", type="string", example="John"),
        *              @OA\Property(property="surname", type="string", example="Doe"),
        *              @OA\Property(property="email", type="string", example="john.doe@example.com"),
        *              @OA\Property(property="company", type="string", example="ABC Corporation"),
        *              @OA\Property(property="sector", type="string", example="Technology"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. User not allowed to update this recruiter",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No autorizat")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recruiter not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Alguna cosa ha anat malament.
     *             Torna-ho a intentar més tard.")
     *         )
     *     )
     * )
     */
    public function update() {}

    /**
     * @OA\Delete(
     *     path="/recruiters/{id}",
     *     operationId="deleteRecruiter",
     *     tags={"Recruiter"},
     *     summary="Delete recruiter by ID",
     *     description="Delete a recruiter by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the recruiter",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Recruiter deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example=
     *              "T'has donat de baixa com a reclutador d'It Profiles.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. User not allowed to delete this recruiter",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No autoritzat")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recruiter not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Alguna cosa ha anat malament.
     *              Torna-ho a intenar més tard.")
     *         )
     *     )
     * )
     */
    public function destroy() {}

}
