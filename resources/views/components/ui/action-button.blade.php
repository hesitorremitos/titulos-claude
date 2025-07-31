@props([
    'title',
    'description',
    'icon',
    'color' => 'red', // red, blue, green, yellow, gray
    'href' => null,
    'onclick' => null
])

@php
    $colorClasses = match($color) {
        'red' => 'hover:border-red-500 hover:bg-red-50 group-hover:text-red-600',
        'blue' => 'hover:border-blue-500 hover:bg-blue-50 group-hover:text-blue-600',
        'green' => 'hover:border-green-500 hover:bg-green-50 group-hover:text-green-600',
        'yellow' => 'hover:border-yellow-500 hover:bg-yellow-50 group-hover:text-yellow-600',
        'gray' => 'hover:border-gray-500 hover:bg-gray-50 group-hover:text-gray-600',
        default => 'hover:border-red-500 hover:bg-red-50 group-hover:text-red-600'
    };

    $iconColorClass = match($color) {
        'red' => 'group-hover:text-red-600',
        'blue' => 'group-hover:text-blue-600', 
        'green' => 'group-hover:text-green-600',
        'yellow' => 'group-hover:text-yellow-600',
        'gray' => 'group-hover:text-gray-600',
        default => 'group-hover:text-red-600'
    };

    $titleColorClass = match($color) {
        'red' => 'group-hover:text-red-600',
        'blue' => 'group-hover:text-blue-600',
        'green' => 'group-hover:text-green-600', 
        'yellow' => 'group-hover:text-yellow-600',
        'gray' => 'group-hover:text-gray-600',
        default => 'group-hover:text-red-600'
    };

    $element = $href ? 'a' : 'button';
    $attributes = $href ? $attributes->merge(['href' => $href]) : $attributes;
    if ($onclick) {
        $attributes = $attributes->merge(['onclick' => $onclick]);
    }
@endphp

<{{ $element }} {{ $attributes->merge([
    'class' => "flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg $colorClasses transition-colors duration-200 group"
]) }}>
    <span class="icon-[{{ $icon }}] h-8 w-8 text-gray-400 {{ $iconColorClass }} mr-3"></span>
    <div class="text-left">
        <p class="font-medium text-gray-900 {{ $titleColorClass }}">{{ $title }}</p>
        <p class="text-sm text-gray-500">{{ $description }}</p>
    </div>
</{{ $element }}>