<?php

namespace Database\Factories;

use App\Models\Paste;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'title' => $this->faker->title(20),
            'author' => $this->faker->text(20),
            'year_of_publication'  => random_int(2000, 2022),
            'description'  => $this->faker->text(200),
            'ISBN'  =>  $this->faker->unique()->text(20),
        ];
    }
}
