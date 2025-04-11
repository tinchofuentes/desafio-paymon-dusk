<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center mb-8">
                        <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-900">
                            ¡Inscripción Exitosa!
                        </h2>
                        <p class="mt-2 text-gray-600">
                            Gracias por inscribirte en nuestro curso.
                        </p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-md mb-6 text-gray-900">
                        <h3 class="font-medium text-lg mb-2">
                            Detalles de la inscripción
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">
                                    Estudiante:
                                </p>
                                <p class="font-medium">
                                    {{ $enrollment->student->full_name }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">
                                    Curso:
                                </p>
                                <p class="font-medium">
                                    {{ $enrollment->course->name }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">
                                    Academia:
                                </p>
                                <p class="font-medium">
                                    {{ $enrollment->course->academy->name }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">
                                    Fecha de inscripción:
                                </p>
                                <p class="font-medium">
                                    {{ $enrollment->enrollment_date->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-md mb-6 text-gray-900">
                        <h3 class="font-medium text-lg mb-2">
                            Detalles del pago
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">
                                    Monto:
                                </p>
                                <p class="font-medium">
                                    ${{ number_format($enrollment->payments->first()->amount, 2) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">
                                    Método de pago:
                                </p>
                                <p class="font-medium">
                                    {{ $enrollment->payments->first()->method }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">
                                    Estado:
                                </p>
                                <p class="font-medium">
                                    {{ $enrollment->status }}
                                </p>
                            </div>
                            @if($enrollment->payments->first()->reference_number)
                                <div>
                                    <p class="text-sm text-gray-500">
                                        Número de referencia:
                                    </p>
                                    <p class="font-medium">
                                        {{ $enrollment->payments->first()->reference_number }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="text-center mt-8">
                        <p class="mb-4 text-gray-600">
                            Hemos enviado un correo electrónico con los detalles de la inscripción a {{ $enrollment->student->guardian->email }}
                        </p>
                        <a href="{{ route('home') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            Volver al inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 