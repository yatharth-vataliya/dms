<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="p-2 mt-2 rounded-lg shadow-sm container mx-auto">
        <x-card-component>
            <x-slot name="card_header">
                Total Files {{ $files_count }}
            </x-slot>
            <x-slot name="card_body">
                Total used space {{ $total_size }} MB
            </x-slot>
            <x-slot name="card_footer">
                Your Storage Limit {{ auth()->user()->storage_limit }} GB
            </x-slot>
        </x-card-component>
    </div>
</x-app-layout>
