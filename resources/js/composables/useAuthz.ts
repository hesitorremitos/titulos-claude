import { computed, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

type Permission = string;
type Role = string;

export function useAuthz() {
    const page = usePage<{
        auth?: {
            user?: {
                roles?: Role[];
                permissions?: Permission[];
                activeRole?: Role;
                role?: Role;
            };
        };
    }>();

    const roles = computed<Role[]>(() => {
        const assignedRoles = page.props.auth?.user?.roles ?? [];
        if (assignedRoles.length > 0) {
            return assignedRoles;
        }

        const singleRole = (page.props.auth?.user as { role?: Role } | undefined)?.role;
        return singleRole ? [singleRole] : [];
    });
    const permissions = computed<Permission[]>(() => page.props.auth?.user?.permissions ?? []);

    const activeRole = computed<Role | ''>(() => page.props.auth?.user?.activeRole ?? page.props.auth?.user?.role ?? roles.value[0] ?? '');
    const isSwitchingRole = ref(false);

    const hasRole = (role: Role) => roles.value.includes(role);
    const hasAnyRole = (candidateRoles: Role[]) => candidateRoles.some((role) => roles.value.includes(role));

    const hasPermission = (permission: Permission) => permissions.value.includes(permission);
    const hasAnyPermission = (candidatePermissions: Permission[]) =>
        candidatePermissions.some((permission) => permissions.value.includes(permission));

    const switchRole = (role: Role) => {
        if (! hasRole(role) || role === activeRole.value) {
            return;
        }

        isSwitchingRole.value = true;

        router.post(
            route('profile.active-role'),
            { role },
            {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    router.reload({ only: ['auth'] });
                },
                onFinish: () => {
                    isSwitchingRole.value = false;
                },
            },
        );
    };

    return {
        roles,
        permissions,
        activeRole,
        isSwitchingRole,
        hasRole,
        hasAnyRole,
        hasPermission,
        hasAnyPermission,
        switchRole,
    };
}
