@props([
    'href' => '#',
    'icon' => 'mdi--circle',
    'iconColor' => 'text-primary-500',
    'title' => '',
    'description' => ''
])

<a href="{{ $href }}" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200 dark:border-gray-700 group">
    <div class="flex items-center">
        <span class="icon-[{{ $icon }}] {{ $iconColor }} group-hover:brightness-110 w-8 h-8 mr-3" aria-hidden="true"></span>
        <div>
            <h3 class="text-sm font-medium text-gray-900 dark:text-white group-hover:{{ str_replace('text-', 'text-', $iconColor) }} dark:group-hover:{{ str_replace('text-', 'text-', $iconColor) }}/80">
                {{ $title }}
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $description }}</p>
        </div>
    </div>
</a>
