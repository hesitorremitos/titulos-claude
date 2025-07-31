@props([
    'title',
    'value',
    'icon',
    'iconColor' => 'text-blue-600',
    'trend' => null, // 'up', 'down', 'neutral'
    'trendValue' => null
])

@php
    $trendClasses = match($trend) {
        'up' => 'text-green-600',
        'down' => 'text-red-600',
        'neutral' => 'text-gray-600',
        default => 'text-gray-600'
    };

    $trendIcon = match($trend) {
        'up' => 'mdi--trending-up',
        'down' => 'mdi--trending-down',
        'neutral' => 'mdi--trending-neutral',
        default => null
    };
@endphp

<div {{ $attributes->merge(['class' => 'bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-200']) }}>
    <div class="p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <span class="icon-[{{ $icon }}] h-8 w-8 {{ $iconColor }}"></span>
            </div>
            <div class="ml-4 flex-1">
                <p class="text-2xl font-semibold text-gray-900">{{ $value }}</p>
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
                    @if($trend && $trendValue)
                        <div class="flex items-center {{ $trendClasses }}">
                            @if($trendIcon)
                                <span class="icon-[{{ $trendIcon }}] h-4 w-4 mr-1"></span>
                            @endif
                            <span class="text-sm font-medium">{{ $trendValue }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>