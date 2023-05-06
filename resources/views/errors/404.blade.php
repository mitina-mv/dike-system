<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ошибка ') . $data['title'] }}
        </h2>
    </x-slot>

    <div class="error-page">
        {{ $data['title'] }} | {{ $data['message'] }}

        <a href="{{ $data['back_url'] }}">НАЗАД</a>
    </div>
</x-app-layout>
