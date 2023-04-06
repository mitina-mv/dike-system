<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Добавление студентов') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form action="{{ route('users.store_student') }}" method="post">
                    @csrf

                    <div id="app">
                        <student-form :groups='@json($studgroups)'></student-form>
                    </div>

                    <x-button class="ml-4">
                        {{ __('Сохранить') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
