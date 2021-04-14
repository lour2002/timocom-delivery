<form action="/task/store" method="POST" x-data="{ tab: 1, tags: [] }" x-init="tags = $refs.tagInput.value.split(';')">
    @csrf
    @if ($task_id)
    <x-input type="hidden" name="id" :value="$task_id" />
    @endif

    <div class="flex flex-wrap justify-around mb-5">
        <button type="button" @click="tab = 1" class="btn h-12 tab__title" :class="tab == 1 ? '--primary' : '--simple'">
            <i class="fas fa-search mr-2"></i> Search settings
        </button>
        <button type="button" @click="tab = 2" class="btn h-12 tab__title" :class="tab == 2 ? '--primary' : '--simple'">
            <i class="fas fa-cogs mr-2"></i> Filters and exceptions
        </button>
        <button type="button" @click="tab = 3" class="btn h-12 tab__title" :class="tab == 3 ? '--primary' : '--simple'">
            <i class="fas fa-paper-plane mr-2"></i> Email Template
        </button>
    </div>
    <section x-show="tab === 1" class="tab-content">
        <x-label>
            <b>Name task</b>
            <x-input id="task_name" class="w-full block " type="text" :value="$task_name" name="name" placeholder="Name task" required autofocus />
        </x-label>
        <x-container class="--form flex flex-wrap ">
            <h2 class="block__title w-full">FROM:</h2>

            <x-label class="w-1/4 flex-shrink">
                <x-radio class="align-middle" name="fromSelectOpt" :value="$task_from_type" checked />
                <span class="align-middle text-base">{{ $FROM_TYPES[$task_from_type] }}</span>
            </x-label>
            <div class="w-3/4 flex-shrink flex flex-wrap">
                <x-label class="flex-grow mr-3 mb-2">
                    <b>Country</b>
                    <x-search-task.country-select required class="w-full" name="as_country" id="task_from_country" :value="$task_from_country" />
                </x-label>
                <x-label class="flex-grow mr-3 mb-2">
                    <b>ZIP code</b>
                    <x-input class="block w-full" required type="number" :value="$task_from_zip" name="as_zip" placeholder="ZIP code" />
                </x-label>
                <x-label class="flex-grow mb-2">
                    <b>{{ __('Radius') }}</b>
                    <x-input class="block w-full" type="number" :value="$task_from_radius" name="as_radius" min="0" step="1" :placeholder="__('Radius')" />
                </x-label>
                {{-- TODO: maybe delete --}}
                <x-label class="flex-grow w-full">
                    <b>City</b>
                    <x-input class="w-full" required type="text" :value="$task_car_city" name="car_city" placeholder="City" />
                </x-label>
            </div>

        </x-container>
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">TO:</h2>
            <x-label class="w-1/4  flex-shrink">
                <x-radio class="align-middle" name="toSelectOpt" :value="$task_to_type" checked />
                <span class="align-middle text-base">{{ $TO_TYPES[$task_to_type] }}</span>
            </x-label>

            <div class="flex-shrink mr-3">
                <x-label>
                    <b>Country</b>
                    <i class="fas fa-arrow-down"></i>
                </x-label>
                @for ($i = 0; $i < 5; $i++)
                    <x-search-task.country-select class="mt-1 w-full" name="as_country_to:{{$i}}" :value="$task_to_array[$i]['as_country_to'] ?? '-- is empty --'" />
                @endfor
            </div>
            <div class="flex-shrink mr-3">
                <x-label>
                    <b>{{ __('post 1') }}</b>
                    <i class="fas fa-arrow-down"></i>
                </x-label>
                @for ($i = 0; $i < 5; $i++)
                    <x-input class="block mt-1 w-28" type="number" :value="$task_to_array[$i]['post1'] ?? ''" name="post1:{{$i}}" :placeholder="__('post 1')" />
                @endfor
            </div>
            <div class="flex-shrink mr-3">
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
                <x-radio class="align-middle" name="freightSelectOpt" :value="$task_freight_type" checked />
                <span class="text-base align-middle">{{ $FREIGHT_TYPES[$task_freight_type] }}</span>
            </x-label>
            <div class="flex-shrink mr-3">
                <h3 class="inline-block mb-3">Length:</h3>
                <x-label class="inline-block mb-3">
                    <b>{{__('Min.')}}</b>
                    <x-input id="task_length_min" class="block " type="text" :value="$task_length_min" name="length_min" />
                </x-label>
                <x-label class="inline-block mb-3">
                    <b>{{__('Max.')}}</b>
                    <x-input id="task_length_max" class="block " type="text" :value="$task_length_max" name="length_max" />
                </x-label>
                <br />
                <h3 class="inline-block">Weight:</h3>
                <x-label class="inline-block">
                    <b>{{__('Min.')}}</b>
                    <x-input id="task_weight_min" class="block " type="text" :value="$task_weight_min" name="weight_min" />
                </x-label>
                <x-label class="inline-block">
                    <b>{{__('Max.')}}</b>
                    <x-input id="task_weight_max" class="block " type="text" :value="$task_weight_max" name="weight_max" />
                </x-label>
            </div>
        </x-container>
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">DATE:</h2>
            <div class="w-1/4  flex-shrink">
                @foreach ($DATE_TYPES as $key => $text)
                    <x-label class="block mb-1">
                        <x-radio class="align-middle" name="dateSelectOpt" :value="$key" :checked="$task_date_type == $key" />
                        <span class="text-base align-middle">{{ $text }}</span>
                    </x-label>
                @endforeach
            </div>
            <br>
            <x-label class="flex-shrink mr-3">
                <b>{{__('Individual days:')}}</b>
                <x-input id="task_individual_days" class="block " type="text" :value="$task_individual_days" name="individual_days" />
            </x-label>
            <x-label class="flex-shrink">
                <b>{{__('Period:')}}</b>
                <div id="task_period">
                    <x-input class="block mb-2" type="text" :value="$task_period_start" name="period_start" />
                    <x-input class="block " type="text" :value="$task_period_stop" name="period_stop" />
                </div>
            </x-label>
        </x-container>
    </section>

    <section x-show="tab === 2"  class="tab-content">

        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">CURRENT POSITION OF THE TRUCK:</h2>
            <x-label class="flex-grow w-2/6 mr-3 mb-3">
                <b>Country of location</b>
                <x-search-task.country-select class="w-full" id="task_from_country"  :value="$task_car_country" disabled/>
            </x-label>
            <x-label class="flex-grow mr-3 mb-3">
                <b>ZIP code</b>
                <x-input class="w-full" type="number" :value="$task_car_zip" placeholder="ZIP code" disabled/>
            </x-label>
            <x-label class="flex-grow w-2/6 mb-3">
                <b>City</b>
                <x-input class="w-full" type="text" :value="$task_car_city" placeholder="City" disabled/>
            </x-label>
        </x-container>

        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">TRUCK PRICE:</h2>

            <x-label class="flex-grow w-2/6 mr-3">
                <b>Cost per kilometer of an empty car (of 1 km / €)</b>
                <x-input class="w-full " step="0.01" min="0" max="10" type="number" :value="$task_price_empty" name="car_price_empty" placeholder="0.00" disabled />
            </x-label>
            <x-label class="flex-grow w-2/6 mr-3">
                <b>Cost per kilometer of loaded car (of 1 km / €)</b>
                <x-input class="w-full " step="0.01" min="0" max="10" type="number" :value="$task_price_full" name="car_price" placeholder="0.00" />
            </x-label>
            <x-label class="flex-grow">
                <b>Extra stop extra charge (%)</b>
                <x-input class="w-full " step="1" min="0" max="999" type="number" :value="$task_extra_points" name="car_price_extra_points" placeholder="0 %" />
            </x-label>
        </x-container>
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">LOADING EQUIPMENT EXCHANGE:</h2>
            <x-label>
                <x-input type="checkbox" class="checkbox align-middle" name="exchange_equipment" :checked="!!$task_exchange_equipment" value="1" />
                <b class="align-middle">Skip order, if yes, when exchanging pallets</b>
            </x-label>
        </x-container>
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">MINIMUM ORDER VALUE (EURO):</h2>
            <div class="w-full mb-3">Cost below which the order will not be processed. The offer will not be sent to the customer.</div>
            <x-label class="block">
                <b>The minimum value in euros:</b>
                <x-input class="block" step="1" min="0" type="number" :value="$task_min_price" name="minimal_price_order" placeholder="0" />
            </x-label>
        </x-container>
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">PROTECTION FROM "ARE YOU A FOOL?":</h2>
            <div class="w-full mb-3">Do not send an offer if the price offered is YOUR_PERCENT% higher than the price set by the customer. Specify the percentage and activate the function.</div>
            <x-label class="block">
                <x-input class="block" step="1" min="0" type="number" :value="$task_stop_percent" name="percent_stop_value" placeholder="0" />
            </x-label>
        </x-container>
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">CROSSING THE BORDER:</h2>
            <div class="flex-shrink mr-3">
                <x-label class="font-bold">
                    Countries
                    <i class="fas fa-arrow-down"></i>
                </x-label>
                @for ($i = 0; $i < 5; $i++)
                    <x-search-task.country-select class="block mt-1" name="border_country:{{$i}}" :value="$task_cross_border[$i]['border_country'] ?? '-- is empty --'" />
                @endfor
            </div>
            <div class="flex-shrink">
                <x-label class="font-bold">
                    Weight
                    <i class="fas fa-arrow-down"></i>
                </x-label>
                @for ($i = 0; $i < 5; $i++)
                    <x-input class="block mt-1" type="number" :value="$task_cross_border[$i]['border_val'] ?? ''" name="border_val:{{$i}}" />
                @endfor
            </div>
        </x-container>
        <x-container class="--form">
            <h2 class="block__title">EXCEPTIONS:</h2>
            <div class="mb-3">The words for the filter, under which the order is skipped. The letter will not be sent. You can import multiple values separated by commas. Values will be added to the current list.</div>
            <input x-ref="tagInput" id="tags" type="hidden" size="1" value="{{$task_tags}}" name="tags" />
            <label class="tags">
                <template x-for="(item,index) in tags" :key="item">
                    <div class="tags__item" >
                        <span x-text="item"></span>
                        <i class="close" @click="{
                            $event.preventDefault();
                            tags.splice(index, 1);
                            $refs.tagInput.value = $refs.tagInput.value.replace(new RegExp(`(^${item};)|(;${item})`, 'u'), '');
                        }">✖</i>
                    </div>
                </template>
                <input class="focus:outline-none m-1" type="text" size="1"
                    @input="{$event.target.size = $event.target.value.length}"
                    @keydown.enter="{
                        $event.preventDefault();
                        tags.push($event.target.value);
                        $refs.tagInput.value = tags.join(';');
                        $event.target.value = '';
                    }"
                    @change="{tags.push($event.target.value); $refs.tagInput.value = tags.join(';')}">
            </label>
        </x-container>
    </section>


    <section x-show="tab === 3"  class="tab-content">
        <x-container class="--form flex flex-wrap">
            <h2 class="block__title w-full">EMAIL TEMPLATE:</h2>
            <div class="w-9/12">
                <textarea  class="hidden" id="email_template" type="text" name="email_template">
                    {{ $task_email_template }}
                </textarea>
                <div id="email_template_new" class="resizable" style="height: 400px; color:#000; font-size: 14px;">
                    {!! $task_email_template !!}
                </div>
            </div>
            <div class="w-3/12 pl-2">
                <div><a href="#" class="add_data" data-insert="{name}">{name}</a></div>
                <div><a href="#" class="add_data" data-insert="{full_name}">{full_name}</a></div>
                <div><a href="#" class="add_data" data-insert="{date_collection}">{date_collection}</a></div>
                <div><a href="#" class="add_data" data-insert="{price}">{price}</a></div>
                {{--<div><a href="#" class="add_data" data-insert="{HTML_signature}">{HTML signature}</a></div>--}}
            </div>

        </x-container>
    </section>

    <x-button type="submit" value="Save" />
</form>

