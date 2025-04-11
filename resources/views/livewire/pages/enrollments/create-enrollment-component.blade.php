<div class="max-w-3xl mx-auto px-4 py-8">
    <header>
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-8">
            Inscripción a Curso
        </h2>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 text-gray-900">
            <h3 class="text-lg font-medium mb-4">
                Resumen de la inscripción
            </h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    @if ($course)
                        <p class="text-sm mb-1">
                            <span class="font-semibold">Curso:</span> {{ $course->name }}
                        </p>
                        <p class="text-sm mb-1">
                            <span class="font-semibold">Academia:</span> {{ $course->academy->name }}
                        </p>
                        <p class="text-sm">
                            <span class="font-semibold">Costo:</span> ${{ number_format($course->cost, 2) }}
                        </p>
                    @else
                        <p class="text-sm text-gray-500 italic">
                            Seleccione un curso para ver el resumen
                        </p>
                    @endif
                </div>
            </div>
        </div>        
    </header>

    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            @for ($i = 1; $i <= $totalSteps; $i++)
                <div class="flex items-center">
                    <div
                        class="@if ($i <= $currentStep) bg-blue-500 @else bg-gray-300 @endif w-10 h-10 rounded-full flex items-center justify-center text-white font-bold"
                    >
                        {{ $i }}
                    </div>
                    <div
                        class="ml-2 @if ($i <= $currentStep) text-blue-500 font-medium @else text-gray-500 @endif"
                    >
                        @if ($i == 1)
                            Datos del Apoderado
                        @elseif($i == 2)
                            Datos del Estudiante
                        @elseif($i == 3)
                            Información de Pago
                        @endif
                    </div>
                </div>

                @if ($i < $totalSteps)
                    <div
                        class="flex-grow mx-4 h-1 @if ($i < $currentStep) bg-blue-500 @else bg-gray-300 @endif">
                    </div>
                @endif
            @endfor
        </div>
    </div>

    <form 
        wire:submit.prevent="submit"
        class="[&_input]:text-gray-900 [&_select]:text-gray-900 [&_option]:text-gray-900 [&_label]:text-gray-900 [&_button]:text-gray-900 [&_h3]:text-gray-900"
    >
        @if ($currentStep == 1)
            <!-- Datos del Apoderado -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-medium mb-4">
                    Datos del Apoderado
                </h3>

                <div class="mb-4">
                    <label for="guardian_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre completo
                    </label>
                    <input 
                        type="text" 
                        id="guardian_name" 
                        wire:model="guardian_name"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    >
                    @error('guardian_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="guardian_email" class="block text-sm font-medium text-gray-700 mb-1">
                        Correo lectrónico
                    </label>
                    <input 
                        type="email" 
                        id="guardian_email" 
                        wire:model="guardian_email"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    >
                    @error('guardian_email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="guardian_phone" class="block text-sm font-medium text-gray-700 mb-1">
                        Teléfono
                    </label>
                    <input
                        type="text" 
                        id="guardian_phone" 
                        wire:model="guardian_phone"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    >
                    @error('guardian_phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @elseif($currentStep == 2)
            <!-- Datos del Estudiante -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-medium mb-4">
                    Datos del Estudiante
                </h3>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="student_first_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nombres
                        </label>
                        <input 
                            type="text" 
                            id="student_first_name" 
                            wire:model="student_first_name"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        >
                        @error('student_first_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="student_last_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Apellidos
                        </label>
                        <input 
                            type="text" 
                            id="student_last_name" 
                            wire:model="student_last_name"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        >
                        @error('student_last_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="student_birth_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Fecha de nacimiento
                        </label>
                        <input 
                            type="date" 
                            id="student_birth_date" 
                            wire:model="student_birth_date"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('student_birth_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="student_gender" class="block text-sm font-medium text-gray-700 mb-1">
                            Género
                        </label>
                        <select 
                            id="student_gender" 
                            wire:model="student_gender"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Seleccionar</option>
                            @foreach ($genderOptions as $option)
                                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                            @endforeach
                        </select>
                        @error('student_gender')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Curso
                    </label>
                    <select id="course_id" wire:model.live="course_id"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar un curso</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }} - {{ $course->academy->name }} -
                                ${{ number_format($course->cost, 2) }}</option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @elseif($currentStep == 3)
            <!-- Información de Pago -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-medium mb-4">
                    Información de Pago
                </h3>

                <div class="mb-4">
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">
                        Método de pago
                    </label>
                    <select 
                        id="payment_method" 
                        wire:model.live="payment_method"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">Seleccionar método de pago</option>
                        @foreach ($paymentMethods as $method)
                            <option value="{{ $method['value'] }}">{{ $method['label'] }}</option>
                        @endforeach
                    </select>
                    @error('payment_method')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                @if ($payment_method === 'bank_transfer')
                    <div class="mb-4">
                        <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-1">
                            Número de referencia
                        </label>
                        <input 
                            type="text" 
                            id="reference_number" 
                            wire:model="reference_number"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('reference_number')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                <div class="bg-gray-50 p-4 rounded-md mt-6 text-gray-900">
                    <h4 class="font-medium mb-2">
                        Resumen de pago
                    </h4>
                    <div class="flex justify-between mb-2">
                        <span>Costo del curso:</span>
                        <span>${{ number_format($course_cost, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-medium text-lg pt-2 border-t">
                        <span>Total a pagar:</span>
                        <span>${{ number_format($course_cost, 2) }}</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex justify-between mt-6">
            @if ($currentStep > 1)
                <button type="button" wire:click="previousStep" class="px-4 py-2 bg-gray-200 rounded-md">
                    Anterior
                </button>
            @else
                <div></div>
            @endif

            @if ($currentStep < $totalSteps)
                <button type="button" wire:click="nextStep" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                    Siguiente
                </button>
            @else
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md">
                    Completar inscripción
                </button>
            @endif
        </div>
    </form>
</div>
