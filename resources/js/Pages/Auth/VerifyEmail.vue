<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import Container from "../../Components/Container.vue";
import PrimaryButton from "../../Components/PrimaryBtn.vue";
import SessionMessages from "../../Components/SessionMessages.vue";

defineProps({
    status: String,
})

const form = useForm({})

const submit = () => {
    form.post(route('verification.send'))
}
</script>
<template>

    <Head title="Email Verification" />
    <Container class="w-full sm:w-1/2 p-2">
        <div class="mb-8">
            <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the
                link we
                just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
        </div>
        <SessionMessages :status="status"/>
        <form @submit.prevent="submit">
            <PrimaryButton :disabled="form.processing">Resend Verification Email</PrimaryButton>
        </form>
    </Container>
</template>