<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Listado de Productos</h3>

                    <div class="overflow-x-auto">
                        <!-- Loader -->
                        <div id="loader" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
                            <div class="text-white text-lg animate-pulse">Cargando producto...</div>
                        </div>
                        <table class="min-w-full border-collapse border border-gray-300 dark:border-gray-600">
                            <thead>
                                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">#</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Nombre</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Descripción</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Imagen</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Video</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                <tr class="border border-gray-300 dark:border-gray-600">
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center text-sm">{{ $product->id }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm">{{ $product->name }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm truncate w-10">{{ Str::limit($product->description, 50) }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm">{{ $product->image }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm">{{ $product->video }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-center">
                                        <!-- Botón para abrir el modal -->
                                        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm"
                                            onclick="openProductModal({{ $product->id }})">
                                            Detalle
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500">No hay productos registrados.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }} <!-- Paginación -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal con Alpine.js -->
    <div id="productModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-200">Detalles del Producto</h2>
            <div class="text-gray-700 dark:text-gray-300">
                <p><strong>Ubicación:</strong> <span id="modal-location"></span></p>
                <p><strong>Stock:</strong> <span id="modal-stock"></span></p>
                <p><strong>Precio:</strong> <span id="modal-price"></span></p>
                <p><strong>Precio con Descuento:</strong> <span id="modal-discount_price"></span></p>
                <p><strong>Moneda:</strong> <span id="modal-currency"></span></p>
                <p><strong>Categoría:</strong> <span id="modal-category"></span></p>
                <p><strong>SKU:</strong> <span id="modal-sku"></span></p>
                <p><strong>URL:</strong> <span id="modal-url"></span></p>
            </div>
            <button onclick="closeProductModal()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Cerrar
            </button>
        </div>
    </div>

    <script>
        function openProductModal(productId) {
            // Mostrar loader
            document.getElementById('loader').classList.remove('hidden');

            fetch(`/products/${productId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modal-location').textContent = data.location;
                    document.getElementById('modal-stock').textContent = data.stock;
                    document.getElementById('modal-price').textContent = data.price;
                    document.getElementById('modal-discount_price').textContent = data.discount_price;
                    document.getElementById('modal-currency').textContent = data.currency;
                    document.getElementById('modal-category').textContent = data.category;
                    document.getElementById('modal-sku').textContent = data.sku;
                    document.getElementById('modal-url').textContent = data.url;

                    document.getElementById('productModal').classList.remove('hidden');
                })
                .catch(error => console.error("Error al obtener el producto:", error))
                .finally(() => {
                    // Ocultar loader
                    document.getElementById('loader').classList.add('hidden');
                });
        }


        function closeProductModal() {
            document.getElementById('productModal').classList.add('hidden');
        }
    </script>
</x-app-layout>