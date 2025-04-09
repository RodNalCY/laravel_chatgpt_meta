<?php

namespace Database\Factories;

use App\Models\Log;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition()
    {
        return [
            'info' => $this->faker->word,
            'message' => $this->faker->sentence,
            'context' => $this->faker->text(100),
        ];
    }
}
