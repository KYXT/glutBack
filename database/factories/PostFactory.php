<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $random = $this->faker->numberBetween(1, 6);

        return [
            'category_id'   => $random,
            'lang'          => $random <= 3 ? 'pl' : 'ru',
            'slug'          => $this->faker->unique()->slug(),
            'title'         => $this->faker->unique()->sentence(),
            'h1'            => $this->faker->sentence(),
            'content'       => $this->faker->realText(),
            'image'         => $this->faker->imageUrl(),
            'keywords'      => $random == 1 ? $this->faker->sentence(3) : null,
            'description'   => $random == 1 ? $this->faker->sentence(15) : null,
            'is_on_main'    => $this->faker->boolean(30),
        ];
    }
}
