

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
    <div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Nueva Fecha de Asistencia</h2>
                    <p class="text-gray-600 mt-1">Seleccione la fecha para registrar asistencias.</p>
                </div>

                <form action="{{ route('asistencias.storeFecha') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="max-w-md">
                        <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Asistencia</label>
                        <input type="date" id="fecha" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('fecha') border-red-500 @enderror">
                        @error('fecha')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('asistencias.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                            Continuar a Marcación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>

