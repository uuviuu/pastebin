<?php

namespace App\Http\Controllers\API;

use App\Enums\ExpirationTime;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\Api\PaginatePasteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePasteRequest;
use App\Models\Paste;
use App\Models\User;
use App\Service\PasteService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;

class ApiPasteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/pastes",
     *     operationId="pastesAll",
     *     tags={"Pastes"},
     *     security={
     *       {"api_key": {}},
     *     },
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="The page number",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
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
     * @param PaginatePasteRequest $request
     * @return JsonResponse
     * @throws UserNotFoundException
     */
    public function paginate(PaginatePasteRequest $request): JsonResponse
    {
        $user = Auth::user() ?? User::where('api_token', $request->get('api_token'))->first();
        if (!$user) {
            throw new UserNotFoundException();
        }

        $pastes = $user->pastes()
            ->where(function ($query) {
                $query->whereNull('expiration_time')
                    ->orWhere('expiration_time', '>=', Carbon::now());
            })
            ->orderBy('id', 'desc')
            ->defaultSort('created_at', 'desc')
            ->paginate($request->input('pageCapacity', 10));

        return apiResponse()->success($pastes);
    }

    /**
     * @OA\Get(
     *     path="/pastes/detail",
     *     operationId="pastesAll",
     *     tags={"Pastes"},
     *     security={
     *       {"api_key": {}},
     *     },
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
     * @return JsonResponse
     * @throws ValidationException
     */
    public function detail(Request $request): JsonResponse
    {
        $this->validate($request, [
            'api_token' => 'required|string|max:80',
            'pasteHash' => 'required|string|max:16',
        ]);

        $paste = Paste::findOrFail($request->get('pasteHash'));

        PasteService::checkDetail($paste, Auth::user()['id'] ?? null);

        return apiResponse()->success($paste);
    }

    /**
     * @OA\Post(
     *     path="/pastes/create",
     *     operationId="pastesCreate",
     *     tags={"Pastes"},
     *     security={
     *       {"api_key": {}},
     *     },
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
     * @param CreatePasteRequest $request
     * @return JsonResponse
     */
    public function create(CreatePasteRequest $request): JsonResponse
    {
        $data = [
            'created_by_id' => Auth::user()['id'] ?? null,
            'paste' => $request->input('paste'),
            'lang' => $request->input('locale'),
            'paste_hash' => Str::random(),
            'access' => $request->input('access'),
        ];

        $expirationTime = $request->input('expirationTime') == ExpirationTime::INFINITELY ? null : $request->input('expirationTime');

        $paste = PasteService::create($data, $expirationTime);

        return apiResponse()->success($paste);
    }

    /**
     * @OA\Post(
     *     path="/pastes/complaint",
     *     operationId="pastesComplaint",
     *     tags={"Pastes"},
     *     security={
     *       {"api_key": {}},
     *     },
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
     * @return JsonResponse
     */
    public function complaint(Request $request): JsonResponse
    {
        $this->validate($request, [
            'api_token' => 'required|string|max:80',
            'pasteHash' => 'required|string|max:16',
            'complaint' => 'required|string|max:255',
        ]);
        $paste = PasteService::complaint($request->get('pasteHash'), $request->get('complaint'));

        return apiResponse()->success($paste);
    }

    /**
     * @OA\Post(
     *     path="/pastes/remove",
     *     operationId="pastesRemove",
     *     tags={"Pastes"},
     *     security={
     *       {"api_key": {}},
     *     },
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
     * @throws UserNotFoundException
     * @throws ValidationException
     * @return JsonResponse
     */
    public function remove(Request $request): JsonResponse
    {
        $this->validate($request, [
            'api_token' => 'required|string|max:80',
            'pasteHash' => 'required|string|max:16',
        ]);

        if (!Auth::user()->isAdmin()) {
            throw new UserNotFoundException();
        }

        Paste::findOrFail($request->get('pasteHash'))->delete();

        return apiResponse()->success();
    }
}
