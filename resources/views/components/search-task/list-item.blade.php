<div {{ $attributes }} class="block content-container --form">
    <div class="flex">
        <div class="w-7/12">
            <a class="row cursor-pointer" href="{{ route('task', ['id' => $task_id]) }}">
                <div class="col-lg-12">
                    <span class="badge badge-danger">#{{ $task_id }} | </span> <span class="fs085"><b>{{$task_name}}</b></span>
                </div>
                <div class="col-lg-12">
                    <div class="fs085">
                        <span class="line-title">FROM:</span> [{{ $task_from_type }}] <i class="fas fa-arrow-alt-down text-success"></i>
                        <span class="text-primary">{{$task_from_country}}, {{$task_from_zip}}, radius: {{$task_from_radius}}</span>
                    </div>
                    <div class="fs085">
                        <span class="line-title">TO:</span> [{{$task_to_type}}] <i class="fas fa-arrow-alt-up text-primary"></i>
                        <span class="text-primary">{{$task_to_countries}}</span>
                    </div>
                    <div class="fs085">
                        <span class="line-title">DATE:</span> [{{$task_date_type}}]
                        <span class="text-primary">{{ $task_dates_view }}</span>
                    </div>
                    <div class="fs085">
                        <span class="line-title">Сost of 1 km / €:</span>
                        <span class="text-primary">{{ $task_price_full }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="w-5/12">
            <div class="col-lg-12 mt-3 text-center" x-data="SWITCH_TASK_STATUS({{ $task_id }})">
                <x-button type="button" x-ref="start" x-on:click="start"
                    color="--success"
                    :disabled="$task_action_disabled['START']">
                    <i class="fas fa-play-circle"></i> START
                </x-button>
                <x-button type="button" x-ref="test" x-on:click="test"
                    :disabled="$task_action_disabled['TEST']">
                    <i class="fab fa-stumbleupon-circle"></i> TEST
                </x-button>
                <x-button type="button" x-ref="stop" x-on:click="stop"
                    color="--red"
                    :disabled="$task_action_disabled['STOP']" >
                    <i class="fas fa-stop-circle"></i> STOP
                </x-button>
                <hr class="my-1">
                <a href="{{ route('orders', $task_id) }}" class="link">show processed tasks</a>
            </div>
            <div class="bg-green-500 bg-red-500"></div>
        </div>
    </div>
</div>
