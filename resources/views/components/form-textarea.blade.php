@props([
    'name' => '',
    'placeholder' => '',
    'rows' => '4',
    'disabled' => false
])

<textarea 
    name="{{ $name }}"
    id="{{ $name }}"
    rows="{{ $rows }}"
    placeholder="{{ $placeholder }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => 'block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 text-sm resize-none']) }}
>{{ $slot }}</textarea>