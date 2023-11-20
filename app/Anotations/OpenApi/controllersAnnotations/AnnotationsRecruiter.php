<?php

namespace App\Annotations\OpenApi\controllersAnnotations;


class AnnotationsRecruiter
{
    /**
     * Llista tots els reclutadors
     * @OA\Get(
     *     path="/recruiters",
     *     operationId="getAllRecruiters",
     *     tags={"Recruiter"},
     *     summary="Get a list of all recruiters.",
     *     description="Get a list of all registered recruiters. No authentication is required.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation. Returns a list of registered recruiters.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="name", type="string", example="Laura"), 
     *                     @OA\Property(property="surname", type="string", example="González"),
     *                     @OA\Property(property="company", type="string", example="ABC Corporation"),
     *                     @OA\Property(property="sector", type="string", example="Technology"),
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No recruiters found in the database.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No hi ha reclutadors a la base de dades.")
     *         )
     *     )
     * )
     */
    public function index() {}

    /**
    * Crea un reclutador 
    * @OA\Post(
    *     path="/recruiters",
    *     operationId="createRecruiter",
    *     tags={"Recruiter"},
    *     summary="Create a new user-recruiter.",
    *     description="Creates a new user-recruiter. Requires an INVITATION.",
    
    *     @OA\RequestBody(
    *         required=true,
    *         description="Recruiter data",
    *         @OA\JsonContent(
    *             ref="#/components/schemas/StoreRecruiterRequest"
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Successful operation. Returns a success message.",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Registre realitzat amb èxit.")
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Registration failed. Please try again.",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Registre no efectuat. Si us plau, torna-ho a provar.")
    *         )
    *     )
    * )
    */
    public function store(){}

}

