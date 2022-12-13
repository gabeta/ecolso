<?php

namespace Database\Factories;

use Domain\Rooms\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Rooms\Models\RoomType>
 */
class RoomTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RoomType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => $this->faker->unique()->text(5),
            'name' => $this->faker->text(10),
            'room_type_id' => null
        ];
    }
}
