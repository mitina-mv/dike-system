<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Шаблоны тестов') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">            
                @if (isset($error))
                    <?= $error?>
                @else

                    <div id="app">
                        <table-filter-discipline
                            :discipline='@json($discipline)'
                            :tabledata='@json($tests)'
                            url='/test'
                            :columns='@json($columns)'
                            :addactions='true'
                        ></table-filter-discipline>
                        
                        <notifications/>
                    </div>
                @endif
                
            </div>
        </div>
    </div>

</x-app-layout>