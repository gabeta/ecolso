<?php

namespace Database\Factories;

use Domain\SchoolYears\Models\SchoolYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\SchoolYears\Models\SchoolYear>
 */
class SchoolYearFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SchoolYear::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'begin_at' => $this->faker->unique()->dateTimeBetween('-30 months', '10 months')->format('Y-m-d'),
            'end_at' => $this->faker->unique('')->dateTimeBetween('-8 months', '1 months')->format('Y-m-d'),
            'is_current' => $this->faker->boolean
        ];
    }
}
