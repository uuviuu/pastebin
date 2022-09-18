<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{

    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
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
