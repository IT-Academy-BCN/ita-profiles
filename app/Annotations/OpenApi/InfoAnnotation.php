<?php

namespace App\Annotations\OpenApi;

/**
 * @OA\Info(
 *   version="1.0.0",
 *   title="ITA Profiles page API documentation",
 *   description="API Rest documentation used on ITA Profiles WEB. Some useful links below:
 *     [ITA Profiles Backend Repository](https://github.com/IT-Academy-BCN/ita-profiles-backend)
 *     [ITA Profiles Frontend Repository](https://github.com/IT-Academy-BCN/ita-profiles-frontend)
 *     [ITA Profiles WEB](https://ornate-dieffenbachia-e0ff84.netlify.app)"
 * )
 * @OA\Server(
 *   url=L5_SWAGGER_CONST_HOST
 * )
 * @OA\SecurityScheme(
 *   type="http",
 *   description="Bearer token authentication",
 *   name="Bearer",
 *   in="header",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 *   securityScheme="bearerAuth"
 * )
 */
class InfoAnnotation
{
}
