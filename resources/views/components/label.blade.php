@props(['value'])

<label {{ $attributes->merge(['class' => 'text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
