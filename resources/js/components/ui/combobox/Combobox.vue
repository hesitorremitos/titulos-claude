<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { cn } from '@/lib/utils';
import { Check, ChevronsUpDown } from 'lucide-vue-next';

interface Option {
    label: string;
    value: string | number | null;
    description?: string;
}

interface Props {
    modelValue: string | number | null;
    options: Option[];
    placeholder?: string;
    searchPlaceholder?: string;
    emptyMessage?: string;
    disabled?: boolean;
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    placeholder: 'Selecciona una opción',
    searchPlaceholder: 'Buscar…',
    emptyMessage: 'No se encontraron resultados.',
});

const emit = defineEmits<{
    'update:modelValue': [string | number | null];
    change: [Option | undefined];
}>();

const open = ref(false);
const search = ref('');

const selectedOption = computed(() =>
    props.options.find((option) => option.value === props.modelValue),
);

const filteredOptions = computed(() => {
    const query = search.value.trim().toLowerCase();

    if (! query) {
        return props.options;
    }

    return props.options.filter((option) =>
        option.label.toLowerCase().includes(query) ||
        (option.description ? option.description.toLowerCase().includes(query) : false),
    );
});

const handleSelect = (option: Option) => {
    if (props.disabled) {
        return;
    }

    const value = option.value;
    emit('update:modelValue', value);
    emit('change', option);
    open.value = false;
};

watch(open, (value) => {
    if (value) {
        search.value = '';
    }
});
</script>

<template>
    <Popover v-model:open="open">
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                role="combobox"
                :disabled="disabled"
                :aria-expanded="open"
                :class="cn('w-full justify-between', props.class)"
            >
                <span class="truncate">
                    {{ selectedOption?.label ?? placeholder }}
                </span>
                <ChevronsUpDown class="ml-2 size-4 shrink-0 opacity-50" />
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-[--radix-popover-trigger-width] p-0" align="start">
            <div class="p-2">
                <Input
                    v-model="search"
                    :placeholder="searchPlaceholder"
                    type="search"
                    class="h-9"
                    autofocus
                />
            </div>

            <div class="max-h-60 overflow-y-auto px-1 pb-1">
                <template v-if="filteredOptions.length > 0">
                    <button
                        v-for="option in filteredOptions"
                        :key="option.value ?? `option-${option.label}`"
                        type="button"
                        class="flex w-full items-center justify-between rounded-md px-2 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground"
                        :class="{
                            'bg-accent text-accent-foreground': selectedOption?.value === option.value,
                        }"
                        @click="handleSelect(option)"
                    >
                        <span class="flex flex-col text-left">
                            <span>{{ option.label }}</span>
                            <span v-if="option.description" class="text-xs text-muted-foreground">
                                {{ option.description }}
                            </span>
                        </span>
                        <Check
                            v-if="selectedOption?.value === option.value"
                            class="size-4 text-primary"
                        />
                    </button>
                </template>
                <p v-else class="px-3 py-2 text-sm text-muted-foreground">
                    {{ emptyMessage }}
                </p>
            </div>
        </PopoverContent>
    </Popover>
</template>
