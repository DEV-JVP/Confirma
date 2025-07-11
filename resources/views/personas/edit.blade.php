<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>


 
   <x-sidebar/>

    <div class="flex-1 p-6 bg-gray-100">
    <div class="max-w-xl mx-auto">
        <!-- Botón de volver -->
        <div class="mb-4">
            <a href="{{ route('personas.index') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                    <path d="m15 18-6-6 6-6"></path>
                </svg>
                Volver a la lista
            </a>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Editar Persona</h2>
            </div>

            @if ($errors->any())
            <div class="mx-6 mt-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded-md">
                <p class="font-medium">Se encontraron los siguientes errores:</p>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="p-6">
                <form action="{{ route('personas.update', $persona->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                     <div class="mb-5">
                        <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">Dni</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <input type="text" name="dni" id="dni"
                                value="{{ old('dni', $persona->dni) }}"
                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Nombre Completo -->
                    <div class="mb-5">
                        <label for="nombre_completo" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <input type="text" name="nombre_completo" id="nombre_completo"
                                value="{{ old('nombre_completo', $persona->nombre_completo) }}"
                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="mb-5">
                        <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                    <line x1="16" x2="16" y1="2" y2="6"></line>
                                    <line x1="8" x2="8" y1="2" y2="6"></line>
                                    <line x1="3" x2="21" y1="10" y2="10"></line>
                                </svg>
                            </div>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                                value="{{ old('fecha_nacimiento', $persona->fecha_nacimiento) }}"
                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Bautizo y Eucaristía -->
                    <div class="mb-5 grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-md p-3 border border-gray-200">
                            <div class="flex items-center">
                                <input id="bautizo" name="bautizo" type="checkbox" value="1" 
                                    {{ old('bautizo', $persona->bautizo) ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="bautizo" class="ml-2 block text-sm font-medium text-gray-700">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 text-blue-500">
                                            <path d="M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 6.75 7 5.3c-.29 1.45-1.14 2.84-2.29 3.76S3 11.1 3 12.25c0 2.22 1.8 4.05 4 4.05z"></path>
                                            <path d="M12.56 6.6A10.97 10.97 0 0 0 14 3.02c.5 2.5 2 4.9 4 6.5s3 3.5 3 5.5a6.98 6.98 0 0 1-11.91 4.97"></path>
                                        </svg>
                                        Bautizo
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-md p-3 border border-gray-200">
                            <div class="flex items-center">
                                <input id="eucaristia" name="eucaristia" type="checkbox" value="1" 
                                    {{ old('eucaristia', $persona->eucaristia) ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="eucaristia" class="ml-2 block text-sm font-medium text-gray-700">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 text-purple-500">
                                            <path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"></path>
                                            <path d="M8.5 8.5v.01"></path>
                                            <path d="M16 12v.01"></path>
                                            <path d="M12 16v.01"></path>
                                        </svg>
                                        Eucaristía
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Contacto -->
                    <div class="mb-5">
                        <label for="contacto" class="block text-sm font-medium text-gray-700 mb-1">Contacto</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                            </div>
                            <input type="text" name="contacto" id="contacto"
                                value="{{ old('contacto', $persona->contacto) }}"
                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Información del Apoderado -->
                    <div class="mb-5 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Información del Apoderado</h3>
                        
                        <!-- Nombre Apoderado -->
                        <div class="mb-4">
                            <label for="nombre_apoderado" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Apoderado</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <input type="text" name="nombre_apoderado" id="nombre_apoderado"
                                    value="{{ old('nombre_apoderado', $persona->nombre_apoderado) }}"
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Teléfono Apoderado -->
                        <div>
                            <label for="telefono_apoderado" class="block text-sm font-medium text-gray-700 mb-1">Teléfono del Apoderado</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="telefono_apoderado" id="telefono_apoderado"
                                    value="{{ old('telefono_apoderado', $persona->telefono_apoderado) }}"
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-3 mt-6">
                        <a href="{{ route('personas.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
