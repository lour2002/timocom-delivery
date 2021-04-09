@props(['value', 'color'])

@php
$color = $color ?? 'bg-indigo-400';
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn '.$color]) }}>
    {{ $value ?? $slot }}
</button>
