<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Список пользователей от организации') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id="app">
                    <div class="caption d-flex">
                        <div class="h4">Студенты</div>
                        <a href="{{ route('user.createStudent') }}" class="btn btn-success ml-2">Создать</a>
                    </div>
                    <student-list :groups='@json($arGroupsStudent)'></student-list>
                </div>

                
            </div>
        </div>
    </div>

    
</x-app-layout>