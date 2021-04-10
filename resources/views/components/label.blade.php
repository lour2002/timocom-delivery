@props(['value'])

<label {{ $attributes->merge(['class' => 'text-xs text-gray-600']) }}>
    {{ $value ?? $slot }}
</label>
