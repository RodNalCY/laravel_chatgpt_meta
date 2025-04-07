<?php

namespace Database\Factories;

    use App\Models\ChatMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChatMessage>
 */
class ChatMessageFactory extends Factory
{
    protected $model = ChatMessage::class;

    public function definition()
    {
        return [
            'message' => $this->faker->sentence,
            'sender' => $this->faker->randomElement(['user', 'bot']),
        ];
    }
}
