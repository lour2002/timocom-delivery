<form action="/task/store" method="POST" x-data="{ tab: 1 }">
    @csrf
    @if ($task_id)
    <x-input type="hidden" name="id" :value="$task_id" />
    @endif

    <div class="flex flex-wrap justify-around mb-5">
        <x-button type="button" @click="tab = 1" class="tab__title">
            <i class="fas fa-search"></i> Search settings
        </x-button>
        <x-button type="button" @click="tab = 2" class="tab__title">
            <i class="fas fa-cogs"></i> Filters and exceptions
        </x-button>
        <x-button type="button" @click="tab = 3" class="tab__title">
            <i class="fas fa-paper-plane"></i> Email Template
        </x-button>
    </div>
    <section x-show="tab === 1" class="tab-content">
        <x-label>
            Name task
            <x-input id="task_name" class="w-full block " type="text" :value="$task_name" name="name" placeholder="Name task" required autofocus />
        </x-label>
        <x-container class="--form flex flex-wrap ">
            <h2 class="block__title w-full">FROM:</h2>

            <x-label class="w-1/4 flex-shrink">
                <x-radio class="align-middle" name="fromSelectOpt" :value="$task_from_type" checked />
                <span class="align-middle">{{ $FROM_TYPES[$task_from_type] }}</span>
            </x-label>
            <x-label class="flex-grow mr-2">
                <b>Country</b>
                <x-search-task.country-select name="as_country" id="task_from_country" :value="$task_from_country" />
            </x-label>
            <x-label class="flex-grow mr-2">
                <b>ZIP code</b>
                <x-input class="block " type="number" :value="$task_from_zip" name="as_zip" placeholder="ZIP code" />
            </x-label>
            <x-label class="flex-grow">
                <b>{{ __('Radius') }}</b>
                <x-input class="block " type="number" :value="$task_from_radius" name="as_radius" min="0" step="1" :placeholder="__('Radius')" />
            </x-label>
        </x-container>
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">TO:</h2>
            <x-label class="w-1/4  flex-shrink">
                <x-radio class="align-middle" name="toSelectOpt" :value="$task_to_type" checked />
                <span class="align-middle">{{ $TO_TYPES[$task_to_type] }}</span>
            </x-label>

            <div class="flex-grow mr-2">
                <x-label>
                    <b>Country</b>
                    <i class="fas fa-arrow-down"></i>
                </x-label>
                @for ($i = 0; $i < 5; $i++)
                    <x-search-task.country-select class="mt-1 w-full" name="as_country_to:{{$i}}" :value="$task_to_array[$i]['as_country_to'] ?? '-- is empty --'" />
                @endfor
            </div>
            <div class="flex-shrink mr-2">
                <x-label>
                    <b>{{ __('post 1') }}</b>
                    <i class="fas fa-arrow-down"></i>
                </x-label>
                @for ($i = 0; $i < 5; $i++)
                    <x-input class="block mt-1 w-28" type="number" :value="$task_to_array[$i]['post1'] ?? ''" name="post1:{{$i}}" :placeholder="__('post 1')" />
                @endfor
            </div>
            <div class="flex-shrink mr-2">
                <x-label>
                    <b>{{ __('post 2') }}</b>
                    <i class="fas fa-arrow-down"></i>
                </x-label>
                @for ($i = 0; $i < 5; $i++)
                    <x-input class="block mt-1 w-28" type="number" :value="$task_to_array[$i]['post2'] ?? ''" name="post2:{{$i}}" :placeholder="__('post 2')" />
                @endfor
            </div>
            <div class="flex-shrink">
                <x-label>
                    <b>{{ __('post 3') }}</b>
                    <i class="fas fa-arrow-down"></i>
                </x-label>
                @for ($i = 0; $i < 5; $i++)
                    <x-input class="block mt-1 w-28" type="number" :value="$task_to_array[$i]['post3'] ?? ''" name="post3:{{$i}}" :placeholder="__('post 3')" />
                @endfor
            </div>
        </x-container>
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">SELECTION OF FREIGHT:</h2>
            <x-label class="w-1/4 flex-shrink">
                <x-radio name="freightSelectOpt" :value="$task_freight_type" checked />
                {{ $FREIGHT_TYPES[$task_freight_type] }}
            </x-label>
            <div class="flex-grow">
                <h3 class="inline-block mb-3">Length:</h3>
                <x-label class="inline-block mb-3">
                    {{__('Min.')}}
                    <x-input id="task_length_min" class="block " type="text" :value="$task_length_min" name="length_min" />
                </x-label>
                <x-label class="inline-block mb-3">
                    {{__('Max.')}}
                    <x-input id="task_length_max" class="block " type="text" :value="$task_length_max" name="length_max" />
                </x-label>
                <br />
                <h3 class="inline-block">Weight:</h3>
                <x-label class="inline-block">
                    {{__('Min.')}}
                    <x-input id="task_weight_min" class="block " type="text" :value="$task_weight_min" name="weight_min" />
                </x-label>
                <x-label class="inline-block">
                    {{__('Max.')}}
                    <x-input id="task_weight_max" class="block " type="text" :value="$task_weight_max" name="weight_max" />
                </x-label>
            </div>
        </x-container>
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">DATE:</h2>
            <div class="w-1/4  flex-shrink">
                @foreach ($DATE_TYPES as $key => $text)
                    <x-label class="block">
                        <x-radio name="dateSelectOpt" :value="$key" :checked="$task_date_type == $key" />
                        {{ $text }}
                    </x-label>
                @endforeach
            </div>
            <br>
            <x-label class="flex-grow mr-2">
                {{__('Individual days:')}}
                <x-input id="task_individual_days" class="block " type="text" :value="$task_individual_days" name="individual_days" />
            </x-label>
            <x-label class="flex-grow">
                {{__('Period:')}}
                <x-input id="task_period_start" class="block mb-2" type="text" :value="$task_period_start" name="period_start" />
                <x-input id="task_period_stop" class="block " type="text" :value="$task_period_stop" name="period_stop" />
            </x-label>
        </x-container>
    </section>

    <section x-show="tab === 2"  class="tab-content">
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">CURRENT POSITION OF THE TRUCK:</h2>
            <x-label class="block">
                Country of location
                <x-search-task.country-select name="car_country" id="task_from_country" :value="$task_car_country" />
            </x-label>
            <x-label class="block">
                ZIP code
                <x-input class="block " type="number" :value="$task_car_zip" name="car_zip" placeholder="ZIP code" />
            </x-label>
            <x-label class="block">
                City
                <x-input class="block " type="text" :value="$task_car_city" name="car_city" placeholder="City" />
            </x-label>
            <x-label class="block">
                Cost per kilometer of an empty car (of 1 km / €)
                <x-input class="block " step="0.01" min="0" max="10" type="number" :value="$task_price_empty" name="car_price_empty" placeholder="0.00" />
            </x-label>
            <x-label class="block">
                Cost per kilometer of loaded car (of 1 km / €)
                <x-input class="block " step="0.01" min="0" max="10" type="number" :value="$task_price_full" name="car_price" placeholder="0.00" />
            </x-label>
            <x-label class="block">
                Extra stop extra charge (%)
                <x-input class="block " step="1" min="0" max="999" type="number" :value="$task_extra_points" name="car_price_extra_points" placeholder="0 %" />
            </x-label>
        </x-container>
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">LOADING EQUIPMENT EXCHANGE:</h2>
            <x-label class="block">
                <x-input type="checkbox" class="checkbox" name="exchange_equipment" :checked="!!$task_exchange_equipment" value="1" />
                Skip order, if yes, when exchanging pallets
            </x-label>
        </x-container>
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">MINIMUM ORDER VALUE (EURO):</h2>
            <span>Cost below which the order will not be processed. The offer will not be sent to the customer.</span>
            <x-label class="block">
                The minimum value in euros:
                <x-input class="block" step="1" min="0" type="number" :value="$task_min_price" name="minimal_price_order" placeholder="0" />
            </x-label>
        </x-container>
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">PROTECTION FROM "ARE YOU A FOOL?":</h2>
            <x-label class="block">
                Do not send an offer if the price offered is YOUR_PERCENT% higher than the price set by the customer. Specify the percentage and activate the function.
                <x-input class="block" step="1" min="0" type="number" :value="$task_stop_percent" name="percent_stop_value" placeholder="0" />
            </x-label>
        </x-container>
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">CROSSING THE BORDER:</h2>
            <x-label class="block">
                Countries
                <i class="fas fa-arrow-down"></i>
            </x-label>
            <x-label class="block">
                Weight
                <i class="fas fa-arrow-down"></i>
            </x-label>
            @for ($i = 0; $i < 5; $i++)
                <x-search-task.country-select name="border_country:{{$i}}" :value="$task_cross_border[$i]['border_country'] ?? '-- is empty --'" />
                <x-input class="block mt-1" type="number" :value="$task_cross_border[$i]['border_val'] ?? ''" name="border_val:{{$i}}" />
            @endfor
        </x-container>
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">EXCEPTIONS:</h2>
            <x-label class="block">
                The words for the filter, under which the order is skipped. The letter will not be sent. You can import multiple values separated by commas. Values will be added to the current list.
                <x-input class="block " type="text" :value="$task_tags" name="tags" />
            </x-label>
        </x-container>
    </section>


    <section x-show="tab === 3"  class="tab-content">
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">EMAIL TEMPLATE:</h2>
            <textarea class="block input w-full" type="text" rows="20" name="email_template" >{{ $task_email_template }}</textarea>
        </x-container>
    </section>

    <x-button type="submit" value="Save" />
</form>

