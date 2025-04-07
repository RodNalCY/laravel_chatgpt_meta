<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Parameter;
use Illuminate\Http\Request;
use OpenAI;

class ChatController extends Controller
{
    public function ask(Request $request)
    {
        $userMessage = $request->input('message');

        if (!$userMessage) {
            return response()->json([
                'response' => 'Ingrese un mensaje'
            ]);
        }

        try {
            $client = OpenAI::client(Parameter::getParameter('OPENAI_API_KEY'));


            $chat = Chat::firstOrCreate(
                ['whatsapp_number' => '51912101970'],
                ['name' => 'Rodnal Code']
            );

            ChatMessage::create([
                'chat_id' => $chat->id,
                'message' => $userMessage,
                'sender' => 'user',
            ]);

            return response()->json([
                'response' => 'Mensaje procesado correctamente',
                'client' => $client
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'response' => 'Error al procesar la solicitud' . $e->getMessage()
            ], 500);
        }
    }
}
