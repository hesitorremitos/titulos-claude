@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'iconColor' => 'text-gray-600',
    'padding' => 'p-6',
    'shadow' => 'shadow-sm',
    'hover' => false
])

@php
    $cardClasses = "bg-white overflow-hidden rounded-lg $shadow";
    if ($hover) {
        $cardClasses .= " hover:shadow-md transition-shadow duration-200";
    }
@endphp

<div {{ $attributes->merge(['class' => $cardClasses]) }}>
    @if($title || $subtitle || $icon)
        <div class="{{ $padding }} {{ $title || $subtitle ? 'border-b border-gray-200' : '' }}">
            <div class="flex items-center">
                @if($icon)
                    <div class="flex-shrink-0">
                        <span class="icon-[{{ $icon }}] h-8 w-8 {{ $iconColor }}"></span>
                    </div>
                @endif
                <div class="{{ $icon ? 'ml-4' : '' }}">
                    @if($title)
                        <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
                    @endif
                    @if($subtitle)
                        <p class="text-sm text-gray-500 {{ $title ? 'mt-1' : '' }}">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
        </div>
    @endif
    
    <div class="{{ $title || $subtitle || $icon ? $padding : $padding }}">
        {{ $slot }}
    </div>
</div>