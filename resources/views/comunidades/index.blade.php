<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

        <x-sidebar />
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-lg">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Asignar Personas a Mesa</h2>
        <p class="text-gray-600">Selecciona una mesa y las personas que deseas asignar</p>
    </div>

    <form id="form-comunidad" method="POST" action="{{ route('comunidades.store') }}" class="space-y-6">
        @csrf

        <!-- Selección de Mesa -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Selecciona la Mesa
                </span>
            </label>
            <select name="mesa_id" id="mesa-select" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white shadow-sm">
                <option value="">-- Selecciona una mesa --</option>
                @foreach($mesas as $mesa)
                    <option value="{{ $mesa->id }}">{{ $mesa->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Selecciona las Personas
                </span>
            </label>
            
            <!-- Barra de búsqueda -->
            <div class="mb-4">
                <div class="relative">
                    <input type="text" id="search-personas" placeholder="Buscar personas..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Controles de selección -->
            <div class="flex flex-wrap gap-2 mb-4">
                <button type="button" id="select-all" 
                        class="px-3 py-1 text-sm bg-indigo-100 text-indigo-700 rounded-full hover:bg-indigo-200 transition-colors">
                    Seleccionar Todo
                </button>
                <button type="button" id="deselect-all" 
                        class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors">
                    Deseleccionar Todo
                </button>
                <span id="selected-count" class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-full">
                    0 seleccionados
                </span>
            </div>

            <!-- Lista de personas -->
            <div id="personas-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto border border-gray-200 p-4 rounded-lg bg-white">
                @foreach($personasSinComunidad as $persona)
                    <label class="persona-item flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer border border-transparent hover:border-gray-200">
                        <input type="checkbox" name="personas[]" value="{{ $persona->id }}" 
                               class="rounded text-indigo-600 focus:ring-indigo-500 focus:ring-2 transition-colors">
                        <div class="flex-1 min-w-0">
                            <span class="persona-name text-sm font-medium text-gray-900 block truncate">
                                {{ $persona->nombre_completo }}
                            </span>
                            @if(isset($persona->email))
                                <span class="text-xs text-gray-500 block truncate">{{ $persona->email }}</span>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>

            <!-- Mensaje cuando no hay resultados -->
            <div id="no-results" class="hidden text-center py-8 text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p>No se encontraron personas con ese criterio de búsqueda</p>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
            <button type="button" onclick="window.history.back()" 
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Cancelar
            </button>
            <button type="submit" id="submit-btn" disabled
                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Asignar Personas
                </span>
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-personas');
    const personasContainer = document.getElementById('personas-container');
    const personaItems = document.querySelectorAll('.persona-item');
    const selectAllBtn = document.getElementById('select-all');
    const deselectAllBtn = document.getElementById('deselect-all');
    const selectedCount = document.getElementById('selected-count');
    const submitBtn = document.getElementById('submit-btn');
    const mesaSelect = document.getElementById('mesa-select');
    const noResults = document.getElementById('no-results');

    // Función para actualizar el contador de seleccionados
    function updateSelectedCount() {
        const checkedBoxes = document.querySelectorAll('input[name="personas[]"]:checked');
        const count = checkedBoxes.length;
        selectedCount.textContent = `${count} seleccionado${count !== 1 ? 's' : ''}`;
        
        // Habilitar/deshabilitar botón de envío
        const mesaSelected = mesaSelect.value !== '';
        submitBtn.disabled = !(count > 0 && mesaSelected);
    }

    // Función para filtrar personas
    function filterPersonas() {
        const searchTerm = searchInput.value.toLowerCase();
        let visibleCount = 0;

        personaItems.forEach(item => {
            const personaName = item.querySelector('.persona-name').textContent.toLowerCase();
            const matches = personaName.includes(searchTerm);
            
            if (matches) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Mostrar/ocultar mensaje de "no hay resultados"
        if (visibleCount === 0 && searchTerm !== '') {
            noResults.classList.remove('hidden');
            personasContainer.classList.add('hidden');
        } else {
            noResults.classList.add('hidden');
            personasContainer.classList.remove('hidden');
        }
    }

    // Event listeners
    searchInput.addEventListener('input', filterPersonas);

    selectAllBtn.addEventListener('click', function() {
        const visibleCheckboxes = Array.from(personaItems)
            .filter(item => item.style.display !== 'none')
            .map(item => item.querySelector('input[type="checkbox"]'));
        
        visibleCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updateSelectedCount();
    });

    deselectAllBtn.addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('input[name="personas[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateSelectedCount();
    });

    // Listener para checkboxes
    document.addEventListener('change', function(e) {
        if (e.target.name === 'personas[]' || e.target.id === 'mesa-select') {
            updateSelectedCount();
        }
    });

    // Animación de hover para las tarjetas de personas
    personaItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.classList.add('transform', 'scale-105', 'shadow-md');
        });
        
        item.addEventListener('mouseleave', function() {
            this.classList.remove('transform', 'scale-105', 'shadow-md');
        });
    });

    // Validación del formulario
    document.getElementById('form-comunidad').addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('input[name="personas[]"]:checked');
        const mesaSelected = mesaSelect.value !== '';

        if (!mesaSelected) {
            e.preventDefault();
            alert('Por favor selecciona una mesa');
            mesaSelect.focus();
            return;
        }

        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Por favor selecciona al menos una persona');
            return;
        }

        // Mostrar loading en el botón
        submitBtn.innerHTML = `
            <span class="flex items-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Procesando...
            </span>
        `;
        submitBtn.disabled = true;
    });

    // Inicializar contador
    updateSelectedCount();
});
</script>

</body>
</html>