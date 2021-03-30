<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName,
            'is_admin' => $this->faker->boolean,
            'profile_picture' => $this->faker->imageUrl(200, 200),
            'birth_date' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail,
            'country' => $this->faker->randomElement(['FR', 'DE', 'IT', 'ES', 'PT']),
            'facebook_url' => 'https://facebook.com/',
            'twitter_url' => 'https://facebook.com/',
            'password' => 'password', // password
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
