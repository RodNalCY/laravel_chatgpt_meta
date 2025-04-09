<x-app-layout>
    <div class="py-6">
        <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-300 dark:border-gray-700 p-6">
            <div class="flex h-[70vh]">

                <!-- 📌 Lista de Chats (Izquierda) -->
                <div class="w-1/3 bg-gray-100 dark:bg-gray-900 p-4 rounded-l-lg overflow-y-auto border-r border-gray-300 dark:border-gray-700">
                    <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Chats</h3>

                    <div class="space-y-2">
                        @foreach($chats as $chatItem)
                            <a href="{{ route('chats.show', $chatItem->id) }}" 
                                class="block p-3 rounded-lg transition-all shadow-sm text-center
                                @if(isset($chat) && $chat->id == $chatItem->id) 
                                    bg-blue-500 text-white 
                                @else 
                                    bg-white dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100 
                                @endif">
                                <div class="font-bold text-base">{{ $chatItem->name }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-300">{{ $chatItem->whatsapp_number }}</div>
                            </a>
                            </br>
                        @endforeach
                    </div>
                </div>

                <!-- 📌 Mensajes del Chat Seleccionado (Derecha) -->
                <div class="w-3/4 p-4 flex flex-col">
                    @if(isset($chat))
                        <h3 class="text-lg font-bold mb-4 text-center text-gray-900 dark:text-gray-100">
                            Chat con {{ $chat->name }} ({{ $chat->whatsapp_number }})
                        </h3>

                        <!-- 📌 Contenedor de Mensajes -->
                        <div class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-800 p-4 rounded-lg shadow-md border border-gray-300 dark:border-gray-700">
                            <div class="space-y-4">
                                @foreach($messages as $message)
                                    <div class="flex @if($message->sender == 'user') justify-start @else justify-end @endif">
                                        <div class="max-w-md px-4 py-3 rounded-2xl text-sm shadow-md
                                            @if($message->sender == 'user') 
                                                bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-gray-100 
                                            @else 
                                                bg-blue-500 text-white 
                                            @endif">
                                            {{ $message->message }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center flex-1 text-gray-500 dark:text-gray-300">
                            Selecciona un chat para ver los mensajes.
                        </div>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>