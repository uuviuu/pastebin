<?php

namespace Database\Seeders;

use App\Models\Paste;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create([
            'slug' => 'admin',
            'name' => 'admin',
            'permissions'  => [
                'platform' => 1,
                'platform.systems.roles' => 1,
                'platform.systems.users' => 1,
                'platform.systems.attachment' => 1,
            ]
        ]);
        $roleUser = Role::create([
            'slug' => 'user',
            'name' => 'user',
            'permissions'  => [
                'platform' => 1,
                'platform.systems.roles' => 0,
                'platform.systems.users' => 0,
                'platform.systems.attachment' => 0,
            ]
        ]);
        exec('php artisan orchid:admin admin admin@admin.com password');
        User::factory(3)->create();

        $users = User::get();
        foreach ($users as $user) {
            if ($user->name == 'admin') {
                $user->role()->attach($roleAdmin->id);

                $user->api_token = Str::random(80);
                $user->save();
            } else {
                $user->role()->attach($roleUser->id);
            }
        }

        Paste::factory(15)->create();
    }
}
