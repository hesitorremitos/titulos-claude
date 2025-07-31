@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, success, danger, warning
    'size' => 'md', // sm, md, lg
    'icon' => null,
    'loading' => false,
    'loadingText' => null,
    'disabled' => false,
    'fullWidth' => false
])

@php
    $baseClasses = 'font-semibold rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:cursor-not-allowed transform active:scale-[0.98]';
    
    $sizeClasses = match($size) {
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-3 text-base',
        'lg' => 'px-6 py-4 text-lg',
        default => 'px-4 py-3 text-base'
    };

    $variantClasses = match($variant) {
        'primary' => 'bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 disabled:from-gray-400 disabled:to-gray-500 text-white focus:ring-red-500',
        'secondary' => 'bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 disabled:from-gray-400 disabled:to-gray-500 text-white focus:ring-blue-500',
        'success' => 'bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 disabled:from-gray-400 disabled:to-gray-500 text-white focus:ring-green-500',
        'danger' => 'bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 disabled:from-gray-400 disabled:to-gray-500 text-white focus:ring-red-500',
        'warning' => 'bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 disabled:from-gray-400 disabled:to-gray-500 text-white focus:ring-yellow-500',
        default => 'bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 disabled:from-gray-400 disabled:to-gray-500 text-white focus:ring-red-500'
    };

    $fullWidthClass = $fullWidth ? 'w-full' : '';
    $hoverScale = $disabled || $loading ? '' : 'hover:scale-[1.02]';
    $disabledOpacity = $disabled || $loading ? 'opacity-75' : '';
@endphp

<button 
    type="{{ $type }}"
    {{ $disabled || $loading ? 'disabled' : '' }}
    {{ $attributes->merge([
        'class' => trim("$baseClasses $sizeClasses $variantClasses $fullWidthClass $hoverScale $disabledOpacity")
    ]) }}
>
    @if($loading)
        <span class="flex items-center justify-center">
            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white mr-2"></div>
            {{ $loadingText ?? 'Procesando...' }}
        </span>
    @else
        <span class="flex items-center justify-center">
            @if($icon)
                <span class="icon-[{{ $icon }}] mr-2 h-5 w-5"></span>
            @endif
            {{ $slot }}
        </span>
    @endif
</button>