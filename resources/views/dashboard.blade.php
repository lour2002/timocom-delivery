<x-app-layout>
    <x-container class="--container">
        <h1 class="page-title">CONTROL PANEL</h1>
        <div>
            <h2>Task list / {{ date('Y-m-d H:i:s') }}</h2>
            @foreach ($list as $task)
                <x-search-task.list-item :task="$task" />
            @endforeach
            @if (count($list) < 5)
                <a href="{{ route('task') }}" class="btn --primary">ADD NEW TASK</a>
            @endif
        </div>
    </x-container>
</x-app-layout>
