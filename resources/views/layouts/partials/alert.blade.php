@props(['type' => 'success', 'message'])

@php
$alertClasses = [
    'success' => 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800 text-green-800 dark:text-green-200',
    'error' => 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 text-red-800 dark:text-red-200',
    'warning' => 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-200',
    'info' => 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-200'
];

$iconClasses = [
    'success' => 'icon-[mdi--check-circle]',
    'error' => 'icon-[mdi--alert-circle]',
    'warning' => 'icon-[mdi--alert]',
    'info' => 'icon-[mdi--information]'
];
@endphp

<div class="rounded-md border p-4 mb-4 {{ $alertClasses[$type] ?? $alertClasses['info'] }}">
    <div class="flex">
        <div class="flex-shrink-0">
            <span class="{{ $iconClasses[$type] ?? $iconClasses['info'] }} w-5 h-5" aria-hidden="true"></span>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium">
                {{ $message }}
            </p>
        </div>
    </div>
</div>
