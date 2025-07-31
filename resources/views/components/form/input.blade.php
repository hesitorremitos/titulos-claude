@props([
    'name',
    'label' => null,
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'icon' => null,
    'showPasswordToggle' => false,
    'value' => '',
    'error' => null
])

@php
    $id = $name;
    $hasError = $error || $errors->has($name);
    $errorMessage = $error ?? $errors->first($name);
@endphp

<div class="mb-4">
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-2">
            @if($icon)
                <span class="icon-[{{ $icon }}] inline h-4 w-4 mr-1"></span>
            @endif
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input 
            id="{{ $id }}"
            name="{{ $name }}"
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            value="{{ old($name, $value) }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' => 'w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200' .
                          ($showPasswordToggle ? ' pr-12' : '') .
                          ($hasError ? ' border-red-500 bg-red-50' : ' border-gray-300')
            ]) }}
        />

        @if($showPasswordToggle)
            <button 
                type="button" 
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700"
                onclick="togglePassword('{{ $id }}')"
            >
                <span class="password-toggle-icon icon-[mdi--eye] h-5 w-5"></span>
            </button>
        @endif
    </div>

    @if($hasError)
        <div class="mt-2 flex items-center text-red-600 text-sm">
            <span class="icon-[mdi--alert-circle] mr-1 h-4 w-4"></span>
            {{ $errorMessage }}
        </div>
    @endif
</div>

@if($showPasswordToggle)
    @push('scripts')
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('.password-toggle-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'password-toggle-icon icon-[mdi--eye-off] h-5 w-5';
            } else {
                input.type = 'password';
                icon.className = 'password-toggle-icon icon-[mdi--eye] h-5 w-5';
            }
        }
    </script>
    @endpush
@endif