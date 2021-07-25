<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;
    protected static $i;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rand = $this->faker->unique()->randomDigit;
        return [
            'name' => $this->faker->name(),
            'email' => "test". $rand .'@lokalise.com',
            'email_verified_at' => now(),
            'password' => Hash::make('lokalise'.$rand), // password
            'remember_token' => Str::random(10),
            'grant_type' =>  $rand <= 3 ? "read-only" : "read-write"
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
                'email_verified_at' => Carbon::now()->toDateTimeString(),
            ];
        });
    }
}
