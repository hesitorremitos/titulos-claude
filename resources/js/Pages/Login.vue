<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineOptions({ layout: GuestLayout });

interface Props {
    status?: string | null;
}
const props = defineProps<Props>();

const form = useForm({
    ci: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login.store'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Login" />
    <div class="mb-8 text-center">
            <a href="/" class="inline-block rounded-md focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none">
                <h1 class="text-2xl font-bold tracking-tight text-primary">Sistema de Títulos UATF</h1>
            </a>
    </div>
    <Card class="w-full max-w-sm border border-gray-300 shadow-xl bg-card/50">
        <CardHeader class="space-y-1">
            <CardTitle class="text-2xl font-bold">Acceder</CardTitle>
            <CardDescription>Ingresa tus credenciales</CardDescription>
            <p v-if="props.status" class="text-sm text-secondary">{{ props.status }}</p>
        </CardHeader>
        <CardContent>
            <form @submit.prevent="submit" class="space-y-4">
                <div class="space-y-2">
                    <Label for="ci">CI</Label>
                    <Input
                        id="ci"
                        type="text"
                        v-model="form.ci"
                        :aria-invalid="Boolean(form.errors.ci)"
                        autocomplete="username"
                        inputmode="numeric"
                    />
                    <p v-if="form.errors.ci" class="text-sm text-destructive">{{ form.errors.ci }}</p>
                </div>
                <div class="space-y-2">
                    <Label for="password">Contraseña</Label>
                    <Input
                        id="password"
                        type="password"
                        v-model="form.password"
                        :aria-invalid="Boolean(form.errors.password)"
                        autocomplete="current-password"
                    />
                    <p v-if="form.errors.password" class="text-sm text-destructive">{{ form.errors.password }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <input
                        id="remember"
                        type="checkbox"
                        v-model="form.remember"
                        class="h-4 w-4 rounded border-input text-primary focus-visible:ring-1 focus-visible:ring-ring/30"
                    />
                    <Label for="remember" class="text-sm">Recordarme</Label>
                </div>
                <Button type="submit" class="w-full" :disabled="form.processing">
                    <span v-if="!form.processing">Ingresar</span>
                    <span v-else>Ingresando...</span>
                </Button>
            </form>
        </CardContent>
        <CardFooter class="flex flex-col gap-2 text-xs text-muted-foreground">
            <p>© {{ new Date().getFullYear() }} UATF</p>
        </CardFooter>
    </Card>
</template>

<script lang="ts">
// Import UI components at bottom to keep script setup lean
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
export default {};
</script>
