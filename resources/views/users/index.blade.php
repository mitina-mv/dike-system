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

                <div class="teacher-list">
                    <div class="caption d-flex mt-3 mb-3">
                        <div class="h4">Преподаватели</div>
                        <a href="{{ route('user.createTeacher') }}" class="btn btn-success ml-2">Создать</a>
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <th>ФИО</th>
                            <th>Email</th>
                            <th>Группы</th>
                            <th>Действия</th>
                        </thead>
    
                        <tbody>
                            @foreach ($teachers as $item)
                                <tr>
                                    <td>
                                        {{ $item['user_lastname'] . ' '. $item['user_firstname'] . $item['user_patronymic'] }}
                                    </td>
    
                                    <td>{{ $item['user_email'] }}</td>
    
                                    <td>
                                        {{ implode(', ', array_column($item['groups'], 'studgroup_name')) }}
                                    </td>
    
                                    <td>
                                        <a
                                            href="{{'/users/teacher/' . $item['id']}}"
                                            class="btn btn-outline-success"
                                        >
                                            Редактировать
                                        </a>
    
                                        <button class="btn btn-outline-danger ml-2">
                                            Удалить
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>                
            </div>
        </div>
    </div>

    
</x-app-layout>