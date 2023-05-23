<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Банк заданий') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

            @if (isset($error))
                <?= $error?>
            @else
                <div id="app">
                    <question-list
                        :questions='@json($questions)'
                        :discipline='@json($discipline)'
                    ></question-list>

                    @php
                        $options = [
                            'columns'=> [[
                                'title' =>  'Текст вопроса',
                                'field' =>  'question_text',
                                'sorter' =>  'string',
                                'headerFilter' => true
                            ],[
                                'title' =>  'Привaтность',
                                'field' =>  'question_private',
                                'formatter' => "tickCross"
                            ], 
                        ]
                    ];
                    @endphp
                    {{-- <VueTabulator v-model="@json($questions)" :options="@json($options)" /> --}}
                    {{-- <tabulator-table/> --}}
                    <notifications/>
                </div>
            @endif

            </div>
        </div>
    </div>

</x-app-layout>