<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(5);

        return [
            'title_en' => $title,
            'alias' => Str::slug($title),
            'body_en' => $this->faker->text(1000),
            'user_id' => User::all()->random(),
            'status' => true,
        ];
    }
}
