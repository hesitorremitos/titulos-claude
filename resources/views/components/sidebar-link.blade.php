@props([
    'href' => '#',
    'icon' => 'mdi--circle',
    'active' => false,
    'mobile' => false
])

@php
$baseClasses = $mobile 
    ? 'group flex items-center px-2 py-2 text-base font-medium rounded-md transition-colors duration-200'
    : 'group flex items-center px-2 py-2 text-sm font-medium rounded-l-md transition-colors duration-200';

$activeClasses = $active 
    ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300' . ($mobile ? '' : ' border-r-2 border-primary-500')
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700';

$iconClasses = $active 
    ? 'text-primary-500'
    : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300';

$iconSize = $mobile ? 'w-6 h-6 mr-4' : 'w-5 h-5 mr-3';
@endphp

<a href="{{ $href }}" class="{{ $baseClasses }} {{ $activeClasses }}">
    <span class="{{ $iconClasses }} icon-[{{ $icon }}] {{ $iconSize }}" aria-hidden="true"></span>
    {{ $slot }}
</a>
