<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\SocialAccount;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Service\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function registration()
    {
        return view('auth.registration');
    }

    public function createUser(CreateUserRequest $request): RedirectResponse
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = Hash::make($request->get('password'));
        UserService::createUser($name, $email, $password);

        return redirect(RouteServiceProvider::HOME);
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $socialiteUser = Socialite::driver($provider)->user();

        $user = $this->findOrCreateUser($provider, $socialiteUser);

        auth()->login($user, true);

        return redirect('/');
    }

    public function findOrCreateUser($provider, $socialiteUser)
    {
        $account = $this->findUserBySocialId($provider, $socialiteUser->getId());
        if ($account) {
            return User::find($account->user_id);
        }

        $user = $this->findUserByEmail($socialiteUser->getEmail());
        if ($user) {
            $this->addSocialAccount($provider, $user, $socialiteUser);
            return $user;
        }

        $name = $socialiteUser->getName();
        $email = $socialiteUser->getEmail();
        $password = bcrypt(Str::random(25));
        $user = UserService::createUser($name, $email, $password);

        $this->addSocialAccount($provider, $user, $socialiteUser);

        return $user;
    }

    public function findUserBySocialId($provider, $id)
    {
        return SocialAccount::where([
            ['provider', $provider],
            ['provider_id', $id],
        ])->first();
    }

    public function findUserByEmail($email)
    {
        return !$email ? null : User::where('email', $email)->first();
    }

    public function addSocialAccount($provider, $user, $socialiteUser)
    {
        SocialAccount::create([
            'user_id' => $user->id,
            'provider' => $provider,
            'provider_id' => $socialiteUser->getId(),
            'token' => $socialiteUser->token,
        ]);
    }
}