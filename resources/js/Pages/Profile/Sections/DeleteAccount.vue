<script setup>
import Container from "../../../Components/Container.vue";
import ErrorMessages from "../../../Components/ErrorMessages.vue";
import Title from "../../../Components/HeadingTitle.vue";
import InputField from "../../../Components/InputField.vue";
import PrimaryBtn from "../../../Components/PrimaryBtn.vue";
import SecondaryButton from "../../../Components/SecondaryButton.vue";
import DangerButton from "../../../Components/DangerButton.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const showConfirmPassword = ref(false)

const form = useForm({
    password: '',
})

const submit = () => {
    form.delete(route('profile.destroy'), {
        onFinish: () => form.reset(),
        preserveScroll: true,
    })
}

</script>
<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Delete Account</Title>
            <p>Once your account is deleted, all of its resources data will be permanently deleted. This action cannot
                be undone.</p>
        </div>
        <ErrorMessages :errors="form.errors" />
        <div v-if="showConfirmPassword">
            <form class="flex flex-col gap-4 sm:flex-row sm:gap-2" @submit.prevent="submit">
                <InputField label="Confirm Password" icon="key" class="w-full sm:w-1/2" v-model="form.password"
                    type="password" />
                <div class="flex gap-2 mb-2">
                    <PrimaryBtn :disabled="form.processing" class="sm:self-end flex-1">Confirm</PrimaryBtn>
                    <SecondaryButton @click="showConfirmPassword = !showConfirmPassword"
                        class="text-indigo-500 font-medium dark:text-indigo-400 flex-1 self-end">Cancel</SecondaryButton>
                </div>
            </form>
        </div>
        <DangerButton v-if="!showConfirmPassword" @click="showConfirmPassword = !showConfirmPassword"
            class="bg-red-500 text-white px-6 py-2 rounded-lg space-x-2">
            <font-awesome-icon icon="triangle-exclamation" />
            <span>Delete Account</span>
        </DangerButton>
    </Container>
</template>