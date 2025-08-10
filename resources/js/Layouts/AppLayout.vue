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
import { Toaster } from '@/components/ui/sonner'

interface Props {
  title?: string
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
          <Breadcrumb>
            <BreadcrumbList>
              <BreadcrumbItem class="hidden md:block">
                <BreadcrumbLink href="/v2/dashboard">
                  Sistema de Títulos UATF
                </BreadcrumbLink>
              </BreadcrumbItem>
              <BreadcrumbSeparator class="hidden md:block" />
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
    <Toaster />
  </div>
</template>