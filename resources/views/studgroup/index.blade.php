<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Добавление группы студентов') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">            
                @if (isset($error))
                    <?= $error?>
                @else
                    <div id="app">
                        <studgroup-form
                            label='Название группы студентов'
                            url="/group/create"
                        ></studgroup-form>
                        <notifications/>
                    </div>
                @endif
                
            </div>
        </div>
    </div>

</x-app-layout>