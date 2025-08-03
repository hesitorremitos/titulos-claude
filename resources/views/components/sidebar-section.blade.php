@props(['title'])

<div class="border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 shadow-sm mb-3" x-data="{ open: $persist(true).as('sidebar_{{ Str::slug($title) }}') }">
    <button 
        @click="open = !open"
        class="w-full flex items-center justify-between px-3 py-2.5 text-xs font-semibold text-blue-700 dark:text-blue-300 uppercase tracking-wider bg-blue-50 dark:bg-blue-950/20 border-l-4 border-blue-600 dark:border-blue-500 hover:bg-blue-100 dark:hover:bg-blue-900/30 hover:border-blue-700 dark:hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-600 dark:focus:ring-blue-500 focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-gray-800 transition-all duration-200"
        role="button"
        tabindex="0"
        :aria-expanded="open.toString()"
        @keydown.enter="open = !open" 
        @keydown.space.prevent="open = !open"
    >
        <span>{{ $title }}</span>
        <div class="flex items-center space-x-1">
            <span 
                class="text-xs text-blue-600 dark:text-blue-400 font-medium opacity-60" 
                x-show="!open" 
                x-transition.opacity
            >•••</span>
            <span 
                class="icon-[mdi--chevron-down] h-4 w-4 transition-all duration-300 ease-in-out hover:scale-110"
                :class="{ 'rotate-180': !open }"
            ></span>
        </div>
    </button>
    <div 
        class="px-3 pb-2 space-y-1" 
        x-show="open" 
        x-collapse.duration.300ms
        role="region"
        :aria-labelledby="'section-header-{{ Str::slug($title) }}'"
    >
        {{ $slot }}
    </div>
</div>
