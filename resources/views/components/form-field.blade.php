@props([
    'label' => '',
    'name' => '',
    'required' => false,
    'error' => null,
    'help' => null
])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div>
        {{ $slot }}
    </div>
    
    @if($error)
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
    
    @if($help)
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $help }}</p>
    @endif
</div>