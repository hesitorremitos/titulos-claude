@props(['href' => null, 'variant' => 'primary', 'size' => 'md', 'icon' => null])

@php
$variants = [
    'primary' => 'bg-primary-600 hover:bg-primary-700 focus:bg-primary-700 text-white border-transparent',
    'secondary' => 'bg-gray-600 hover:bg-gray-700 focus:bg-gray-700 text-white border-transparent',
    'success' => 'bg-green-600 hover:bg-green-700 focus:bg-green-700 text-white border-transparent',
    'danger' => 'bg-red-600 hover:bg-red-700 focus:bg-red-700 text-white border-transparent',
    'warning' => 'bg-yellow-600 hover:bg-yellow-700 focus:bg-yellow-700 text-white border-transparent',
    'outline' => 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600',
];

$sizes = [
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-4 py-2 text-sm',
    'lg' => 'px-6 py-3 text-base',
];

$classes = "inline-flex items-center justify-center border rounded-md font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 " . 
           ($variants[$variant] ?? $variants['primary']) . " " . 
           ($sizes[$size] ?? $sizes['md']);
@endphp

@if(isset($href) && $href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span class="{{ $icon }} w-4 h-4 mr-2" aria-hidden="true"></span>
        @endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>
        @if($icon)
            <span class="{{ $icon }} w-4 h-4 mr-2" aria-hidden="true"></span>
        @endif
        {{ $slot }}
    </button>
@endif
