<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="bg-white p-2 mt-2 rounded-lg shadow-sm container mx-auto">
        <x-card-component>
            <x-slot name="card_header">
                Just Card Header
            </x-slot>
            <x-slot name="card_body">
                Just Card Body
            </x-slot>
            <x-slot name="card_footer">
                Just Card Footer
            </x-slot>
        </x-card-component>
    </div>
</x-app-layout>
