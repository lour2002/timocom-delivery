<tr>
    <td class="border">{{ $status }}</td>
    <td class="border">{{ $time }}</td>
    <td class="border">
        {{ $name }}<br>
        {{ $email }}<br>
        {{ $phone }}
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
        Price: {{ $price }}
    </td>
</tr>
