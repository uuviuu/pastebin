<?php

namespace App\Service;


class UserService
{
    public static function ban($user)
    {
        $permissions = $user->permissions;
        $permissions['platform.index'] = !$permissions['platform.index'];

        $user->permissions = $permissions;
        $user->save();

        return $user;
    }
}
