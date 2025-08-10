<script setup lang="ts">
import AppSidebar from '@/components/AppSidebar.vue'
import ThemeToggle from '@/components/ThemeToggle.vue'
import {
  SidebarInset,
  SidebarProvider,
  SidebarTrigger,
} from '@/components/ui/sidebar'
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator,
} from '@/components/ui/breadcrumb'
import { Separator } from '@/components/ui/separator'
import { Head } from '@inertiajs/vue3'
import { Icon } from '@iconify/vue'
import { Toaster } from '@/components/ui/sonner'

interface BreadcrumbItem {
  label: string
  href?: string
}

interface Props {
  title?: string
  breadcrumbs?: BreadcrumbItem[]
}

defineProps<Props>()
</script>

<template>
  <div>
    <Head :title="title" />
    
    <SidebarProvider>
      <AppSidebar />
      <SidebarInset>
        <!-- Header con trigger, breadcrumbs y theme toggle -->
        <header class="flex h-16 shrink-0 items-center gap-2 border-b px-4">
          <SidebarTrigger class="-ml-1" />
          <Separator orientation="vertical" class="mr-2 h-4" />
          <Breadcrumb v-if="breadcrumbs && breadcrumbs.length > 0">
            <BreadcrumbList>
              <!-- Icono Home como primer elemento -->
              <BreadcrumbItem>
                <BreadcrumbLink href="/v2/dashboard" class="flex items-center">
                  <Icon icon="material-symbols:home" class="w-4 h-4" />
                </BreadcrumbLink>
              </BreadcrumbItem>
              
              <!-- Breadcrumbs dinámicos -->
              <template v-for="(item, index) in breadcrumbs" :key="index">
                <BreadcrumbSeparator />
                <BreadcrumbItem>
                  <BreadcrumbLink v-if="item.href" :href="item.href">
                    {{ item.label }}
                  </BreadcrumbLink>
                  <BreadcrumbPage v-else>
                    {{ item.label }}
                  </BreadcrumbPage>
                </BreadcrumbItem>
              </template>
            </BreadcrumbList>
          </Breadcrumb>
          
          <!-- Breadcrumb por defecto (Dashboard) -->
          <Breadcrumb v-else>
            <BreadcrumbList>
              <BreadcrumbItem>
                <BreadcrumbLink href="/v2/dashboard" class="flex items-center">
                  <Icon icon="material-symbols:home" class="w-4 h-4" />
                </BreadcrumbLink>
              </BreadcrumbItem>
              <BreadcrumbSeparator />
              <BreadcrumbItem>
                <BreadcrumbPage>Dashboard</BreadcrumbPage>
              </BreadcrumbItem>
            </BreadcrumbList>
          </Breadcrumb>
          
          <!-- Theme Toggle al final del header -->
          <div class="ml-auto">
            <ThemeToggle />
          </div>
        </header>

        <!-- Contenido principal -->
        <div class="flex flex-1 flex-col gap-4 p-4">
          <slot />
        </div>
      </SidebarInset>
    </SidebarProvider>
    
    <!-- Toast notifications -->
    <Toaster 
      position="bottom-right" 
      :duration="4000"
      :close-button="true"
      :rich-colors="true"
    />
  </div>
</template>