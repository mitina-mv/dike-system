<x-app-layout>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">            
                @if (isset($error))
                    <?= $error?>
                @else
                    <div id="app">
                        <testing
                            :testing='@json($structureTest)'
                            :testlogid='<?= $testlog_id?>'
                        ></testing>
                        <notifications/>
                    </div>
                @endif
                
            </div>
        </div>
    </div>

</x-app-layout>