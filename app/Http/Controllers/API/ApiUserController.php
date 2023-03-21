<?php

namespace App\Http\Controllers\API;

use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;

class ApiUserController extends Controller
{
    /**
     * @OA\Get(
     * path="/users",
     * tags={"Users"},
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             )
     *         )
     *     ),
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws UserNotFoundException
     * @throws ValidationException
     */
    public function paginate(Request $request): JsonResponse
    {
        $this->validate($request, [
            'api_token' => 'required|string|max:80',
            'page' => 'integer|min:1',
            'pageCapacity' => 'integer|in:10,25,50',
        ]);

        if (!Auth::user()->isAdmin()) {
            throw new UserNotFoundException();
        }

        $users = User::paginate($request->input('pageCapacity', 10));

        return apiResponse()->success($users);
    }

    /**
     * @OA\Post(
     * path="/users/ban",
     * tags={"Users"},
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             )
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     * @throws UserNotFoundException
     * @return JsonResponse
     */
    public function ban(Request $request): JsonResponse
    {
        $this->validate($request, [
            'api_token' => 'required|string|max:80',
            'userId' => 'required|integer|min:1',
        ]);

        if (!Auth::user()->isAdmin()) {
            throw new UserNotFoundException();
        }

        $user = User::findOrFail($request->get('id'));
        UserService::ban($user);

        return apiResponse()->success($user);
    }
}
