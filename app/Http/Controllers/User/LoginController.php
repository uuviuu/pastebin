<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\SocialAccount;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Service\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as ContractUser ;

class LoginController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function registration()
    {
        return view('auth.registration');
    }

    /**
     * @param CreateUserRequest $request
     * @return RedirectResponse
     */
    public function createUser(CreateUserRequest $request): RedirectResponse
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = Hash::make($request->get('password'));

        UserService::createUser($name, $email, $password);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * @param string $provider
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param string $provider
     * @return Application|RedirectResponse|Redirector
     */
    public function handleProviderCallback(string $provider)
    {
        $socialiteUser = Socialite::driver($provider)->user();

        $user = $this->findOrCreateUser($provider, $socialiteUser);

        auth()->login($user, true);

        return redirect('/');
    }

    /**
     * @param string $provider
     * @param ContractUser $socialiteUser
     * @return User
     */
    public function findOrCreateUser(string $provider, ContractUser $socialiteUser): User
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

    /**
     * @param string $provider
     * @param string $id
     * @return null|SocialAccount
     */
    public function findUserBySocialId(string $provider, string $id): ?SocialAccount
    {
        return SocialAccount::where([
            ['provider', $provider],
            ['provider_id', $id],
        ])->first();
    }

    /**
     * @param string $email
     * @return null|User
     */
    public function findUserByEmail(string $email): ?User
    {
        return !$email ? null : User::where('email', $email)->first();
    }

    /**
     * @param string $provider
     * @param User $user
     * @param ContractUser $socialiteUser
     * @return void
     */
    public function addSocialAccount(string $provider, User $user, ContractUser $socialiteUser): void
    {
        SocialAccount::create([
            'user_id' => $user->id,
            'provider' => $provider,
            'provider_id' => $socialiteUser->getId(),
            'token' => $socialiteUser->token,
        ]);
    }
}