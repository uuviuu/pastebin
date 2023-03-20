<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ApiUserController extends Controller
{
    /**
     * @throws ValidationException
     * @throws UserNotFoundException
     */
    public function paginate(Request $request)
    {
        $this->validate($request, [
            'api_token' => 'required|string|max:80',
            'page' => 'integer|min:1',
            'pageCapacity' => 'integer|in:10,25,50',
        ]);

        log::info(Auth::user());
        if (!Auth::user()->isAdmin()) {
            throw new UserNotFoundException();
        }

        $users = User::paginate($request->input('pageCapacity', 10));

        return apiResponse()->success($users);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     * @throws UserNotFoundException
     */
    public function ban(Request $request)
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
