@props([
    'for' => '',
    'required' => false,
    'icon' => null,
    'size' => 'sm' // xs, sm, base
])

@php
$sizeClasses = match($size) {
    'xs' => 'text-xs',
    'base' => 'text-base',
    default => 'text-sm'
};
@endphp

<label for="{{ $for }}" class="block {{ $sizeClasses }} font-medium text-gray-700 dark:text-gray-300 mb-2">
    @if($icon)
        <span class="icon-[{{ $icon }}] w-4 h-4 inline mr-1" aria-hidden="true"></span>
    @endif
    {{ $slot }}
    @if($required)
        <span class="text-red-500" aria-label="Campo requerido">*</span>
    @endif
</label>
