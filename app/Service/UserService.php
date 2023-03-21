<?php

namespace App\Service;


use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserService
{
    public static function createUser($name, $email, $password)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'email_verified_at' => Carbon::now(),
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

        return $user;
    }

    public static function ban($user)
    {
        $permissions = $user->permissions;
        $permissions['platform.index'] = !$permissions['platform.index'];

        $user->permissions = $permissions;
        $user->save();

        return $user;
    }


}
