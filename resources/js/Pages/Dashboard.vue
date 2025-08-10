<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { 
  Card, 
  CardContent, 
  CardDescription, 
  CardHeader, 
  CardTitle 
} from '@/components/ui/card'

interface Props {
  stats: {
    facultades: number
    carreras: number
    diplomasEsteMes: number
  }
  user: {
    name: string
    role: string
  }
}

defineProps<Props>()
</script>

<template>
  <AppLayout title="Dashboard">
    <div class="max-w-7xl mx-auto space-y-8">
      <!-- Card de Bienvenida -->
      <Card class="col-span-full">
        <CardHeader class="border-b">
          <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                <span class="text-2xl">👤</span>
              </div>
            </div>
            <div>
              <CardTitle class="text-xl">
                ¡Bienvenido, {{ user.name }}!
              </CardTitle>
              <CardDescription>
                Sistema de Gestión de Títulos Académicos - UATF
              </CardDescription>
            </div>
          </div>
        </CardHeader>
        <CardContent class="pt-6">
          <p class="text-muted-foreground">
            Desde este panel podrás gestionar las facultades y carreras de la Universidad Autónoma Tomás Frías.
          </p>
        </CardContent>
      </Card>

      <!-- Estadísticas Rápidas -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Facultades -->
        <Card>
          <CardContent class="p-6">
            <div class="flex items-center space-x-4">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                  <span class="text-blue-600 dark:text-blue-400">🏛️</span>
                </div>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-muted-foreground">Total Facultades</p>
                <p class="text-2xl font-semibold">{{ stats.facultades }}</p>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Total Carreras -->
        <Card>
          <CardContent class="p-6">
            <div class="flex items-center space-x-4">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                  <span class="text-green-600 dark:text-green-400">📚</span>
                </div>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-muted-foreground">Total Carreras</p>
                <p class="text-2xl font-semibold">{{ stats.carreras }}</p>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Diplomas Este Mes -->
        <Card>
          <CardContent class="p-6">
            <div class="flex items-center space-x-4">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                  <span class="text-purple-600 dark:text-purple-400">📅</span>
                </div>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-muted-foreground">Este Mes</p>
                <p class="text-2xl font-semibold">{{ stats.diplomasEsteMes }}</p>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>

      <!-- Acciones Rápidas -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <Card class="group hover:shadow-lg transition-shadow cursor-pointer">
          <CardContent class="p-6">
            <div class="flex items-center space-x-4">
              <div class="w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                <span class="text-blue-600 dark:text-blue-400 text-xl">🏛️</span>
              </div>
              <div class="flex-1">
                <CardTitle class="text-sm font-medium">
                  Gestionar Facultades
                </CardTitle>
                <CardDescription class="text-xs">
                  Ver y administrar facultades
                </CardDescription>
              </div>
            </div>
          </CardContent>
        </Card>

        <Card class="group hover:shadow-lg transition-shadow cursor-pointer">
          <CardContent class="p-6">
            <div class="flex items-center space-x-4">
              <div class="w-12 h-12 rounded-lg bg-green-100 dark:bg-green-900 flex items-center justify-center">
                <span class="text-green-600 dark:text-green-400 text-xl">📚</span>
              </div>
              <div class="flex-1">
                <CardTitle class="text-sm font-medium">
                  Gestionar Carreras
                </CardTitle>
                <CardDescription class="text-xs">
                  Ver y administrar carreras
                </CardDescription>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>