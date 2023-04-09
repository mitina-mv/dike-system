<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Добавление студентов') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form action="{{ route('users.store_teacher') }}" method="post">
                    @csrf

                    <div id="app">
                        <teacher-form :groups='@json($studgroups)'></teacher-form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
