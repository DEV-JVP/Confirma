<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
        <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>

    <x-sidebar />
    <div class="flex min-h-screen bg-gray-100">

        <main class="flex-1 p-4 sm:p-6 bg-gray-50 w-full max-w-7xl mx-auto">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-semibold text-gray-800">Control de Asistencias</h2>
                            <a href="{{ route('asistencias.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                                Nueva Fecha de Asistencia
                            </a>
                        </div>

                        @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                        @endif

                        <!-- Selector de fecha -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex flex-col md:flex-row gap-4 items-end">
                                <div class="w-full md:w-1/3">
                                    <label for="fecha-seleccionada" class="block text-sm font-medium text-gray-700 mb-1">Fecha de asistencia</label>
                                    <select id="fecha-seleccionada" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        @foreach($fechasDisponibles as $fecha)
                                        <option value="{{ $fecha }}" {{ $fechaActual == $fecha ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($fecha)->format('l') }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <button id="cambiar-fecha" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                                        Cambiar Fecha
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div class="mb-4">
                            <div class="relative">
                                <input type="text" id="buscar-persona" placeholder="Buscar persona..." class="w-full pl-10 pr-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200" id="tabla-asistencias">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persona</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Asistencia</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($personas as $index => $persona)
                                    <tr class="hover:bg-gray-50 transition-colors persona-row" data-index="{{ $index }}" data-persona="{{ $persona->nombre_completo }}">


                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold">
                                                    {{ substr($persona->nombre_completo, 0, 1) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $persona->nombre_completo }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <input type="checkbox"
                                                class="toggle-asistencia h-5 w-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500"
                                                data-persona-id="{{ $persona->id }}"
                                                {{ isset($asistencias[$persona->id]) && $asistencias[$persona->id] ? 'checked' : '' }}>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ isset($asistencias[$persona->id]) && $asistencias[$persona->id] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ isset($asistencias[$persona->id]) && $asistencias[$persona->id] ? 'Asistió' : 'No asistió' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4 flex justify-center items-center space-x-4" id="paginador">
                                <button id="anterior" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Anterior</button>
                                <span id="pagina-actual" class="font-semibold text-gray-700">Página 1</span>
                                <button id="siguiente" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Siguiente</button>
                            </div>





                        </div>

                        <!-- Botón Guardar Asistencias -->
                        <div class="mt-6 text-right">
                            <button id="guardar-asistencias" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition">
                                Guardar Asistencias
                            </button>
                        </div>

                        <!-- Resumen -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-green-50 p-4 rounded-lg shadow">
                                <div class="flex items-center">
                                    <div class="bg-green-100 p-3 rounded-md">
                                        ✅
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm text-gray-500">Total Asistencias</div>
                                        <div class="text-lg font-semibold text-gray-800" id="total-asistencias">{{ $totalAsistencias }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-red-50 p-4 rounded-lg shadow">
                                <div class="flex items-center">
                                    <div class="bg-red-100 p-3 rounded-md">
                                        ❌
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm text-gray-500">Total Ausencias</div>
                                        <div class="text-lg font-semibold text-gray-800">{{ count($personas) - $totalAsistencias }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg shadow">
                                <div class="flex items-center">
                                    <div class="bg-blue-100 p-3 rounded-md">
                                        📊
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm text-gray-500">Porcentaje Asistencia</div>
                                        <div class="text-lg font-semibold text-gray-800">
                                            {{ count($personas) > 0 ? round(($totalAsistencias / count($personas)) * 100) : 0 }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Formulario oculto -->
                        <form id="form-asistencias" method="POST" action="{{ route('asistencias.guardar') }}">
                            @csrf
                            <input type="hidden" name="fecha" value="{{ $fechaActual }}">
                        </form>
                    </div>
                </div>
            </div>
        </main>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Búsqueda
            document.getElementById('buscar-persona').addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                document.querySelectorAll('#tabla-asistencias tbody tr').forEach(row => {
                    const nombre = row.getAttribute('data-persona').toLowerCase();
                    row.style.display = nombre.includes(term) ? '' : 'none';
                });
            });

            // Cambiar fecha
            document.getElementById('cambiar-fecha').addEventListener('click', function() {
                const fecha = document.getElementById('fecha-seleccionada').value;
                window.location.href = `{{ route('asistencias.index') }}?fecha=${fecha}`;
            });

            // Guardar asistencias
            document.getElementById('guardar-asistencias').addEventListener('click', function() {
                const form = document.getElementById('form-asistencias');
                form.querySelectorAll('input[name="asistencias[]"]').forEach(el => el.remove());

                document.querySelectorAll('.toggle-asistencia').forEach(cb => {
                    if (cb.checked) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'asistencias[]';
                        input.value = cb.getAttribute('data-persona-id');
                        form.appendChild(input);
                    }
                });

                form.submit();
            });

            // Mostrar más personas
            document.getElementById('mostrar-mas').addEventListener('click', function() {
                document.querySelectorAll('.extra-persona').forEach(row => {
                    row.classList.remove('hidden');
                });
                this.style.display = 'none'; // ocultar botón
            });

        });

        const filas = document.querySelectorAll('.persona-row');
        const filasPorPagina = 5;
        let paginaActual = 1;

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * filasPorPagina;
            const fin = inicio + filasPorPagina;

            filas.forEach((fila, i) => {
                fila.style.display = i >= inicio && i < fin ? '' : 'none';
            });

            document.getElementById('pagina-actual').innerText = `Página ${pagina}`;
            document.getElementById('anterior').disabled = pagina === 1;
            document.getElementById('siguiente').disabled = fin >= filas.length;

            paginaActual = pagina;
        }

        // Botones de paginación
        document.getElementById('anterior').addEventListener('click', () => {
            if (paginaActual > 1) mostrarPagina(paginaActual - 1);
        });
        document.getElementById('siguiente').addEventListener('click', () => {
            if ((paginaActual * filasPorPagina) < filas.length) mostrarPagina(paginaActual + 1);
        });

        // Al cargar
        mostrarPagina(1);
    </script>

</body>

</html>
