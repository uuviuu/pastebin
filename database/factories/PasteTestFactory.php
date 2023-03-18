<?php

namespace Database\Factories;

use App\Enums\Access;
use App\Models\Paste;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PasteTestFactory extends Factory
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
            'locale_lang'  =>  'ru',
            'paste'  =>  $this->faker->text(20),
        ];
    }
}
