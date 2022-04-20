<div class="mb-3 px-3">
    <a class="row cursor-pointer" href="{{ route('platform.task.edit', ['task' => $task->id]) }}">
    <div class="col-lg-12">
        #{{ $task->id }} | <span class="">{{ $task->getStatusTitle() }}</span> | <b>{{$task->name}}</b>
    </div>
    <div class="col-lg-12">
        <div class="fs085">
            <span class="line-title">FROM:</span> [{{ $task->getFromType() }}] <i class="fas fa-arrow-alt-down text-success"></i>
            <span class="text-primary">{{$task->as_country}}, {{$task->as_zip}}, radius: {{$task->as_radius}}</span>
        </div>
        <div class="fs085">
            <span class="line-title">TO:</span> [{{ $task->getToType() }}] <i class="fas fa-arrow-alt-up text-primary"></i>
            <span class="text-primary">{{ $task->getCountriesList() }}</span>
        </div>
        <div class="fs085">
            <span class="line-title">DATE:</span> [{{ $task->getDateType() }}]
            <span class="text-primary">{{ $task->individual_days }}</span>
        </div>
        <div class="fs085">
            <span class="line-title">Сost of 1 km / €:</span>
            <span class="text-primary">{{ $task->car_price }}</span>
        </div>
    </div>
</a>
</div>