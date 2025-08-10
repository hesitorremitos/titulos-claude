<script setup lang="ts">
import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarFooter,
} from '@/components/ui/sidebar'
import {
  Avatar,
  AvatarFallback,
} from '@/components/ui/avatar'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Button } from '@/components/ui/button'
import { usePage, router } from '@inertiajs/vue3'
import { computed } from 'vue'

// Props del usuario desde Inertia
const page = usePage()
const user = computed(() => page.props.auth?.user)

// Items del menú principal
const menuItems = [
  {
    title: 'Dashboard',
    icon: '🏠',
    href: '/v2/dashboard',
    active: true
  },
  {
    title: 'Diplomas Académicos',
    icon: '🎓',
    href: '#',
    active: false
  },
  {
    title: 'Títulos Profesionales',
    icon: '📜',
    href: '#',
    active: false
  },
  {
    title: 'Bachiller',
    icon: '🎒',
    href: '#',
    active: false
  }
]

// Items de administración
const adminItems = [
  {
    title: 'Usuarios',
    icon: '👥',
    href: '#',
    active: false
  },
  {
    title: 'Configuración',
    icon: '⚙️',
    href: '#',
    active: false
  }
]

// Logout function
const logout = () => {
  router.post(route('logout'))
}
</script>

<template>
  <Sidebar>
    <!-- Header del Sidebar -->
    <SidebarHeader class="border-b border-sidebar-border">
      <div class="flex items-center gap-3 px-2 py-2">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-600 text-white">
          <span class="text-sm font-bold">U</span>
        </div>
        <div>
          <p class="text-sm font-semibold">UATF Títulos</p>
          <p class="text-xs text-muted-foreground">Universidad</p>
        </div>
      </div>
    </SidebarHeader>

    <!-- Contenido del Sidebar -->
    <SidebarContent>
      <!-- Menú Principal -->
      <SidebarGroup>
        <SidebarGroupLabel>Menú Principal</SidebarGroupLabel>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem v-for="item in menuItems" :key="item.title">
              <SidebarMenuButton 
                :as="item.href.startsWith('#') ? 'button' : 'a'"
                :href="item.href.startsWith('#') ? undefined : item.href"
                :is-active="item.active"
                class="w-full"
              >
                <span class="mr-2">{{ item.icon }}</span>
                {{ item.title }}
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>

      <!-- Administración -->
      <SidebarGroup>
        <SidebarGroupLabel>Administración</SidebarGroupLabel>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem v-for="item in adminItems" :key="item.title">
              <SidebarMenuButton 
                :as="item.href.startsWith('#') ? 'button' : 'a'"
                :href="item.href.startsWith('#') ? undefined : item.href"
                :is-active="item.active"
                class="w-full"
              >
                <span class="mr-2">{{ item.icon }}</span>
                {{ item.title }}
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>

    </SidebarContent>

    <!-- Footer del Sidebar -->
    <SidebarFooter class="border-t border-sidebar-border">
      <div class="px-2 py-2">
        <DropdownMenu>
          <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="w-full justify-start px-2 py-2 h-auto">
              <Avatar class="h-8 w-8 mr-2">
                <AvatarFallback class="bg-blue-600 text-white text-sm">
                  {{ user?.name?.charAt(0)?.toUpperCase() || 'U' }}
                </AvatarFallback>
              </Avatar>
              <div class="flex flex-col items-start text-left min-w-0 flex-1">
                <p class="text-sm font-medium truncate w-full">
                  {{ user?.name || 'Usuario' }}
                </p>
                <p class="text-xs text-muted-foreground truncate w-full">
                  {{ user?.role || 'Rol' }}
                </p>
              </div>
            </Button>
          </DropdownMenuTrigger>
          
          <DropdownMenuContent class="w-56" align="end">
            <DropdownMenuItem @click="router.visit(route('v2.profile.show'))">
              <span class="mr-2">👤</span>
              Mi Perfil
            </DropdownMenuItem>
            <DropdownMenuItem>
              <span class="mr-2">⚙️</span>
              Configuración
            </DropdownMenuItem>
            <DropdownMenuItem>
              <span class="mr-2">❓</span>
              Ayuda
            </DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem @click="logout" class="text-red-600 focus:text-red-600">
              <span class="mr-2">🚪</span>
              Cerrar Sesión
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </div>
    </SidebarFooter>
  </Sidebar>
</template>