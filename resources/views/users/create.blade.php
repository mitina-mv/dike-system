<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- @if ($studgroups)
                {{ __('Добавление студентов') }}                
            @else
                {{ __('Добавление преподавателей') }}
            @endif --}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form action="{{ route('users.store') }}" method="post">
                    @csrf

                    <div id="app">
                        <student-form></student-form>

                    </div>

                    {{-- studgroups --}}
                    {{-- @if ($studgroups)
                        <div class="mt-4">
                            <x-label for="role" :value="__('Роль пользователя')" />

                            <select name="role_id" id="role" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
                                @foreach ($studgroups as $studgroup)
                                    <option value="{{ $studgroup->id }}">{{ $studgroup->studgroup_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif --}}

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
