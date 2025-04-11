<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:p-8">
    <div class="text-center">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            Nuestra Oferta Académica
        </h2>
        <p class="mx-auto mt-3 max-w-2xl text-xl text-gray-500 sm:mt-4">
            Explora nuestras academias y cursos disponibles para inscripción
        </p>
    </div>

    <div class="mt-12 space-y-12">
        @forelse ($academies as $academy)
            <div class="overflow-hidden rounded-lg bg-white shadow-md border border-gray-100">
                <div class="px-6 py-5">
                    <h3 class="text-xl font-bold text-gray-900">
                        {{ $academy->name }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ $academy->description }}
                    </p>
                </div>
                
                <div class="px-6 pb-6">
                    <h4 class="mb-5 text-lg font-semibold text-gray-900">
                        Cursos Disponibles
                    </h4>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                        @forelse ($academy->courses as $course)
                            <livewire:components.course-card :course="$course" :key="$course->id" />
                        @empty
                            <div class="col-span-full">
                                <p class="text-center text-gray-500">
                                    No hay cursos disponibles para esta academia en este momento.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-md bg-yellow-50 p-4 border border-yellow-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">
                            No hay academias disponibles
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Actualmente, no hay academias activas. Por favor, vuelve más tarde.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>