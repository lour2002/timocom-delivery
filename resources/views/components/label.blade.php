@props(['value'])

<label {{ $attributes->merge(['class' => 'text-sm text-gray-600']) }}>
    {{ $value ?? $slot }}
</label>
