@props([
    'title' => 'UATF Títulos',
    'subtitle' => 'Universidad',
    'icon' => 'mdi--school'
])

<div class="p-4 border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-center space-x-3">
        <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
            <span class="icon-[{{ $icon }}] w-5 h-5 text-white"></span>
        </div>
        <div>
            <h3 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $title }}</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
        </div>
    </div>
</div>
