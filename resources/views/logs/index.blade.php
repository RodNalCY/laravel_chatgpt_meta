<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>

<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Lista de Logs</h3>

                    <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">#</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Nivel</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Mensaje</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Contexto</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                            <tr class="border border-gray-300 dark:border-gray-600">
                                <td class="border border-gray-600 px-4 py-2 text-white">{{ $log->id }}</td>
                                <td class="border border-gray-600 px-4 py-2 text-white">{{ $log->info }}</td>
                                <td class="border border-gray-600 px-4 py-2 text-white">{{ $log->message }}</td>
                                <td class="border border-gray-600 px-4 py-2">
                                    <pre class="language-json">
                                    <code>
                                    @php
                                        $contextData = is_array($log->context) ? $log->context : json_decode($log->context, true);
                                        echo json_encode($contextData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
                                    @endphp
                                    </code>
                                   </pre>
                                </td>
                                <td class="border border-gray-600 px-4 py-2 text-white">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-white">No hay logs disponibles.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>