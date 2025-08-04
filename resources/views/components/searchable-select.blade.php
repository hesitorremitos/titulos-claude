@props([
    'options' => [],
    'selected' => null,
    'placeholder' => 'Seleccionar opción',
    'searchPlaceholder' => 'Buscar...',
    'name' => null,
    'id' => 'searchable-select-' . uniqid(),
    'required' => false,
    'disabled' => false,
    'label' => null,
    'error' => null,
    'noResultsText' => 'No se encontraron resultados',
    'valueKey' => 'id',
    'labelKey' => 'name'
])

<div x-data="searchableSelect({{ json_encode($options) }}, '{{ $valueKey }}', '{{ $labelKey }}', {{ json_encode($selected) }})" 
     class="w-full">
    
    @if($label)
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    @endif
    
    <div class="relative">
        <!-- Hidden Input for Form Submission -->
        @if($name)
        <input type="hidden" 
               name="{{ $name }}" 
               :value="selected ? selected[valueKey] : ''" 
               @if($required) required @endif>
        @endif
        
        <!-- Select Button -->
        <button 
            @click="open = !open" 
            @keydown.escape="open = false"
            @keydown.arrow-down.prevent="open = true; $nextTick(() => focusFirstOption())"
            type="button"
            id="{{ $id }}"
            :disabled="{{ $disabled ? 'true' : 'false' }}"
            class="relative w-full bg-white dark:bg-gray-700 border rounded-lg pl-3 pr-10 py-2.5 text-left cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
            :class="{
                'border-gray-300 dark:border-gray-600': !open && !{{ $error ? 'true' : 'false' }},
                'border-primary-500 dark:border-primary-400': open && !{{ $error ? 'true' : 'false' }},
                'border-red-500 dark:border-red-400': {{ $error ? 'true' : 'false' }},
                'opacity-50 cursor-not-allowed': {{ $disabled ? 'true' : 'false' }}
            }">
            
            <span x-text="selected ? selected[labelKey] : '{{ $placeholder }}'" 
                  class="block truncate"
                  :class="selected ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400'"></span>
            
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <span class="icon-[mdi--chevron-down] w-5 h-5 text-gray-400" 
                      :class="{ 'rotate-180': open }" 
                      style="transition: transform 0.2s;"></span>
            </span>
        </button>

        <!-- Dropdown -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             @click.away="open = false"
             @keydown.escape="open = false"
             class="absolute z-50 mt-1 w-full bg-white dark:bg-gray-700 shadow-lg rounded-lg border border-gray-300 dark:border-gray-600 max-h-64 overflow-hidden">
            
            <!-- Search Input -->
            <div class="p-3 border-b border-gray-200 dark:border-gray-600">
                <input x-model="search" 
                       x-ref="searchInput"
                       @keydown.arrow-down.prevent="focusFirstOption()"
                       @keydown.arrow-up.prevent="focusLastOption()"
                       @keydown.enter.prevent="selectFirstFiltered()"
                       type="text" 
                       placeholder="{{ $searchPlaceholder }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
            </div>
            
            <!-- Options List -->
            <div class="max-h-48 overflow-auto">
                <template x-for="(option, index) in filteredOptions" :key="option[valueKey]">
                    <div @click="selectOption(option); open = false; search = ''" 
                         @keydown.enter.prevent="selectOption(option); open = false; search = ''"
                         @keydown.arrow-down.prevent="focusNext($event)"
                         @keydown.arrow-up.prevent="focusPrev($event)"
                         @keydown.escape="open = false"
                         tabindex="0"
                         class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-primary-50 dark:hover:bg-primary-900/20 focus:bg-primary-50 dark:focus:bg-primary-900/20 focus:outline-none"
                         :class="{ 
                             'bg-primary-100 dark:bg-primary-900/30': selected && selected[valueKey] === option[valueKey],
                             'text-primary-900 dark:text-primary-100': selected && selected[valueKey] === option[valueKey],
                             'text-gray-900 dark:text-white': !selected || selected[valueKey] !== option[valueKey]
                         }">
                        
                        <span x-text="option[labelKey]" class="block truncate"></span>
                        
                        <!-- Selected Checkmark -->
                        <span x-show="selected && selected[valueKey] === option[valueKey]" 
                              class="absolute inset-y-0 right-0 flex items-center pr-4">
                            <span class="icon-[mdi--check] w-5 h-5 text-primary-600 dark:text-primary-400"></span>
                        </span>
                    </div>
                </template>
                
                <!-- No Results -->
                <div x-show="filteredOptions.length === 0" 
                     class="py-3 px-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                    {{ $noResultsText }}
                </div>
            </div>
        </div>
    </div>
    
    @if($error)
    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>

<script>
function searchableSelect(options, valueKey, labelKey, initialSelected = null) {
    return {
        options: options,
        search: '',
        open: false,
        selected: initialSelected,
        valueKey: valueKey,
        labelKey: labelKey,
        
        get filteredOptions() {
            if (!this.search) return this.options;
            
            return this.options.filter(option => {
                const label = option[this.labelKey]?.toString().toLowerCase() || '';
                return label.includes(this.search.toLowerCase());
            });
        },
        
        selectOption(option) {
            this.selected = option;
            this.$dispatch('select-changed', { 
                selected: option, 
                value: option[this.valueKey],
                label: option[this.labelKey]
            });
        },
        
        focusFirstOption() {
            this.$nextTick(() => {
                const firstOption = this.$el.querySelector('[tabindex="0"]');
                if (firstOption) firstOption.focus();
            });
        },
        
        focusLastOption() {
            this.$nextTick(() => {
                const options = this.$el.querySelectorAll('[tabindex="0"]');
                const lastOption = options[options.length - 1];
                if (lastOption) lastOption.focus();
            });
        },
        
        focusNext(event) {
            const current = event.target;
            const next = current.nextElementSibling;
            if (next && next.hasAttribute('tabindex')) {
                next.focus();
            }
        },
        
        focusPrev(event) {
            const current = event.target;
            const prev = current.previousElementSibling;
            if (prev && prev.hasAttribute('tabindex')) {
                prev.focus();
            }
        },
        
        selectFirstFiltered() {
            if (this.filteredOptions.length > 0) {
                this.selectOption(this.filteredOptions[0]);
                this.open = false;
                this.search = '';
            }
        },
        
        init() {
            // Focus search input when dropdown opens
            this.$watch('open', (value) => {
                if (value) {
                    this.$nextTick(() => {
                        if (this.$refs.searchInput) {
                            this.$refs.searchInput.focus();
                        }
                    });
                }
            });
        }
    }
}
</script>