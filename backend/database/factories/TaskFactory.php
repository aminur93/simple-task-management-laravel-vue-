<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{

    protected $model = \App\Models\Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' =>  $this->faker->sentence,
            'body' => $this->faker->text,
            'is_completed' => $this->faker->boolean, // Return a boolean (true/false)
            'status' => $this->faker->boolean,       // Return a boolean (true/false)
            'created_by' => $this->faker->randomNumber(),
        ];
    }
}