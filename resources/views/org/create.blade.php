<x-guest-layout>
    <div class='w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg'>
        <form method="POST" action="{{ route('org.store') }}">
            @csrf

            <!-- org name -->
            <div>
                <x-label for="org_name" :value="__('Название организации')" />

                <x-input id="org_name" class="block mt-1 w-full" type="text" name="org_name" :value="old('org_name')" required autofocus />
            </div>

            <!-- org address -->
            <div>
                <x-label for="org_address" :value="__('Адрес организации')" />

                <x-input id="org_address" class="block mt-1 w-full" type="text" name="org_address" :value="old('org_address')" required />
            </div>

            <x-button class="ml-4">
                {{ __('Добавить') }}
            </x-button>
        </form>
    </div>
</x-guest-layout>
