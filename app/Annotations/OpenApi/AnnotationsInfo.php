<?php

namespace App\Annotations\OpenApi;

/**
 * @OA\Info(
 *   version="1.0.0",
 *   title="ITA Profiles page API documentation",
 *   description="

    API Rest documentation used on ITA Profiles WEB. Some useful links below:
 *   [ITA Profles Backend Repository](https://github.com/IT-Academy-BCN/ita-profiles-backend)
 *   [ITA Profiles Frontend Repository](https://github.com/IT-Academy-BCN/ita-profiles-frontend)
 *   [ITA Profiles WEB](https://ornate-dieffenbachia-e0ff84.netlify.app)"
 * )
 *   @OA\Server(
 *     url= L5_SWAGGER_CONST_HOST
 *   )
 *   @OA\Server(
 *     url="http://127.0.0.1:8000/api/v1"
 *   )
 *   @OA\Server(
 *     url= L5_SWAGGER_CONST_HOST
 *   )
 *   @OA\Server(
 *     url="http://127.0.0.1:8000/api/v1"
 *   )
 *   @OA\Server(
 *     url="http://127.0.0.1:8000"
 *   )
 *   @OA\Server(
 *     url="https://itaperfils.eurecatacademy.org"
 *   )
 *   @OA\Server(
 *     url="https://itaperfils.eurecatacademy.org/api/v1"
 *   )
 */
class AnnotationsInfo {}
