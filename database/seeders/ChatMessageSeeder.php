<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ChatMessage::factory()->count(50)->create();
        $chats = Chat::all();

        $chats->each(function ($chat) {
            ChatMessage::factory()
                ->count(round(5, 10))
                ->create([
                    'chat_id' => $chat->id,
                ]);
        });
    }
}
