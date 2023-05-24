<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Добавление дисциплины') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('discipline.create') }}">
                    @csrf 
                    @if (isset($error))
                        <?= $error?>
                    @endif
                    
                    <!-- org name -->
                    <div>
                        <x-label for="discipline_name" :value="__('Название дисциплины')" />

                        <x-input id="discipline_name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    </div>

                    <x-button class="ml-4">
                        {{ __('Добавить') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>