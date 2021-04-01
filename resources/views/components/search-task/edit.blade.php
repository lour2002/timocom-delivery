<form url="/task" method="POST">
    @csrf
    <x-input type="hidden" name="id" :value="$task['id'] ?? ''" />
    <x-label>
        {{ __('Name task') }}
        <x-input id="task_name" class="w-full block " type="text" :value="$task_name" name="name" :placeholder="__('Name task')" required autofocus />
    </x-label>
    <x-container class="--form">
        <h2>FROM:</h2>
        <x-label>
            {{ __('Country') }}
            <x-search-task._country-select name="as_country" id="task_from_country" :value="$task_from_country" />
        </x-label>
        <x-label>
            {{ __('ZIP code') }}
            <x-input id="task_from_zip" class="block " type="number" :value="$task_from_zip" name="as_zip" :placeholder="__('ZIP code')" />
        </x-label>
        <x-label>
            {{ __('Radius') }}
            <x-input id="task_from_radius" class="block " type="number" :value="$task_from_radius" name="as_radius" :placeholder="__('Radius')" />
        </x-label>
    </x-container>
    <x-container class="--form">
        <h2>TO:</h2>
        <div>
            <x-label>
                {{ __('post 1') }}
                <i class="fas fa-arrow-down"></i>
            </x-label>
            @for ($i = 0; $i < 6; $i++)
                <x-input id="task_to_post1:{{$i}}" class="block mt-1" type="number" :value="$task_to_post1[$i] ?? ''" name="post1:{{$i}}" :placeholder="__('post 1')" />
            @endfor
        </div>
        <div>
            <x-label>
                {{ __('post 2') }}
                <i class="fas fa-arrow-down"></i>
            </x-label>
            @for ($i = 0; $i < 6; $i++)
                <x-input id="task_to_post2:{{$i}}" class="block mt-1" type="number" :value="$task_to_post2[$i] ?? ''" name="post2:{{$i}}" :placeholder="__('post 2')" />
            @endfor
        </div>
        <div>
            <x-label>
                {{ __('post 3') }}
                <i class="fas fa-arrow-down"></i>
            </x-label>
            @for ($i = 0; $i < 6; $i++)
                <x-input id="task_to_post3:{{$i}}" class="block mt-1" type="number" :value="$task_to_post3[$i] ?? ''" name="post3:{{$i}}" :placeholder="__('post 3')" />
            @endfor
        </div>
    </x-container>
    <x-container class="--form">
        <h2>SELECTION OF FREIGHT:</h2>
        <x-label>
            {{__('Min.')}}
            <x-input id="task_length_min" class="block " type="text" :value="$task_length_min" name="length_min" />
        </x-label>
        <x-label>
            {{__('Max.')}}
            <x-input id="task_length_max" class="block " type="text" :value="$task_length_max" name="length_max" />
        </x-label>
        <x-label>
            {{__('Min.')}}
            <x-input id="task_weight_min" class="block " type="text" :value="$task_weight_min" name="weight_min" />
        </x-label>
        <x-label>
            {{__('Max.')}}
            <x-input id="task_weight_max" class="block " type="text" :value="$task_weight_max" name="weight_max" />
        </x-label>
    </x-container>
    <x-container class="--form">
        <h2>DATE:</h2>
        <x-label>
            {{__('Individual days:')}}
            <x-input id="task_individual_days" class="block " type="text" :value="$task_individual_days" name="task_individual_days" />
        </x-label>
        <x-label :value="__('Period:')" />
        <x-input id="task_period_start" class="block " type="text" :value="$task_period_start" name="period_start" />
        <x-input id="task_period_stop" class="block " type="text" :value="$task_period_stop" name="period_stop" />
    </x-container>
    <x-button type="submit" value="Save" />
</form>

