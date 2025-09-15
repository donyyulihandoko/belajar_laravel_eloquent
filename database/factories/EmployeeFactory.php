<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => '',
            'name' => '',
            'title' => '',
            'sallary' => 0
        ];
    }

    public function programmer(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'Programmer',
                'sallary' => 5_000_000
            ];
        });
    }

    public function seniorProgrammer(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'Senior Programmer',
                'sallary' => 10_000_000
            ];
        });
    }
}
