<?php

namespace Database\Factories;

use App\Enums\Access;
use App\Models\Paste;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PasteFactory extends Factory
{

    protected $model = Paste::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        $access = Access::getValues();
        return [
            'created_by_id' => User::inRandomOrder()->first()->id,
            'expiration_time' => null,
            'access'  => $access[array_rand($access)],
            'paste_hash'  => Str::random(),
            'lang'  =>  'PHP',
            'paste'  =>  "public function hello(): string
{
    echo 'Hello world!';
}",
        ];
    }
}
