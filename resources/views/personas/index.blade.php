<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Personas - Parroquia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Iconos Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body>
    <x-sidebar />

    <div class="flex min-h-screen bg-gray-100">

        <!-- Contenedor centralizado y con ancho máximo -->
        <main class="flex-1 p-6 bg-gray-50 max-w-7xl mx-auto w-full">

            <!-- Header -->
            <header class="bg-white shadow-sm z-10 rounded-md mb-6">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <button id="mobile-menu-button" class="mr-2 lg:hidden text-gray-600 hover:text-gray-900">
                            <i data-lucide="menu" class="h-6 w-6"></i>
                        </button>
                        <h1 class="text-2xl font-bold text-gray-800">Lista de Personas</h1>
                    </div>
                    <a href="{{ route('personas.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i data-lucide="plus" class="mr-2 h-4 w-4"></i> Nueva Persona
                    </a>
                </div>
            </header>

            <!-- Mensaje de éxito -->
            @if(session('success'))
            <div id="success-alert"
                class="mx-6 mt-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 flex justify-between items-center rounded-md shadow-sm">
                <div class="flex items-center">
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('success-alert').style.display='none'"
                    class="text-emerald-500 hover:text-emerald-700">
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>
            </div>
            @endif

            <br />

            <!-- Búsqueda -->
            <div class="mx-6 mb-4 max-w-md">
                <input id="search-input" type="text" placeholder="Buscar..." aria-label="Buscar"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <!-- Tabla -->
            <div class="mx-6 bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    <div class="flex items-center">
                                        Dni <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    <div class="flex items-center">
                                        Nombre <i data-lucide="chevron-down" class="ml-1 h-4 w-4"></i>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Nacimiento
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Sacramentos
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Contacto
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Apoderado
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Teléfono
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="personas-table-body">
                            @foreach ($personas as $persona)
                            <tr class="hover:bg-gray-100 transition-colors">

                                <td class="px-6 py-4 whitespace-nowrap max-w-[180px] truncate" title="{{ $persona->dni }}">
                                    <div class="font-medium text-gray-600">{{ $persona->dni }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap max-w-[180px] truncate"
                                    title="{{ $persona->nombre_completo }}">
                                    <div class="font-medium text-gray-600">{{ $persona->nombre_completo }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $persona->fecha_nacimiento }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex space-x-2">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $persona->bautizo ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                            Bautizo: {{ $persona->bautizo ? 'Sí' : 'No' }}
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $persona->eucaristia ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                            Eucaristía: {{ $persona->eucaristia ? 'Sí' : 'No' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $persona->contacto }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $persona->nombre_apoderado }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $persona->telefono_apoderado }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('personas.edit', $persona) }}"
                                            class="text-amber-500 hover:text-amber-700 transition-colors"
                                            aria-label="Editar"><i data-lucide="edit" class="h-5 w-5"></i></a>
                                        <form action="{{ route('personas.destroy', $persona) }}" method="POST"
                                            onsubmit="return confirm('¿Está seguro que desea eliminar esta persona?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-700 transition-colors"
                                                aria-label="Eliminar"><i data-lucide="trash-2" class="h-5 w-5"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-6 py-3 bg-white border-t border-gray-200">
    {{ $personas->links() }}
</div>

                </div>
            </div>

        </main>
    </div>

    <script>
        lucide.createIcons();

        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const mobileMenuButton = document.getElementById('mobile-menu-button');

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
            }

            mobileMenuButton.addEventListener('click', toggleSidebar);
            sidebarOverlay.addEventListener('click', toggleSidebar);

            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
            }

            const searchInput = document.getElementById('search-input');
            const tableRows = document.querySelectorAll('#personas-table-body tr');
            const emptyState = document.getElementById('empty-state');

            searchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                let visibleCount = 0;

                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        row.classList.add('hidden');
                    }
                });

                if (visibleCount === 0) {
                    emptyState?.classList.remove('hidden');
                } else {
                    emptyState?.classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>
