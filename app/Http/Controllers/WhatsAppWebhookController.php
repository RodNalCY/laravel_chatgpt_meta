<?php

namespace App\Http\Controllers;

use App\Helpers\CustomLogger;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Parameter;
use Illuminate\Http\Request;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    public function verify(Request $request)
    {
        CustomLogger::customLog(
            'info',  // info
            'WhatsApp Webhook recibido',
            ['result' => $request]
        );

        $verifyToken = Parameter::getParameter('WHATSAPP_VERIFY_TOKEN');

        if ($request->input('hub_mode') === 'subscribe' && $request->input('hub_verify_token') === $verifyToken) {
            CustomLogger::customLog(
                "info",  // info
                "Webhook Verificado Correctamente",
                ""
            );
            return response($request->input('hub_challenge'), 200);
        }
        CustomLogger::customLog(
            'error',  // info
            'Webhook fallo la verificación',
            ''
        );
        return response('No autorizado', 403);
    }


    public function receive(Request $request)
    {
        try {
            $raw = $request->getContent();
            $json = json_decode($raw, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                CustomLogger::customLog('error', 'Error al decodificar JSON', [
                    'error' => json_last_error_msg(),
                    'raw' => $raw,
                ]);
                return response()->json(['error' => 'Invalid JSON'], 400);
            }

            // Log de evento recibido
            CustomLogger::customLog('info', 'Evento Whatsapp recibido', ['receive' => $json]);

            $data = data_get($json, 'entry.0.changes.0.value');
            $messages = data_get($data, 'messages');
            $contacts = data_get($data, 'contacts');

            if (empty($messages)) {
                CustomLogger::customLog('info', 'No hay mensajes en el webhook', ['payload' => $json]);
                return response()->json(['message' => 'No hay mensajes.'], 200);
            }

            $messageData = $messages[0];
            $userMessage = data_get($messageData, 'text.body', '');
            $messageId = data_get($messageData, 'id');
            $whatsappNumber = data_get($contacts[0], 'wa_id');
            $userName = data_get($contacts[0], 'profile.name', 'Usuario WhatsApp');

            if (!$whatsappNumber || !$userMessage || !$messageId) {
                CustomLogger::customLog('error', 'Faltan datos en el mensaje', ['json' => $json]);
                return response()->json(['message' => 'Datos incompletos'], 400);
            }

            // Evitar duplicados
            if (ChatMessage::where('message_id', $messageId)->exists()) {
                CustomLogger::customLog('info', 'Mensaje duplicado detectado', ['message_id' => $messageId]);
                return response()->json(['message' => 'Mensaje ya procesado.'], 200);
            }

            // Crear chat si no existe
            $chat = Chat::firstOrCreate(
                ['whatsapp_number' => $whatsappNumber],
                ['name' => $userName]
            );

            // Guardar mensaje del usuario
            ChatMessage::create([
                'chat_id' => $chat->id,
                'message' => $userMessage,
                'sender' => 'user',
                'message_id' => $messageId,
            ]);

            // Obtener respuesta del bot
            $botResponse = $this->getBotResponse($userMessage);

            // Guardar respuesta del bot
            // ChatMessage::create([
            //     'chat_id' => $chat->id,
            //     'message' => $botResponse,
            //     'sender' => 'bot',
            // ]);

            // Enviar respuesta a WhatsApp
            // $this->sendWhatsAppMessage($whatsappNumber, $botResponse);
            // Enviar respuesta a WhatsApp
            if ($this->sendWhatsAppMessage($whatsappNumber, $botResponse)) {
                // Guardar respuesta del bot solo si se envió correctamente
                ChatMessage::create([
                    'chat_id' => $chat->id,
                    'message' => $botResponse,
                    'sender' => 'bot',
                ]);
            } else {
                CustomLogger::customLog('warning', 'No se guardó el mensaje del bot porque falló el envío.', [
                    'to' => $whatsappNumber,
                    'message' => $botResponse,
                ]);
            }


            CustomLogger::customLog('info', 'Mensaje procesado exitosamente', [
                'whatsapp_number' => $whatsappNumber,
                'user_message' => $userMessage,
                'bot_response' => $botResponse,
            ]);

            return response()->json(['message' => 'Mensaje Procesado'], 200);
        } catch (\Exception $e) {
            CustomLogger::customLog('error', 'Error en la Recepción del Mensaje', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Error interno del Servidor.'], 500);
        }
    }



    // public function receive(Request $request)
    // {
    //     try {
    //         // Leer el contenido crudo
    //         $raw = $request->getContent();
    //         $json = json_decode($raw, true);

    //         // Validar el JSON recibido
    //         if (json_last_error() !== JSON_ERROR_NONE) {
    //             Log::error('Error al decodificar JSON del webhook de WhatsApp', [
    //                 'error' => json_last_error_msg(),
    //                 'raw' => $raw
    //             ]);
    //             return response()->json(['error' => 'Invalid JSON'], 400);
    //         }

    //         // Guardar en tu logger personalizado
    //         CustomLogger::customLog(
    //             'info',
    //             'Evento Whatsapp recibido',
    //             ['receive' => $json]
    //         );

    //         // Verificar si el evento contiene mensaje
    //         if (!isset($json['entry'][0]['changes'][0]['value']['messages'])) {
    //             return response()->json(['message' => 'No hay mensajes.'], 200);
    //         }

    //         $messageData = $json['entry'][0]['changes'][0]['value']['messages'][0] ?? null;
    //         $userMessage = $messageData['text']['body'] ?? '';
    //         $whatsappNumber = $json['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id'] ?? null;
    //         $userName = $json['entry'][0]['changes'][0]['value']['contacts'][0]['profile']['name'] ?? 'Usuario WhatsApp';

    //         // Verificar datos esenciales si existen
    //         if (!$whatsappNumber || !$userMessage) {
    //             CustomLogger::customLog(
    //                 'error',
    //                 'Error en los datos recibidos',
    //                 ''
    //             );
    //             return response()->json(['message' => 'Error en los datos recibidos'], 400);
    //         }

    //         // Guardamos la cabecera del chat
    //         $chat = Chat::firstOrCreate(
    //             ['whatsapp_number' => $whatsappNumber],
    //             ['name' => $userName],
    //         );

    //         // Guardamos el mensaje del usuario
    //         ChatMessage::create([
    //             'chat_id' => $chat->id,
    //             'message' => $userMessage,
    //             'sender' => 'user',
    //         ]);

    //         // Obtener la respuesta del bot
    //         $botResponse = $this->getBotResponse($userMessage);

    //         // Guardamos la respuesta del bot
    //         ChatMessage::create([
    //             'chat_id' => $chat->id,
    //             'message' => $botResponse,
    //             'sender' => 'bot',
    //         ]);

    //         // Enviar mensaje de vuelta por WhatsApp
    //         $this->sendWhatsAppMessage($whatsappNumber, $botResponse);

    //         return response()->json(['message' => 'Mensaje Procesado'], 200);
    //     } catch (\Exception $e) {
    //         CustomLogger::customLog(
    //             'error',
    //             'Error en la Recepción del Mensaje',
    //             ['exception' => $e->getMessage()]
    //         );
    //         return response()->json(['message' => 'Error interno del Servidor.'], 500);
    //     }
    // }
    // ** Recibir y procesar mensajes de WhatsApp **
    //  public function receive(Request $request){
    //     try{
    //         // **Guardar el evento recibido en logs**
    //         CustomLogger::customLog(
    //             "info",  // info
    //             "Evento Whatsapp recibido",
    //             ['receive' => $request->all()]
    //         );

    //         // **Verificar si el evento contiene mensaje**
    //         if(!isset($request['entry'][0]['changes'][0]['value']['messages'])){
    //             return response()->json(['message'=>'No hay mensajes.'], 200);
    //         }

    //         $messageData = $request['entry'][0]['changes'][0]['value']['messages'][0] ?? null;
    //         $userMessage = $messageData['text']['body'] ?? '';
    //         $whatsappNumber = $request['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id'] ?? null;
    //         $userName = $request['entry'][0]['changes'][0]['value']['contacts'][0]['profile']['name'] ?? 'Usuario WhatsApp';

    //         // **Verificar datos esenciales si existen**
    //         if (!$whatsappNumber || !$userMessage){
    //             CustomLogger::customLog(
    //                 "error",  // info
    //                 "Error en los datos recibidos",
    //                 ""
    //             );
    //             return response()->json(['message'=>'Error en los datos recibidos'], 400);
    //         }

    //         // **Guardamos la cabezera**
    //         $chat = Chat::firstOrCreate(
    //             ['whatsapp_number' => $whatsappNumber],
    //             ['name' => $userName],
    //         );

    //         // **Guardamos el mensaje del usuario**
    //         ChatMessage::create([
    //             'chat_id' => $chat->id,
    //             'message' => $userMessage,
    //             'sender' => 'user',
    //         ]);

    //         $botResponse = $this->getBotResponse($userMessage);

    //         // **Guardamos la respuesta del bot**
    //         ChatMessage::create([
    //             'chat_id' => $chat->id,
    //             'message' => $botResponse,
    //             'sender' => 'bot',
    //         ]);

    //         $this->sendWhatsAppMessage($whatsappNumber,$botResponse);

    //         return response()->json(['message'=>'Mensaje Procesado'], 200);

    //     }catch(\Exception $e){
    //         CustomLogger::customLog(
    //             "error",  // info
    //             "Error en la Recepción del Mensaje",
    //             ['exception' => $e->getMessage()]
    //         );
    //         return response()->json(['message'=>'Error interno del Servidor.'], 500);
    //     }
    // }

    private function getBotResponse($userMessage)
    {
        try {
            $chatController = new ChatController();
            $request = new Request(['message' => $userMessage]);
            $response = $chatController->ask($request);

            $botResponse = json_decode($response->getContent(), true)['message'] ?? 'No tengo una respuesta en este momento.';

            return $botResponse;
        } catch (\Exception $e) {
            CustomLogger::customLog(
                "error",  // info
                "Problemas con la respuesta del Bot",
                ['exception' => $e->getMessage()]
            );
        }
    }

    private function sendWhatsAppMessage($to, $message)
    {
        try {
            $accessToken = Parameter::getParameter('WHATSAPP_ACCESS_TOKEN');
            $phoneNumberId = Parameter::getParameter('WHATSAPP_PHONE_ID');

            $url = "https://graph.facebook.com/v18.0/{$phoneNumberId}/messages";

            $data = [
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
                "to" => $to,
                "type" => "text",
                "text" => ["body" => $message],
            ];

            $headers = [
                "Authorization: Bearer $accessToken",
                "Content-Type: application/json"
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($response === false || $httpCode >= 400) {
                CustomLogger::customLog('error', 'Error en respuesta de WhatsApp API', [
                    'http_code' => $httpCode,
                    'error' => $curlError,
                    'response' => $response,
                    'data' => $data,
                ]);
                return false; // importante: retornamos false si falló
            }

            $jsonResponse = json_decode($response, true);

            // Puedes guardar el ID del mensaje enviado si lo necesitas
            CustomLogger::customLog('info', 'Mensaje enviado correctamente a WhatsApp', [
                'to' => $to,
                'message' => $message,
                'response' => $jsonResponse,
            ]);

            return true;
        } catch (\Exception $e) {
            CustomLogger::customLog('error', 'Excepción al enviar mensaje a WhatsApp', [
                'exception' => $e->getMessage()
            ]);
            return false;
        }
    }


    // private function sendWhatsAppMessage($to, $message)
    // {
    //     try {
    //         $accessToken = Parameter::getParameter('WHATSAPP_ACCESS_TOKEN');
    //         $phoneNumberId = Parameter::getParameter('WHATSAPP_PHONE_ID'); // Número de WhatsApp en Meta

    //         $url = "https://graph.facebook.com/v22.0/{$phoneNumberId}/messages";

    //         $data = [
    //             "messaging_product" => "whatsapp",
    //             "recipient_type" => "individual",
    //             "to" => $to,
    //             "type" => "text",
    //             "text" => ["body" => $message],
    //         ];

    //         $headers = [
    //             "Authorization: Bearer $accessToken",
    //             "Content-Type: application/json"
    //         ];

    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, $url);
    //         curl_setopt($ch, CURLOPT_POST, 1);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //         $response = curl_exec($ch);
    //         curl_close($ch);
    //     } catch (\Exception $e) {
    //         CustomLogger::customLog(
    //             "error",  // info
    //             "Error al enviar el mensaje a WhatsApp API",
    //             ['exception' => $e->getMessage()]
    //         );
    //     }
    // }
    // private function sendWhatsAppMessage($to, $message)
    // {
    //     try {
    //         $accessToken = Parameter::getParameter('WHATSAPP_ACCESS_TOKEN');
    //         $phoneNumberId = Parameter::getParameter('WHATSAPP_PHONE_ID');

    //         if (!$accessToken || !$phoneNumberId) {
    //             CustomLogger::customLog('error', 'Faltan credenciales para WhatsApp API', [
    //                 'access_token' => $accessToken,
    //                 'phone_number_id' => $phoneNumberId,
    //             ]);
    //             return;
    //         }

    //         $url = "https://graph.facebook.com/v22.0/{$phoneNumberId}/messages";

    //         $data = [
    //             "messaging_product" => "whatsapp",
    //             "to" => $to,
    //             "type" => "text",
    //             "text" => [
    //                 "body" => $message
    //             ]
    //         ];

    //         $headers = [
    //             "Authorization: Bearer $accessToken",
    //             "Content-Type: application/json"
    //         ];

    //         $ch = curl_init();
    //         curl_setopt_array($ch, [
    //             CURLOPT_URL => $url,
    //             CURLOPT_POST => true,
    //             CURLOPT_POSTFIELDS => json_encode($data),
    //             CURLOPT_HTTPHEADER => $headers,
    //             CURLOPT_RETURNTRANSFER => true
    //         ]);

    //         $response = curl_exec($ch);
    //         $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //         $error = curl_error($ch);
    //         curl_close($ch);

    //         if ($error) {
    //             CustomLogger::customLog('error', 'cURL error al enviar mensaje a WhatsApp', ['error' => $error]);
    //         } else {
    //             CustomLogger::customLog('info', 'Mensaje enviado a WhatsApp', [
    //                 'to' => $to,
    //                 'response' => json_decode($response, true),
    //                 'status_code' => $httpCode
    //             ]);
    //         }
    //     } catch (\Exception $e) {
    //         CustomLogger::customLog("error", "Excepción al enviar el mensaje a WhatsApp", [
    //             'exception' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
    //     }
    // }
}
