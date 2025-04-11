<x-mail::message>
    # {{ $communication->title }}

    Estimado(a) {{ $guardian->name }},

    {!! nl2br(e($communication->message)) !!}

    @if ($communication->course)
        <x-mail::panel>
            Este comunicado es específico para el curso: **{{ $communication->course->name }}**
        </x-mail::panel>
    @endif

    <x-mail::button :url="$url">
        Visitar Sitio Web
    </x-mail::button>

    Gracias,<br>
    {{ config('app.name') }}
</x-mail::message>
