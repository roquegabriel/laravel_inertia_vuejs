<script setup>
import Container from "../../../Components/Container.vue";
import ErrorMessages from "../../../Components/ErrorMessages.vue";
import SessionMessages from "../../../Components/SessionMessages.vue";
import Title from "../../../Components/HeadingTitle.vue";
import InputField from "../../../Components/InputField.vue";
import PrimaryBtn from "../../../Components/PrimaryBtn.vue";
import { useForm } from "@inertiajs/vue3";


const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.put(route('profile.password'), {
        onSuccess: () => form.reset(),
        onError: () => form.reset(),
        preserveScroll: true,
    })
}


</script>
<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Password</Title>
            <p>Ensure your are using a long, random password to stay secure.</p>
        </div>
        <ErrorMessages :errors="form.errors" />
        <form class="space-y-6" @submit.prevent="submit">
            <InputField label="Current Password" icon="key" class="w-full sm:w-1/2" v-model="form.current_password"
                type="password" />
            <InputField label="New Password" icon="key" class="w-full sm:w-1/2" v-model="form.password" type="password" />
            <InputField label="Confirm Password" icon="key" class="w-full sm:w-1/2" v-model="form.password_confirmation"
                type="password" />
                <p v-if="form.recentlySuccessful" class="text-green-500 font-medium">Saved!</p>
            <PrimaryBtn :disabled="form.processing">Save</PrimaryBtn>
        </form>
    </Container>
</template>
