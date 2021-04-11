<x-app-layout>
    <x-container class="--container">
        <h1 class="page-title">ORDERS LIST: TASK #{{ $id }}</h1>
        <div class="overflow-auto" style="overflow: auto">
            <table class="border w-full">
                <tr>
                    <th class="px-2 border text-left"></th>
                    <th class="px-2 border text-left">Time:</th>
                    <th class="px-2 border text-left">Contacts:</th>
                    <th class="px-2 border text-left">Route:</th>
                    <th class="px-2 border text-left">Remark:</th>
                </tr>
            @foreach ($orders as $item)
                <x-orders.list-item :order="$item" />
            @endforeach
            </table>
            @if (!count($orders))
                ...no data on the task
            @endif
        </div>
    </x-container>
</x-app-layout>
