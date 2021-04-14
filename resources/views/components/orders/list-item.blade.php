<tr>
    <td class="border px-2">
    <i class="fas {{ $status_class }}"></i>
    <span class="text-green-500 text-yellow-500 text-red-500"></span>
    </td>
    <td class="border px-2">
    <b class="text-sm">{{ $time }}</b>
    <br>
    <span class="text-xs">{{ $date }}</span>
    <br>
    <span class="text-xs">ID:{{ $id }}</span>
    </td>
    <td class="border px-2">
        <a class="link" href="mailto:{{ $email }}">{{ $email }}</a><br>
        <span>{{ $name }}</span><br>
        <span>{{ $phone }}<span>
    </td>
    <td class="border px-2">

        @foreach ($from as $point)
        <div class="mb-1">
            <i class="text-green-600 far fa-arrow-alt-circle-down mr-1"></i><b>{{ explode(' - ', $point['from_country'] ?? '')[0] }}, {{$point['from_city'] ?? ''}} {{ $point['from_zip'] ?? '' }}</b> -><br>
            {{ $point['from_date1'] ?? '' }} - {{ $point['from_date2'] ?? '' }}<br>
        </div>
        @endforeach

        @foreach ($to as $point)
            <div class="mb-1">
                <i class="text-yellow-600 far fa-arrow-alt-circle-up mr-1"></i><b>{{ explode(' - ', $point['to_country'] ?? '')[0] }}, {{$point['to_city'] ?? ''}} {{ $point['to_zip'] ?? '' }}</b> -><br>
                {{ $point['to_date1'] ?? '' }} - {{ $point['to_date2'] ?? '' }}<br>
            </div>
        @endforeach
    </td>
    <td class="border px-2">
        <span class="text-sm"><b>Price:</b> {{ $price }}</span> <br>
        <span class="text-sm"><b>Distance:</b> {{ $distance }}</span> <br>
        <span class="text-sm"><b>Reason:</b> {{ $reason }}</span>
        <a class="block my-3 text-gray-500 underline text-sm" target="_blank" href="{{$offer_id}}">timocom link</a>
    </td>
</tr>
