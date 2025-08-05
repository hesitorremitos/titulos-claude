@props([
    'href' => '#',
    'icon' => 'mdi--circle',
    'active' => false,
    'routePattern' => null,
    'exactRoute' => null
])

@php
// Determinar si el enlace está activo
$isActive = $active;
if (!$isActive && $routePattern) {
    $isActive = request()->routeIs($routePattern);
}
if (!$isActive && $exactRoute) {
    $isActive = request()->routeIs($exactRoute);
}

$baseClasses = 'flex items-center space-x-3 px-3 py-2 rounded-md text-sm transition-colors duration-200';

$activeClasses = $isActive 
    ? 'bg-primary-100 text-primary-700 dark:bg-primary-900/50 dark:text-primary-300 font-medium'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800';

$iconClasses = 'w-5 h-5';
@endphp

<a href="{{ $href }}" class="{{ $baseClasses }} {{ $activeClasses }}">
    <span class="icon-[{{ $icon }}] {{ $iconClasses }}" aria-hidden="true"></span>
    <span class="{{ $isActive ? 'font-medium' : '' }}">{{ $slot }}</span>
</a>
