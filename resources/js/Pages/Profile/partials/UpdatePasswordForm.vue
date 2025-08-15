<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Icon } from '@iconify/vue';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.patch(route('v2.profile.password'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            toast.success('Tu contraseña ha sido cambiada correctamente.');
        },
        onError: () => {
            toast.error('Hubo un problema al cambiar tu contraseña. Verifica los campos e intenta nuevamente.');
        },
    });
};
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle class="flex items-center">
                <Icon icon="material-symbols:lock" class="mr-2 h-5 w-5 text-orange-600" />
                Cambiar Contraseña
            </CardTitle>
            <CardDescription> Asegúrate de usar una contraseña segura para proteger tu cuenta. </CardDescription>
        </CardHeader>

        <CardContent>
            <form @submit.prevent="submit" class="space-y-4">
                <!-- Contraseña Actual -->
                <div class="space-y-2">
                    <Label for="current_password" class="flex items-center">
                        <Icon icon="material-symbols:lock-open" class="mr-1 h-4 w-4" />
                        Contraseña Actual
                    </Label>
                    <Input
                        id="current_password"
                        v-model="form.current_password"
                        type="password"
                        required
                        autocomplete="current-password"
                        :class="{ 'border-destructive': form.errors.current_password }"
                    />
                    <p v-if="form.errors.current_password" class="text-sm text-destructive">
                        {{ form.errors.current_password }}
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <!-- Nueva Contraseña -->
                    <div class="space-y-2">
                        <Label for="password" class="flex items-center">
                            <Icon icon="material-symbols:key" class="mr-1 h-4 w-4" />
                            Nueva Contraseña
                        </Label>
                        <Input
                            id="password"
                            v-model="form.password"
                            type="password"
                            required
                            autocomplete="new-password"
                            :class="{ 'border-destructive': form.errors.password }"
                        />
                        <p v-if="form.errors.password" class="text-sm text-destructive">
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="space-y-2">
                        <Label for="password_confirmation" class="flex items-center">
                            <Icon icon="material-symbols:check-circle" class="mr-1 h-4 w-4" />
                            Confirmar Contraseña
                        </Label>
                        <Input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            :class="{ 'border-destructive': form.errors.password_confirmation }"
                        />
                        <p v-if="form.errors.password_confirmation" class="text-sm text-destructive">
                            {{ form.errors.password_confirmation }}
                        </p>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <Button type="submit" variant="secondary" :disabled="form.processing">
                        <Icon v-if="form.processing" icon="material-symbols:progress-activity" class="mr-2 h-4 w-4 animate-spin" />
                        <Icon v-else icon="material-symbols:key" class="mr-2 h-4 w-4" />
                        {{ form.processing ? 'Cambiando...' : 'Cambiar Contraseña' }}
                    </Button>
                </div>
            </form>
        </CardContent>
    </Card>
</template>
