@props(['title' => null, 'description' => null])

<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
    @if($title || $description || isset($header))
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        @if(isset($header))
            {{ $header }}
        @else
            @if($title)
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    {{ $title }}
                </h3>
            @endif
            @if($description)
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ $description }}
                </p>
            @endif
        @endif
    </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>
</div>
