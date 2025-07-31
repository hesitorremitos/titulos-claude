@props([
    'icon' => 'mdi--circle',
    'iconColor' => 'text-blue-500',
    'title' => '',
    'value' => '0',
    'href' => '#'
])

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
    <div class="p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <span class="icon-[{{ $icon }}] {{ $iconColor }} w-8 h-8" aria-hidden="true"></span>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $title }}</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $value }}</p>
            </div>
        </div>
    </div>
</div>
