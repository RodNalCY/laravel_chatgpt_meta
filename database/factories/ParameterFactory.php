<?php

namespace Database\Factories;

use App\Models\Parameter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Parameter>
 */
class ParameterFactory extends Factory
{
    protected $model = Parameter::class;

    public function definition()
    {
        return [
            'key' => $this->faker->unique()->word,
            'value' => $this->faker->word,
        ];
    }
}
