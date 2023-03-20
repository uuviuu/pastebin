<?php

namespace app\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Orchid\Platform\Http\Controllers\LoginController;

class UserController extends LoginController
{
    public function registration()
    {
        return view('registration');
    }

    public function createUser(CreateUserRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make($request->get('password')),
            'remember_token' => Str::random(10),
            'api_token' => Str::random(80),
            'permissions'  => [
                'platform.index' => true,
                'platform.systems.roles' => false,
                'platform.systems.users' => false,
                'platform.systems.attachment' => false,
            ]
        ]);

        $role = Role::where('name', 'user')->first()->id;
        $user->role()->attach($role);

        return redirect(RouteServiceProvider::HOME);
    }
}
