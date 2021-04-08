<x-app-layout>
    <x-container class="--container">
        <h1 class="page-title">ORDERS LIST: TASK #{{ $id }}</h1>
        <div>
            <table class="border w-full">
                <tr>
                    <th class="border text-left"></th>
                    <th class="border text-left"></th>
                    <th class="border text-left"></th>
                    <th class="border text-left">ROUTE:</th>
                    <th class="border text-left">REMARK:</th>
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
