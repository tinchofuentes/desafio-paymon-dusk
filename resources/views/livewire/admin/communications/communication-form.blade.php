<div>
    @if ($isOpen)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-20" id="modal">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        @if ($viewMode)
                            Ver Comunicado
                        @elseif($editMode && $communication_id)
                            Editar Comunicado
                        @else
                            Crear Comunicado
                        @endif
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                @if (!$viewMode)
                    <form wire:submit.prevent="store">
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                Título
                            </label>
                            <input 
                                type="text" 
                                id="title" 
                                wire:model="title"
                                class="w-full border-gray-300 rounded-md shadow-sm" @if ($viewMode) disabled @endif
                            >
                            @error('title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                                Mensaje
                            </label>
                            <textarea 
                                id="message" 
                                wire:model="message" 
                                rows="6"
                                class="w-full border-gray-300 rounded-md shadow-sm" @if ($viewMode) disabled @endif
                            ></textarea>
                            @error('message')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Curso (opcional)
                                </label>
                                <select 
                                    id="course_id" 
                                    wire:model="course_id"
                                    class="w-full border-gray-300 rounded-md shadow-sm" @if ($viewMode) disabled @endif
                                >
                                    <option value="">Todos los cursos</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                    Estado
                                </label>
                                <select 
                                    id="status" 
                                    wire:model="status"
                                    class="w-full border-gray-300 rounded-md shadow-sm" @if ($viewMode) disabled @endif
                                >
                                    @foreach ($statusOptions as $option)
                                        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="age_from" class="block text-sm font-medium text-gray-700 mb-1">
                                    Edad desde(opcional)
                                </label>
                                <input 
                                    type="number" 
                                    id="age_from" 
                                    wire:model="age_from"
                                    class="w-full border-gray-300 rounded-md shadow-sm" 
                                    min="1" 
                                    max="99"
                                    @if ($viewMode) disabled @endif
                                >
                                @error('age_from')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="age_to" class="block text-sm font-medium text-gray-700 mb-1">
                                    Edad hasta (opcional)
                                </label>
                                <input 
                                    type="number" 
                                    id="age_to" 
                                    wire:model="age_to"
                                    class="w-full border-gray-300 rounded-md shadow-sm" 
                                    min="1" 
                                    max="99"
                                    @if ($viewMode) disabled @endif
                                >
                                @error('age_to')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="send_date" class="block text-sm font-medium text-gray-700 mb-1">
                                    Fecha de envío
                                </label>
                                <input 
                                    type="date"
                                    id="send_date" 
                                    wire:model="send_date"
                                    class="w-full border-gray-300 rounded-md shadow-sm" @if ($viewMode) disabled @endif
                                >
                                @error('send_date')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button 
                                type="button" 
                                wire:click="closeModal"
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md mr-2"
                            >
                                Cancelar
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                                {{ $communication_id ? 'Actualizar' : 'Guardar' }}
                            </button>
                        </div>
                    </form>
                @else
                    <div class="mb-4 border-b pb-4 text-gray-900">
                        <h3 class="text-lg font-semibold">{{ $title }}</h3>
                        <div class="mt-2 text-gray-700">
                            {!! nl2br(e($message)) !!}
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4 text-gray-900">
                        <div>
                            <p class="text-sm text-gray-600">
                                Curso:
                            </p>
                            <p class="font-medium">
                                {{ $course_id ? $courses->firstWhere('id', $course_id)->name : 'Todos los cursos' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">
                                Estado:
                            </p>
                            <p class="font-medium">
                                {{ collect($statusOptions)->firstWhere('value', $status)['label'] }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">
                                Rango de edad:
                            </p>
                            <p class="font-medium">
                                @if ($age_from && $age_to)
                                    {{ $age_from }} - {{ $age_to }} años
                                @elseif($age_from)
                                    Desde {{ $age_from }} años
                                @elseif($age_to)
                                    Hasta {{ $age_to }} años
                                @else
                                    Todas las edades
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">
                                Fecha de envío:
                            </p>
                            <p class="font-medium">
                                {{ $send_date ? \Carbon\Carbon::parse($send_date)->format('d/m/Y') : 'No programado' }}
                            </p>
                        </div>
                    </div>

                    @if ($communication && $communication->guardians && $communication->guardians->count() > 0)
                        <div class="mt-4 text-gray-900">
                            <h4 class="font-medium mb-2">
                                Destinatarios ({{ $communication->guardians->count() }}):
                            </h4>
                            <div class="max-h-40 overflow-y-auto border rounded-md p-2">
                                <ul class="divide-y">
                                    @foreach ($communication->guardians as $guardian)
                                        <li class="py-2">
                                            <p class="font-medium">{{ $guardian->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $guardian->email }}</p>
                                            <p class="text-xs text-gray-500">
                                                @if ($guardian->pivot->read_at)
                                                    Leído: {{ \Carbon\Carbon::parse($guardian->pivot->read_at)->format('d/m/Y H:i') }}
                                                @else
                                                    No leído
                                                @endif
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-end mt-4">
                        <button type="button" wire:click="closeModal"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">
                            Cerrar
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
