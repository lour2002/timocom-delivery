<x-app-layout>
    <x-container class="--container">
        <h1 class="page-title">CONTROL PANEL</h1>
        <div>
            <h2>Task list / {{ date('Y-m-d H:i:s') }}</h2>
            @foreach ($orders as $item)
                {{ $item['id'] }}
            @endforeach
        </div>
    </x-container>
</x-app-layout>
