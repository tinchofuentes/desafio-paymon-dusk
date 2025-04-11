<div class="py-12 [&_h2]:text-gray-900 [&_input]:text-gray-900 [&_select]:text-gray-900 [&_textarea]:text-gray-900 ">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">
                        Gestión de Comunicados
                    </h2>
                    <button wire:click="create" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Nuevo Comunicado
                    </button>
                </div>

                @if ($successMessage)
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ $successMessage }}
                    </div>
                @endif

                @if ($errorMessage)
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        {{ $errorMessage }}
                    </div>
                @endif

                <livewire:admin.communications.communications-list />
            </div>
        </div>
    </div>

    <livewire:admin.communications.communication-form />
</div>
