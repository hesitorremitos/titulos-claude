@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'icon' => null
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';

$variants = [
    'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white focus:ring-indigo-500',
    'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white focus:ring-gray-500',
    'outline' => 'border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 focus:ring-indigo-500',
    'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
];

$sizes = [
    'sm' => 'px-3 py-1.5 text-sm',
    'md' => 'px-4 py-2 text-sm',
    'lg' => 'px-6 py-3 text-base',
];

$classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span class="{{ $icon }} w-4 h-4 mr-2"></span>
        @endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>
        @if($icon)
            <span class="{{ $icon }} w-4 h-4 mr-2"></span>
        @endif
        {{ $slot }}
    </button>
@endif