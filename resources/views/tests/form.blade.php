<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактирование / добавление') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">            
                @if (isset($error))
                    <?= $error?>
                @else
                    <div id="app">
                        <test-form
                            :disciplines='@json($discipline)'
                            @if (isset($test))
                                :test='@json($test)'
                            @endif

                        ></test-form>
                        
                        <notifications/>
                    </div>
                @endif
                
            </div>
        </div>
    </div>

</x-app-layout>