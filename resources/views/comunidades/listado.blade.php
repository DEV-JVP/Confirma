<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>


<div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestión de Comunidades</h1>
                <p class="mt-2 text-sm text-gray-600">Administra las asignaciones de personas a mesas</p>
            </div>
       
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div id="success-alert" class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="document.getElementById('success-alert').remove()" class="text-green-600 hover:text-green-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Asignaciones</p>
                    <p class="text-2xl font-semibold text-gray-900" id="total-count">{{ $comunidades->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Mesas Activas</p>
                    <p class="text-2xl font-semibold text-gray-900" id="mesas-count">{{ $comunidades->pluck('mesa.nombre')->unique()->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Mostrando</p>
                    <p class="text-2xl font-semibold text-gray-900" id="showing-count">5</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Vista</p>
                    <p class="text-sm font-semibold text-gray-900" id="view-mode">Primeros 5</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0 lg:space-x-4">
            <!-- Search -->
            <div class="flex-1 max-w-lg">
                <div class="relative">
                    <input type="text" id="search-input" placeholder="Buscar por persona o mesa..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- View Options -->
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Mostrar:</label>
                <select id="items-per-page" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white text-sm">
                    <option value="5">Primeros 5</option>
                    <option value="10">Primeros 10</option>
                    <option value="25">Primeros 25</option>
                    <option value="all">Todos</option>
                </select>
            </div>

            <!-- Filter by Mesa -->
            <div class="flex-shrink-0">
                <select id="mesa-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white">
                    <option value="">Todas las mesas</option>
                    @foreach($comunidades->pluck('mesa.nombre', 'mesa.id')->unique() as $mesaId => $mesaNombre)
                        <option value="{{ $mesaNombre }}">{{ $mesaNombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-2">
                <button id="select-all-btn" class="px-3 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Seleccionar Visibles
                </button>
                <button id="delete-selected-btn" class="px-3 py-2 text-sm bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors hidden">
                    Eliminar Seleccionados
                </button>
                <button id="export-btn" class="px-3 py-2 text-sm bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Exportar
                </button>
            </div>
        </div>

        <!-- Selected items info -->
        <div id="selection-info" class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200 hidden">
            <div class="flex items-center justify-between">
                <span class="text-sm text-blue-800">
                    <span id="selected-count">0</span> elementos seleccionados
                </span>
                <button id="clear-selection" class="text-sm text-blue-600 hover:text-blue-800">
                    Limpiar selección
                </button>
            </div>
        </div>

        <!-- Pagination Info -->
        <div id="pagination-info" class="mt-4 flex items-center justify-between text-sm text-gray-600">
            <div>
                Mostrando <span id="items-from">1</span> a <span id="items-to">5</span> de <span id="total-items">{{ $comunidades->count() }}</span> resultados
            </div>
            <div class="flex items-center space-x-2">
                <button id="show-more-btn" class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200 transition-colors">
                    Ver más
                </button>
                <button id="show-less-btn" class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors hidden">
                    Ver menos
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="select-all-checkbox" class="rounded text-indigo-600 focus:ring-indigo-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors" onclick="sortTable(0)">
                            <div class="flex items-center space-x-1">
                                <span>Persona</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                </svg>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors" onclick="sortTable(1)">
                            <div class="flex items-center space-x-1">
                                <span>Mesa</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                </svg>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody id="table-body" class="bg-white divide-y divide-gray-200">
                    @foreach($comunidades as $index => $comunidad)
                        <tr class="table-row hover:bg-gray-50 transition-colors {{ $index >= 5 ? 'hidden' : '' }}" 
                            data-persona="{{ strtolower($comunidad->persona->nombre_completo) }}" 
                            data-mesa="{{ strtolower($comunidad->mesa->nombre) }}"
                            data-index="{{ $index }}">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="row-checkbox rounded text-indigo-600 focus:ring-indigo-500" value="{{ $comunidad->id }}">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-indigo-600">
                                                {{ substr($comunidad->persona->nombre_completo, 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $comunidad->persona->nombre_completo }}
                                        </div>
                                        @if(isset($comunidad->persona->email))
                                            <div class="text-sm text-gray-500">
                                                {{ $comunidad->persona->email }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    {{ $comunidad->mesa->nombre }}
                                </span>
                            </td>
                         
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Empty state -->
        <div id="empty-state" class="hidden text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron resultados</h3>
            <p class="text-gray-500">Intenta ajustar tus filtros de búsqueda</p>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Confirmar Eliminación</h3>
            <p class="text-sm text-gray-500 mb-4" id="delete-message">
                ¿Estás seguro de que deseas eliminar esta asignación?
            </p>
            <div class="flex justify-center space-x-3">
                <button id="cancel-delete" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                    Cancelar
                </button>
                <button id="confirm-delete" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const mesaFilter = document.getElementById('mesa-filter');
    const itemsPerPage = document.getElementById('items-per-page');
    const tableRows = document.querySelectorAll('.table-row');
    const emptyState = document.getElementById('empty-state');
    const tableBody = document.getElementById('table-body');
    const selectAllCheckbox = document.getElementById('select-all-checkbox');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const selectionInfo = document.getElementById('selection-info');
    const selectedCount = document.getElementById('selected-count');
    const deleteSelectedBtn = document.getElementById('delete-selected-btn');
    const showingCount = document.getElementById('showing-count');
    const viewMode = document.getElementById('view-mode');
    const showMoreBtn = document.getElementById('show-more-btn');
    const showLessBtn = document.getElementById('show-less-btn');
    const itemsFrom = document.getElementById('items-from');
    const itemsTo = document.getElementById('items-to');
    const totalItems = document.getElementById('total-items');

    let currentDeleteId = null;
    let currentLimit = 5;
    let filteredRows = Array.from(tableRows);

    // Update pagination display
    function updatePaginationInfo() {
        const visibleRows = filteredRows.filter(row => !row.classList.contains('hidden'));
        const total = filteredRows.length;
        const showing = Math.min(currentLimit === 'all' ? total : currentLimit, visibleRows.length);
        
        showingCount.textContent = showing;
        itemsFrom.textContent = total > 0 ? '1' : '0';
        itemsTo.textContent = showing;
        totalItems.textContent = total;

        // Update view mode text
        if (currentLimit === 'all') {
            viewMode.textContent = 'Todos';
            showMoreBtn.classList.add('hidden');
            showLessBtn.classList.remove('hidden');
        } else {
            viewMode.textContent = `Primeros ${currentLimit}`;
            showMoreBtn.classList.toggle('hidden', showing >= total);
            showLessBtn.classList.toggle('hidden', currentLimit === 5);
        }

        // Update show more/less button text
        if (total > showing && currentLimit !== 'all') {
            showMoreBtn.textContent = `Ver más (${total - showing} restantes)`;
        } else {
            showMoreBtn.textContent = 'Ver más';
        }
    }

    // Apply current limit to visible rows
    function applyLimit() {
        filteredRows.forEach((row, index) => {
            if (currentLimit === 'all' || index < currentLimit) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
                // Uncheck hidden rows
                const checkbox = row.querySelector('.row-checkbox');
                checkbox.checked = false;
            }
        });
        updatePaginationInfo();
        updateSelectionInfo();
    }

    // Search and filter functionality
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedMesa = mesaFilter.value.toLowerCase();
        
        filteredRows = Array.from(tableRows).filter(row => {
            const persona = row.dataset.persona;
            const mesa = row.dataset.mesa;
            
            const matchesSearch = persona.includes(searchTerm) || mesa.includes(searchTerm);
            const matchesMesa = selectedMesa === '' || mesa.includes(selectedMesa);
            
            return matchesSearch && matchesMesa;
        });

        // Hide all rows first
        tableRows.forEach(row => {
            row.classList.add('hidden');
            const checkbox = row.querySelector('.row-checkbox');
            checkbox.checked = false;
        });

        // Show filtered rows
        applyLimit();

        // Show/hide empty state
        if (filteredRows.length === 0) {
            emptyState.classList.remove('hidden');
            tableBody.classList.add('hidden');
        } else {
            emptyState.classList.add('hidden');
            tableBody.classList.remove('hidden');
        }
    }

    // Selection functionality
    function updateSelectionInfo() {
        const visibleCheckboxes = Array.from(rowCheckboxes).filter(cb => !cb.closest('.table-row').classList.contains('hidden'));
        const checkedBoxes = visibleCheckboxes.filter(cb => cb.checked);
        const count = checkedBoxes.length;
        
        selectedCount.textContent = count;
        
        if (count > 0) {
            selectionInfo.classList.remove('hidden');
            deleteSelectedBtn.classList.remove('hidden');
        } else {
            selectionInfo.classList.add('hidden');
            deleteSelectedBtn.classList.add('hidden');
        }

        // Update select all checkbox
        selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < visibleCheckboxes.length;
        selectAllCheckbox.checked = visibleCheckboxes.length > 0 && checkedBoxes.length === visibleCheckboxes.length;
    }

    // Event listeners
    searchInput.addEventListener('input', filterTable);
    mesaFilter.addEventListener('change', filterTable);

    itemsPerPage.addEventListener('change', function() {
        currentLimit = this.value === 'all' ? 'all' : parseInt(this.value);
        applyLimit();
    });

    showMoreBtn.addEventListener('click', function() {
        if (currentLimit === 5) {
            currentLimit = 10;
        } else if (currentLimit === 10) {
            currentLimit = 25;
        } else {
            currentLimit = 'all';
        }
        itemsPerPage.value = currentLimit;
        applyLimit();
    });

    showLessBtn.addEventListener('click', function() {
        currentLimit = 5;
        itemsPerPage.value = currentLimit;
        applyLimit();
    });

    selectAllCheckbox.addEventListener('change', function() {
        const visibleCheckboxes = Array.from(rowCheckboxes).filter(cb => !cb.closest('.table-row').classList.contains('hidden'));
        visibleCheckboxes.forEach(cb => cb.checked = this.checked);
        updateSelectionInfo();
    });

    rowCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateSelectionInfo);
    });

    document.getElementById('select-all-btn').addEventListener('click', function() {
        selectAllCheckbox.checked = true;
        selectAllCheckbox.dispatchEvent(new Event('change'));
    });

    document.getElementById('clear-selection').addEventListener('click', function() {
        rowCheckboxes.forEach(cb => cb.checked = false);
        selectAllCheckbox.checked = false;
        updateSelectionInfo();
    });

    // Export functionality
    document.getElementById('export-btn').addEventListener('click', function() {
        const visibleRows = filteredRows.filter(row => !row.classList.contains('hidden'));
        let csvContent = "Persona,Mesa\n";
        
        visibleRows.forEach(row => {
            const persona = row.querySelector('td:nth-child(2) .text-sm.font-medium').textContent.trim();
            const mesa = row.querySelector('td:nth-child(3) span').textContent.trim();
            csvContent += `"${persona}","${mesa}"\n`;
        });

        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'comunidades.csv';
        a.click();
        window.URL.revokeObjectURL(url);
    });

    // Modal functionality
    const deleteModal = document.getElementById('delete-modal');
    const deleteMessage = document.getElementById('delete-message');
    const cancelDelete = document.getElementById('cancel-delete');
    const confirmDelete = document.getElementById('confirm-delete');

    cancelDelete.addEventListener('click', function() {
        deleteModal.classList.add('hidden');
        currentDeleteId = null;
    });

    confirmDelete.addEventListener('click', function() {
        if (currentDeleteId) {
            // Create and submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/comunidades/${currentDeleteId}`;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.getAttribute('content');
                form.appendChild(csrfInput);
            }
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    });

    // Initialize
    updatePaginationInfo();
    updateSelectionInfo();
});

// Global functions for inline onclick handlers
function deleteComunidad(id, persona, mesa) {
    currentDeleteId = id;
    document.getElementById('delete-message').innerHTML = 
        `¿Estás seguro de que deseas eliminar la asignación de <strong>${persona}</strong> a la mesa <strong>${mesa}</strong>?`;
    document.getElementById('delete-modal').classList.remove('hidden');
}

function editComunidad(id) {
    // Redirect to edit page or open edit modal
    window.location.href = `/comunidades/${id}/edit`;
}

function sortTable(columnIndex) {
    const table = document.getElementById('table-body');
    const rows = Array.from(table.querySelectorAll('.table-row'));
    const isAscending = table.dataset.sortDirection !== 'asc';
    
    rows.sort((a, b) => {
        const aText = a.children[columnIndex + 1].textContent.trim().toLowerCase();
        const bText = b.children[columnIndex + 1].textContent.trim().toLowerCase();
        
        if (isAscending) {
            return aText.localeCompare(bText);
        } else {
            return bText.localeCompare(aText);
        }
    });
    
    rows.forEach(row => table.appendChild(row));
    table.dataset.sortDirection = isAscending ? 'asc' : 'desc';
    
    // Reapply current filters and limits
    filterTable();
}
</script>


</body>

</html>
