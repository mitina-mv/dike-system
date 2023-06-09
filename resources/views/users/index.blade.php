<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Список аккаунтов') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id="app">
                    <div class="caption d-flex mb-3">
                        <div class="h4">Преподаватели</div>
                        <a href="{{ route('users.createTeacher') }}" class="btn btn-success ml-2">Создать</a>
                    </div>
                    <table-filter 
                        :array='@json($teachers)' 
                        :addButtons='{{true}}'
                        :url="'/profile/'"
                        :columns='@json($teacherColumns)'
                    ></table-filter>

                    <div class="caption d-flex mt-3 mb-3">
                        <div class="h4">Студенты</div>
                        <a href="{{ route('users.createStudent') }}" class="btn btn-success ml-2">Создать</a>
                    </div>
                    <student-list 
                        :groups='@json($arGroupsStudent)'
                        :addGroupUrl="'{{ route('group.create') }}'"
                    ></student-list>

                    <notifications/>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
