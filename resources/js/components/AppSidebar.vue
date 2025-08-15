<script setup lang="ts">
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible';
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
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import { ChevronRight, GraduationCap, Home, Settings, Building2, BookOpen, Users, Award, Crown, Star, Brain, LogOut } from 'lucide-vue-next';
import { router, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
import type { Component } from 'vue';

// Types for navigation structure
interface NavigationItem {
    label: string;
    icon: Component;
    route: string;
    disabled: boolean;
}

interface NavigationSection {
    id: string;
    title: string;
    collapsible: boolean;
    icon?: Component;
    permission_required?: string[];
    items: NavigationItem[];
}

// Props del usuario desde Inertia
const page = usePage();
const user = computed(() => page.props.auth?.user);
const userRole = computed(() => {
    // Debug: log the complete user object
    console.log('Complete user object:', user.value);
    
    // Try to get role from Spatie roles array first (now it's an array of strings)
    if (user.value?.roles && Array.isArray(user.value.roles) && user.value.roles.length > 0) {
        return user.value.roles[0].name;
    }
    
    // Fallback to direct role field
    if (user.value?.role) {
        return user.value.role;
    }
    
    // Default fallback
    return 'personal';
});

// Estados de las secciones colapsables (persistidos en localStorage)
const sectionStates = ref<Record<string, boolean>>({
    titulogrado: true,      // titulo_grado -> titulogrado
    titulopostgrado: false, // titulo_postgrado -> titulopostgrado  
    adminsection: true,     // admin_section -> adminsection
});

// Function to check if a route is active
const isRouteActive = (href: string) => {
    if (href === '#') return false;
    const currentPath = page.url;
    return currentPath.startsWith(href);
};

// Navigation sections structure
const navigationSections = computed((): NavigationSection[] => [
    {
        id: 'main_menu',
        title: 'NAVEGACIÓN PRINCIPAL',
        collapsible: false,
        items: [
            {
                label: 'Dashboard',
                icon: Home,
                route: '/v2/dashboard',
                disabled: false,
            },
        ],
    },
    {
        id: 'titulo_grado',
        title: 'TÍTULOS DE GRADO',
        collapsible: true,
        icon: GraduationCap,
        items: [
            {
                label: 'Diplomas Académicos',
                icon: BookOpen,
                route: '/v2/diplomas-academicos',
                disabled: false,
            },
            {
                label: 'Títulos Académicos',
                icon: Award,
                route: '/v2/titulos-academicos',
                disabled: false,
            },
            {
                label: 'Diplomas Bachiller',
                icon: GraduationCap,
                route: '/v2/diplomas-bachiller',
                disabled: true,
            },
        ],
    },
    {
        id: 'titulo_postgrado',
        title: 'TÍTULOS DE POSTGRADO',
        collapsible: true,
        icon: Crown,
        items: [
            {
                label: 'Maestrías',
                icon: Brain,
                route: '/v2/maestrias',
                disabled: true,
            },
            {
                label: 'Doctorados',
                icon: Crown,
                route: '/v2/doctorados',
                disabled: true,
            },
            {
                label: 'Especialidades',
                icon: Star,
                route: '/v2/especialidades',
                disabled: true,
            },
        ],
    },
    {
        id: 'admin_section',
        title: 'GESTIÓN ADMINISTRATIVA',
        collapsible: true,
        icon: Settings,
        permission_required: ['admin', 'administrador', 'jefe', 'Administrador', 'Jefe', 'administrator'],
        items: [
            {
                label: 'Usuarios',
                icon: Users,
                route: '/v2/usuarios',
                disabled: false,
            },
            {
                label: 'Facultades',
                icon: Building2,
                route: '/v2/facultades',
                disabled: false,
            },
            {
                label: 'Carreras',
                icon: BookOpen,
                route: '/v2/carreras',
                disabled: false,
            },
        ],
    },
]);

// Filtered sections based on user permissions
const visibleSections = computed(() => {
    return navigationSections.value.filter(section => {
        if (!section.permission_required) return true;
        
        // Debug: log user role and required permissions
        console.log('User role:', userRole.value);
        console.log('Section:', section.title, 'requires:', section.permission_required);
        
        // Check permissions - case insensitive for flexibility
        const currentRole = userRole.value.toLowerCase();
        const allowedRoles = section.permission_required.map(role => role.toLowerCase());
        
        return allowedRoles.includes(currentRole);
    });
});

// Update section state when collapsible changes
const updateSectionState = (sectionId: string, isOpen: boolean) => {
    const key = sectionId.replace('_', '').toLowerCase();
    if (key in sectionStates.value) {
        sectionStates.value[key] = isOpen;
        localStorage.setItem(`sidebar-section-${key}`, isOpen.toString());
    }
};

// Load saved states on mount
onMounted(() => {
    Object.keys(sectionStates.value).forEach(key => {
        const saved = localStorage.getItem(`sidebar-section-${key}`);
        if (saved !== null) {
            sectionStates.value[key] = saved === 'true';
        }
    });
});

// Logout function
const logout = () => {
    router.post('/logout');
};
</script>

<template>
    <TooltipProvider>
        <Sidebar collapsible="icon">
            <!-- Header del Sidebar -->
            <SidebarHeader>
                <div class="flex items-center gap-3 px-4 py-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary text-primary-foreground">
                        <span class="text-sm font-bold">U</span>
                    </div>
                    <div class="group-data-[collapsible=icon]:hidden">
                        <p class="text-sm font-semibold text-sidebar-foreground">UATF Títulos</p>
                        <p class="text-xs text-muted-foreground">Universidad Autónoma</p>
                    </div>
                </div>
            </SidebarHeader>

            <!-- Contenido del Sidebar -->
            <SidebarContent>
                <!-- Render navigation sections -->
                <template v-for="section in visibleSections" :key="section.id">
                    <!-- Non-collapsible sections -->
                    <SidebarGroup v-if="!section.collapsible">
                        <SidebarGroupLabel class="group-data-[collapsible=icon]:hidden">
                            {{ section.title }}
                        </SidebarGroupLabel>
                        <SidebarGroupContent>
                            <SidebarMenu>
                                <SidebarMenuItem v-for="item in section.items" :key="item.label">
                                    <Tooltip>
                                        <TooltipTrigger as-child>
                                            <SidebarMenuButton
                                                :as="item.disabled ? 'button' : 'a'"
                                                :href="item.disabled ? undefined : item.route"
                                                :is-active="!item.disabled && isRouteActive(item.route)"
                                                :disabled="item.disabled"
                                                class="transition-all duration-200"
                                                :class="item.disabled ? 'cursor-not-allowed opacity-50' : ''"
                                            >
                                                <component :is="item.icon" class="h-4 w-4" />
                                                <span class="group-data-[collapsible=icon]:hidden">{{ item.label }}</span>
                                            </SidebarMenuButton>
                                        </TooltipTrigger>
                                        <TooltipContent class="group-data-[collapsible=icon]:block hidden" side="right">
                                            <p>{{ item.label }}{{ item.disabled ? ' (No disponible)' : '' }}</p>
                                        </TooltipContent>
                                    </Tooltip>
                                </SidebarMenuItem>
                            </SidebarMenu>
                        </SidebarGroupContent>
                    </SidebarGroup>

                    <!-- Collapsible sections using SidebarGroup with Collapsible -->
                    <Collapsible 
                        v-else
                        :default-open="sectionStates[section.id.replace('_', '').toLowerCase()] ?? true"
                        class="group/collapsible"
                        @update:open="(open) => updateSectionState(section.id, open)"
                    >
                        <SidebarGroup>
                            <SidebarGroupLabel as-child>
                                <CollapsibleTrigger class="group-data-[collapsible=icon]:hidden">
                                    <div class="flex items-center gap-2">
                                        <component :is="section.icon" class="h-4 w-4" />
                                        {{ section.title }}
                                    </div>
                                    <ChevronRight class="ml-auto h-3 w-3 transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                                </CollapsibleTrigger>
                            </SidebarGroupLabel>
                            <CollapsibleContent>
                                <SidebarGroupContent>
                                    <SidebarMenu>
                                        <SidebarMenuItem v-for="item in section.items" :key="item.label">
                                            <Tooltip>
                                                <TooltipTrigger as-child>
                                                    <SidebarMenuButton
                                                        :as="item.disabled ? 'button' : 'a'"
                                                        :href="item.disabled ? undefined : item.route"
                                                        :is-active="!item.disabled && isRouteActive(item.route)"
                                                        :disabled="item.disabled"
                                                        class="transition-all duration-200"
                                                        :class="item.disabled ? 'cursor-not-allowed opacity-50' : ''"
                                                    >
                                                        <component :is="item.icon" class="h-4 w-4" />
                                                        <span class="group-data-[collapsible=icon]:hidden">{{ item.label }}</span>
                                                    </SidebarMenuButton>
                                                </TooltipTrigger>
                                                <TooltipContent class="group-data-[collapsible=icon]:block hidden" side="right">
                                                    <p>{{ item.label }}{{ item.disabled ? ' (No disponible)' : '' }}</p>
                                                </TooltipContent>
                                            </Tooltip>
                                        </SidebarMenuItem>
                                    </SidebarMenu>
                                </SidebarGroupContent>
                            </CollapsibleContent>
                        </SidebarGroup>
                    </Collapsible>
                </template>
            </SidebarContent>

            <!-- Footer del Sidebar -->
            <SidebarFooter>
                <div class="px-3 py-3">
                    <DropdownMenu>
                        <DropdownMenuTrigger as-child>
                            <Button variant="ghost" class="h-auto w-full justify-start px-3 py-3 group-data-[collapsible=icon]:justify-center">
                                <Avatar class="h-8 w-8 group-data-[collapsible=icon]:mr-0 mr-3">
                                    <AvatarFallback class="bg-secondary text-sm text-secondary-foreground">
                                        {{ user?.name?.charAt(0)?.toUpperCase() || 'A' }}
                                    </AvatarFallback>
                                </Avatar>
                                <div class="flex min-w-0 flex-1 flex-col items-start text-left group-data-[collapsible=icon]:hidden">
                                    <p class="w-full truncate text-sm font-medium text-sidebar-foreground">
                                        {{ user?.name || 'Administrador' }}
                                    </p>
                                    <p class="w-full truncate text-xs text-muted-foreground">
                                        {{ userRole || 'personal' }}
                                    </p>
                                </div>
                            </Button>
                        </DropdownMenuTrigger>

                        <DropdownMenuContent class="w-56" align="end">
                            <DropdownMenuItem @click="router.visit(route('v2.profile.show'))">
                                <Users class="mr-2 h-4 w-4" />
                                Mi Perfil
                            </DropdownMenuItem>
                            <DropdownMenuItem>
                                <Settings class="mr-2 h-4 w-4" />
                                Configuración
                            </DropdownMenuItem>
                            <DropdownMenuSeparator />
                            <DropdownMenuItem @click="logout" class="text-destructive">
                                <LogOut class="mr-2 h-4 w-4" />
                                Cerrar Sesión
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </SidebarFooter>
        </Sidebar>
    </TooltipProvider>
</template>
