<script setup lang="ts">
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarGroup,
    SidebarGroupContent,
    SidebarGroupLabel,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { Icon } from '@iconify/vue';
import { router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

// Props del usuario desde Inertia
const page = usePage();
const user = computed(() => page.props.auth?.user);

// Function to check if a route is active
const isRouteActive = (href: string) => {
    if (href === '#') return false;
    const currentPath = page.url;
    return currentPath.startsWith(href);
};

// Items del menú principal
const menuItems = [
    {
        title: 'Dashboard',
        icon: 'material-symbols:dashboard',
        href: '/v2/dashboard',
    },
    {
        title: 'Diplomas Académicos',
        icon: 'material-symbols:school',
        href: '#',
    },
    {
        title: 'Títulos Profesionales',
        icon: 'material-symbols:workspace-premium',
        href: '#',
    },
    {
        title: 'Bachiller',
        icon: 'material-symbols:backpack',
        href: '#',
    },
];

// Items de administración
const adminItems = [
    {
        title: 'Facultades',
        icon: 'material-symbols:school',
        href: '/v2/facultades',
    },
    {
        title: 'Carreras',
        icon: 'material-symbols:book',
        href: '/v2/carreras',
    },
    {
        title: 'Usuarios',
        icon: 'material-symbols:group',
        href: '#',
    },
    {
        title: 'Configuración',
        icon: 'material-symbols:settings',
        href: '#',
    },
];

// Logout function
const logout = () => {
    router.post(route('logout'));
};
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
                                :is-active="isRouteActive(item.href)"
                                class="w-full"
                            >
                                <Icon :icon="item.icon" class="mr-2 h-4 w-4" />
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
                                :is-active="isRouteActive(item.href)"
                                class="w-full"
                            >
                                <Icon :icon="item.icon" class="mr-2 h-4 w-4" />
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
                        <Button variant="ghost" class="h-auto w-full justify-start px-2 py-2">
                            <Avatar class="mr-2 h-8 w-8">
                                <AvatarFallback class="bg-blue-600 text-sm text-white">
                                    {{ user?.name?.charAt(0)?.toUpperCase() || 'U' }}
                                </AvatarFallback>
                            </Avatar>
                            <div class="flex min-w-0 flex-1 flex-col items-start text-left">
                                <p class="w-full truncate text-sm font-medium">
                                    {{ user?.name || 'Usuario' }}
                                </p>
                                <p class="w-full truncate text-xs text-muted-foreground">
                                    {{ user?.role || 'Rol' }}
                                </p>
                            </div>
                        </Button>
                    </DropdownMenuTrigger>

                    <DropdownMenuContent class="w-56" align="end">
                        <DropdownMenuItem @click="router.visit(route('v2.profile.show'))">
                            <Icon icon="material-symbols:person" class="mr-2 h-4 w-4" />
                            Mi Perfil
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <Icon icon="material-symbols:settings" class="mr-2 h-4 w-4" />
                            Configuración
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <Icon icon="material-symbols:help" class="mr-2 h-4 w-4" />
                            Ayuda
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem @click="logout" class="text-red-600 focus:text-red-600">
                            <Icon icon="material-symbols:logout" class="mr-2 h-4 w-4" />
                            Cerrar Sesión
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </SidebarFooter>
    </Sidebar>
</template>
