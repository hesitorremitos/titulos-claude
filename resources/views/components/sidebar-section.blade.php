@props(['title'])

<div class="pt-4">
    <h3 class="px-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
        {{ $title }}
    </h3>
    <div class="mt-2 space-y-1">
        {{ $slot }}
    </div>
</div>
