<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarFeatures>
 */
class CarFeaturesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'abs' => fake()->boolean(),
            'air_conditioning' => fake()->boolean(),
            'power_windows' => fake()->boolean(),
            'power_door_locks' => fake()->boolean(),
            'cruise_control' => fake()->boolean(),
            'bluetooth_connectivity' => fake()->boolean(),
            'remote_start' => fake()->boolean(),
            'gps_navigation' => fake()->boolean(),
            'heated_seats' => fake()->boolean(),
            'climate_control' => fake()->boolean(),
            'rear_parking_sensors' => fake()->boolean(),
            'leather_seats' => fake()->boolean(),
        ];
    }
}
