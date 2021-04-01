@props(['value'])
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn']) }}>
    {{ $value ?? $slot }}
</button>
