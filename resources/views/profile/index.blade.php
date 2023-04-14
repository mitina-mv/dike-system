<x-app-layout>
    @php
    // dd($user->groups[0]->id);
@endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактирование: ') . $user->user_lastname . ' ' . $user->user_firstname }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form action="{{ route('profile.update', $user->id) }}" method="post" class='dd'>
                    @csrf

                    <!-- user_lastname -->
                    <div>
                        <x-label for="user_lastname" :value="__('Фамилия')" />

                        <x-input id="user_lastname" class="block mt-1 w-full" type="text" name="user_lastname" value="{{$user->user_lastname}}" required autofocus />
                    </div>

                    <!-- user_firstname -->
                    <div>
                        <x-label for="user_firstname" :value="__('Имя')" />

                        <x-input id="user_firstname" class="block mt-1 w-full" type="text" name="user_firstname" value="{{$user->user_firstname}}" required autofocus />
                    </div>

                    <!-- user_lastname -->
                    <div>
                        <x-label for="user_patronymic" :value="__('Отчество')" />

                        <x-input id="user_patronymic" class="block mt-1 w-full" type="text" name="user_patronymic" value="{{$user->user_patronymic}}" required autofocus />
                    </div>

                    <!-- user_email -->
                    <div>
                        <x-label for="user_email" :value="__('Email')" />

                        <x-input id="user_email" class="block mt-1 w-full" type="text" name="user_email" value="{{$user->user_email}}" required autofocus />
                    </div>

                    {{-- stud group select --}}
                    @if ($user->role_id == 3)
                        <div>
                            <x-label for="studgroup_id" :value="__('Группа студентов')" />

                            <select name="studgroup_id" id="studgroup_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
                                @foreach ($studgroups as $studgroup)
                                    <option 
                                        value="{{ $studgroup->id }}"
                                        @if ($studgroup->id == $user->studgroup_id)
                                            selected
                                        @endif
                                    >
                                        {{ $studgroup->studgroup_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @elseif($user->role_id == 2)
                        <div>
                            <x-label for="groups" :value="__('Группы студентов')" />

                            <select name="groups" id="groups" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required multiple>
                               
                                @foreach ($studgroups as $studgroup)
                                    <option 
                                        value="{{ $studgroup->id }}"
                                        @if (in_array($studgroup->id, $user['groups']))
                                            selected
                                        @endif
                                    >
                                        {{ $studgroup->studgroup_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- если пользователь редактирует свой профиль --}}
                    @if(Auth::user()->id == $user->id)
                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('Пароль')" />

                            <x-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            autocomplete="new-password" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Повторите пароль')" />

                            <x-input id="password_confirmation" class="block mt-1 w-full"
                                            type="password"
                                            name="password_confirmation"/>
                        </div>
                    @endif


                    <x-button class="mt-3">
                        {{ __('Сохранить') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
