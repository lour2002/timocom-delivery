<tr>
    <td class="border px-2">
    <i class="fas fa-2x {{ $status_class }}"></i>
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
    <td class="border">
        @foreach ($from as $point)
            {{ $point['from_country'] }} {{ $point['from_zip'] }} -><br>
            {{ $point['from_date1']['date'] }}<br>
        @endforeach
        @foreach ($to as $point)
            {{ $point['to_country'] }} {{ $point['to_zip'] }} -><br>
            {{ $point['to_date1']['date'] }}<br>
        @endforeach
    </td>
    <td class="border">
        Price: {{ $price }} <br>
        Distance: {{ $distance }} <br>
        Reason: {{ $reason }}
    </td>
</tr>
