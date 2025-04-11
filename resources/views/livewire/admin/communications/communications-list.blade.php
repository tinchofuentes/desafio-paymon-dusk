<div>
    <!-- Filtros -->
    <div class="mb-6 bg-gray-50 p-4 rounded-md">
        <div class="flex flex-wrap gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                    Buscar
                </label>
                <input 
                    type="text" 
                    id="search" 
                    wire:model.live="search" 
                    placeholder="Título o contenido"
                    class="w-full border-gray-300 rounded-md shadow-sm"
                >
            </div>
            <div class="w-48">
                <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">
                    Estado
                </label>
                <select 
                    id="statusFilter" 
                    wire:model.live="statusFilter"
                    class="w-full border-gray-300 rounded-md shadow-sm"
                >
                    <option value="">Todos</option>
                    @foreach ($statusOptions as $option)
                        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-48">
                <label for="dateFilter" class="block text-sm font-medium text-gray-700 mb-1">
                    Fecha envío
                </label>
                <input 
                    type="date" 
                    id="dateFilter"
                    wire:model.live="dateFilter"
                    class="w-full border-gray-300 rounded-md shadow-sm"
                >
            </div>
        </div>
    </div>

    <!-- Tabla de comunicados -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Título
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Curso
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Rango de Edad
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Fecha de Envío
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Estado
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($communications as $communication)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $communication->title }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                {{ $communication->course ? $communication->course->name : 'Todos los cursos' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                @if ($communication->age_from && $communication->age_to)
                                    {{ $communication->age_from }} - {{ $communication->age_to }} años
                                @elseif($communication->age_from)
                                    Desde {{ $communication->age_from }} años
                                @elseif($communication->age_to)
                                    Hasta {{ $communication->age_to }} años
                                @else
                                    Todas las edades
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                {{ $communication->send_date ? $communication->send_date->format('d/m/Y') : 'No programado' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if ($communication->status->value === 'sent') bg-green-100 text-green-800
                                @elseif($communication->status->value === 'scheduled') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif
                            ">
                                {{ $communication->status->label() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="view({{ $communication->id }})"
                                class="text-indigo-600 hover:text-indigo-900 mr-3">
                                Ver
                            </button>
                            <button wire:click="edit({{ $communication->id }})"
                                class="text-blue-600 hover:text-blue-900 mr-3">
                                Editar
                            </button>
                            @if ($communication->status->value !== 'sent')
                                <button wire:click="send({{ $communication->id }})"
                                    class="text-green-600 hover:text-green-900 mr-3">
                                    Enviar
                                </button>
                            @endif
                            <button 
                                x-data=""
                                x-on:click="$dispatch('open-modal', 'confirm-delete-{{ $communication->id }}')"
                                class="text-red-600 hover:text-red-900">
                                Eliminar
                            </button>

                            <x-modal name="confirm-delete-{{ $communication->id }}" maxWidth="xl">
                                <div class="p-6">
                                    <h2 class="text-lg font-medium text-gray-900">
                                        ¿Estás seguro de eliminar este comunicado?
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Esta acción no se puede deshacer.
                                    </p>
                                    <div class="mt-6 flex justify-end space-x-3">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            Cancelar
                                        </x-secondary-button>
                                        <x-danger-button wire:click="delete({{ $communication->id }})" wire:loading.attr="disabled">
                                            Eliminar Comunicado
                                        </x-danger-button>
                                    </div>
                                </div>
                            </x-modal>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No hay comunicados disponibles
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $communications->links() }}
    </div>
</div>
