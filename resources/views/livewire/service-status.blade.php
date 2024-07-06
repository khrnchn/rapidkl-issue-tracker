<div>
    <x-filament::section>
        <x-slot name="heading">
            Service Status
        </x-slot>
        <x-slot name="description">
            Real-time train service status as well as service updates operated by RapidKL, provided by
            <x-filament::link>MTREC</x-filament::link>
        </x-slot>
        <x-slot name="header">
            <h2 class="font-bold">
                Service Status
            </h2>
        </x-slot>

        @if($serviceStatus)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($serviceStatus['Data'] as $service)
            <div class="bg-gray-100 rounded-lg p-4">
                <h3 class="text-lg font-bold">{{ $service['Line'] }}</h3>
                <p class="text-gray-600">{{ $service['Status'] }}</p>
                @if($service['Remark'])
                <p class="text-gray-600 mt-2">{{ $service['Remark'] }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="flex justify-center items-center h-48">
            <x-filament::loading-indicator />
        </div>
        @endif
    </x-filament::section>
</div>