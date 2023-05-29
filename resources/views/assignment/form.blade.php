<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Назначение тестирования') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">            
                @if (isset($error))
                    <?= $error?>
                @else
                    <div id="app">
                        
                        <notifications/>
                    </div>
                @endif
                
            </div>
        </div>
    </div>

</x-app-layout>