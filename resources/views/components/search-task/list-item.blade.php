<div class="grid grid-cols-2 content-container --form">
    <div class="w-7/12">
        <div class="row edit_current_task" data-id_task="{{ $task_id }}" style="cursor: pointer;">
            <div class="col-lg-12">
                <span class="badge badge-danger">#{{ $task_id }} | {{ $task_status }}</span> <span class="fs085"><b>{{$task_name}}</b></span>
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
                    <span class="text-primary">{{ $task_dates }}</span>
                </div>
                <div class="fs085">
                    <span class="line-title">Сost of 1 km / €:</span>
                    <span class="text-primary">{{ $task_driver_cost }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="w-5/12">
        <div class="col-lg-12 mt-3 text-center">
            <button type="button" class="btn btn-success btn-sm ch_st_t" data-id_task="1143" data-status="3"><i class="fas fa-play-circle"></i> START</button>
            <button type="button" class="btn btn-primary btn-sm ch_st_t" data-id_task="1143" data-status="2"><i class="fab fa-stumbleupon-circle"></i> TEST</button>
            <button type="button" class="btn btn-danger btn-sm" style="opacity: 0.2;" disabled=""><i class="fas fa-stop-circle"></i> STOP</button>
            <hr class="my-1">
            <a href="/index.php?page=orders&amp;id_task=1143" class="text-info">show processed tasks</a><div class="last_active">Last Activity <span id="task1143">17.03.2021 14:57:27</span></div>
        </div>
    </div>

</div>
