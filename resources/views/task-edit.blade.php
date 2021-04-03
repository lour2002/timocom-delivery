<x-app-layout>
    <x-container class="--container">
        <h2 class="page-title">
            @if ($task['id'] ?? false)
                TASK #{{ $task['id']}}
            @else
                NEW TASK
            @endif
        </h2>

        <x-search-task.edit :search-task="$task" />
    </x-container>
</x-app-layout>
