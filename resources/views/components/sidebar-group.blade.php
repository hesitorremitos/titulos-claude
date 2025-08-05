@props([
    'title',
    'collapsible' => true,
    'defaultOpen' => true,
    'icon' => null
])

@php
$groupId = Str::slug($title);
$persistKey = 'sidebar_group_' . $groupId;
@endphp

<div class="mb-4">
    @if($collapsible)
        <div x-data="{ open: $persist({{ $defaultOpen ? 'true' : 'false' }}).as('{{ $persistKey }}') }">
            <button 
                @click="open = !open"
                class="flex items-center w-full text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 hover:text-gray-700 dark:hover:text-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-gray-50 dark:focus:ring-offset-gray-900 rounded-sm"
                type="button"
                :aria-expanded="open.toString()"
                aria-controls="group-{{ $groupId }}"
            >
                @if($icon)
                    <span class="icon-[{{ $icon }}] w-4 h-4 mr-2"></span>
                @endif
                <span class="icon-[mdi--chevron-down] w-4 h-4 mr-1 transition-transform duration-200" :class="{ 'rotate-180': !open }"></span>
                {{ $title }}
            </button>
            
            <div 
                id="group-{{ $groupId }}"
                class="space-y-1" 
                x-show="open" 
                x-transition:enter="transition ease-out duration-200" 
                x-transition:enter-start="opacity-0 -translate-y-2" 
                x-transition:enter-end="opacity-100 translate-y-0" 
                x-transition:leave="transition ease-in duration-150" 
                x-transition:leave-start="opacity-100 translate-y-0" 
                x-transition:leave-end="opacity-0 -translate-y-2"
                role="region"
                :aria-labelledby="'group-header-{{ $groupId }}'"
            >
                {{ $slot }}
            </div>
        </div>
    @else
        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
            @if($icon)
                <span class="icon-[{{ $icon }}] w-4 h-4 mr-2 inline"></span>
            @endif
            {{ $title }}
        </div>
        <div class="space-y-1">
            {{ $slot }}
        </div>
    @endif
</div>
