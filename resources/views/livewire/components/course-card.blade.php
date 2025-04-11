<div class="bg-gray-50 rounded-lg p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
    <h3 class="text-lg font-semibold text-gray-900 mb-2">
        {{ $course->name }}
    </h3>
    <div class="mb-4 text-sm text-gray-600">
        {{ $course->description }}
    </div>
    <div class="mt-4 space-y-3 border-t pt-4">
        <div class="flex justify-between">
            <span class="text-sm font-medium text-gray-500">
                Cost:
            </span>
            <span class="text-sm font-semibold text-gray-900">
                ${{ number_format($course->cost, 2) }}
            </span>
        </div>
        <div class="flex justify-between">
            <span class="text-sm font-medium text-gray-500">
                Duration:
            </span>
            <span class="text-sm font-semibold text-gray-900">
                {{ $course->duration }} hours
            </span>
        </div>
        <div class="flex justify-between">
            <span class="text-sm font-medium text-gray-500">
                Modality:
            </span>
            <span class="text-sm font-semibold text-gray-900 capitalize">
                {{ str_replace('-', ' ', $course->modality->value) }}
            </span>
        </div>
        @if($course->start_date)
            <div class="flex justify-between">
                <span class="text-sm font-medium text-gray-500">
                    Starts:
                </span>
                <span class="text-sm font-semibold text-gray-900">
                    {{ $course->start_date->format('M d, Y') }}
                </span>
            </div>
        @endif
    </div>
    <div class="mt-6">
        <a 
            href="{{ route('enrollment.create', ['course' => $course->id]) }}"
            wire:navigate
            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 transition"
        >
            Enroll Now
        </a>
    </div>
</div> 