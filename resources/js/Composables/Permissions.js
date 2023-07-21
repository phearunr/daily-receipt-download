import { usePage } from '@inertiajs/vue3';
export function userPermission() {
   // const hasRole = () => usePage().props.auth.user.roles.includes('name');
    //const hasPermission = () => usePage().props.auth.user.permissions.includes('name');
    const hasBasketCount = () => usePage().props.auth.user.basketCount;
    return { hasBasketCount };
    //return { hasRole, hasPermission, hasBasketCount };
}
