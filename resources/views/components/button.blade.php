@props(['value', 'color'])

@php
$color = $color ?? '--primary';
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn '.$color]) }}>
    {{ $value ?? $slot }}
</button>
