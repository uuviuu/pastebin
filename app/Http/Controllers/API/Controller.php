<?php

namespace App\Http\Controllers\API;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Pastebin API",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="admin@admin.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Tag(
 *     name="Users",
 * )
 * @OA\Tag(
 *     name="Pastes",
 * )
 * @OA\Server(
 *     description="Laravel Swagger API server",
 *     url="http://localhost/api"
 * )
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     name="X-APP-ID",
 *     securityScheme="X-APP-ID"
 * )
 */
class Controller
{
}

