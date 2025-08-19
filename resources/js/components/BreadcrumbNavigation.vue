<script setup lang="ts">
import { Breadcrumb, BreadcrumbItem, BreadcrumbLink, BreadcrumbList, BreadcrumbPage, BreadcrumbSeparator } from '@/components/ui/breadcrumb';
import { ChevronRight } from 'lucide-vue-next';
import type { BreadcrumbItem as BreadcrumbItemType } from '@/types';

// Props
interface Props {
    items: BreadcrumbItemType[];
}

const props = defineProps<Props>();

// Use the provided items directly
const breadcrumbItems = props.items;
</script>

<template>
    <Breadcrumb>
        <BreadcrumbList>
            <template v-for="(item, index) in breadcrumbItems" :key="`${item.label}-${index}`">
                <BreadcrumbItem>
                    <!-- Clickeable breadcrumb link -->
                    <BreadcrumbLink 
                        v-if="item.href && index < breadcrumbItems.length - 1"
                        :href="item.href"
                        class="transition-colors duration-150 hover:text-foreground text-muted-foreground text-xs"
                    >
                        {{ item.label }}
                    </BreadcrumbLink>
                    
                    <!-- Current page (non-clickeable) -->
                    <BreadcrumbPage 
                        v-else
                        class="text-foreground font-medium text-xs"
                    >
                        {{ item.label }}
                    </BreadcrumbPage>
                </BreadcrumbItem>
                
                <!-- Separator (not shown after last item) -->
                <BreadcrumbSeparator v-if="index < breadcrumbItems.length - 1">
                    <ChevronRight class="h-3 w-3" />
                </BreadcrumbSeparator>
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>