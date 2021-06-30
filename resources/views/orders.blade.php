<x-app-layout>
    <x-container class="--container">
        <form action="/clean/" method="GET" id="clean-orders"></form>
        <div class="flex items-center mb-3">
            <h1 class="page-title mb-0 flex-grow">ORDERS LIST: TASK #{{ $id }}</h1>
            <x-button
                form="clean-orders"
                color="--success"
                :disabled="$disabled">
               Clear history for all tasks
            </x-button>
        </div>
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
