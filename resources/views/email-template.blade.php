{!! $message_text !!}

<b>TIMOCOM ID:</b> {{ $company->timocom_id }} <br>
<b>Company:</b> {{ $company->name }} <br>
<b>Contact person:</b> {{ $company->contact_person }} <br>
<br>
<b>Provider:</b> {{ $order->company_id }}, {{ $order->company }}, {{ $order->name }} <br>
<br>
<b>Load to be offered:</b><br>
@foreach ($from as $point)
<b>On:</b> {{$point['from_date1']}} - {{$point['from_date2']}} ({{$point['from_time1']}} - {{$point['from_time1']}})<br>
<b>Town:</b> {{$point['from_country']}}, {{$point['from_zip']}} {{$point['from_city']}}<br>
@endforeach
<br>
@foreach ($to as $point)
<b>Deliver:</b> {{$point['to_date1']}} - {{$point['to_date2']}} ({{$point['to_time1']}} - {{$point['to_time1']}})<br>
<b>Town:</b> {{$point['to_country']}}, {{$point['to_zip']}} {{$point['to_city']}}<br>
@endforeach
<br>
<b>Distance in km:</b> {{ $order->distance }}<br>
<br>
<b>Loading equipment exchange:</b> {{ $order->equipment_exchange ? "Yes" : "No" }}<br>
<b>Length:</b> {{ $order->freight_length }} m<br>
<b>Weight/to:</b> {{ $order->freight_weight }} to<br>
<b>Loading places:</b> {{ $order->loading_places }}<br>
<b>Unloading places:</b> {{ $order->unloading_places }}<br>
<br>
<b>Freight price:</b> {{ $order->price }} EUR / €<br>
<b>Payment due:</b> {{ $order->payment_due }}<br>
<b>Freight description:</b> {{ $order->freight_description }}<br>
<br>
<b>Required type of vehicle:</b> {{ $order->vehicle_type }}<br>
<br>
<b>Remarks:</b> {{ $order->remarks }}<br>

