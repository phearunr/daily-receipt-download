<script setup>
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    roles: Object
});

const allRoles = computed(() => {
    return [{ value: null, label: "Any role" }, ...props.roles];
});


const form = useForm({
    name: null,
    email: null,
    role: null,
    password: null,
    password_confirmation: null,
});

const createUser = () => {
    form.post(route('system.users.store'), {
        errorBag: 'createUser',
        preserveScroll: true,
    });
};
</script>

<template>
    <FormSection @submitted="createUser">
        <template #title>
            User Details
        </template>

        <template #description>
            Create a new user to collaborate with others on projects.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Name" />
                <TextInput id="name" v-model="form.name" type="text" class="block w-full mt-1" autofocus />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" v-model="form.email" type="email" class="block w-full mt-1" autofocus />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <select v-model="form.role" aria-label="Media date" id="date"
                    class="pr-10 pl-3 w-full h-11 backdrop:rounded border-gray-300 shadow-sm lg:h-9 lg:text-sm sm:w-44 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option v-for="role in allRoles" :value="role.value">
                        {{ role.label }}
                    </option>
                </select>
            </div>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="password" value="Password" />
                <TextInput id="name" v-model="form.password" type="password" class="block w-full mt-1" autofocus />
                <InputError :message="form.errors.password" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Confirm Password" />
                <TextInput id="confirm_password" v-model="form.password_confirmation" type="password"
                    class="block w-full mt-1" autofocus />
                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>

        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </PrimaryButton>
        </template>
    </FormSection>
</template>
