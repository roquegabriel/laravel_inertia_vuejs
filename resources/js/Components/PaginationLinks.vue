<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({ paginator: Object })

const makeLabel = (label) => {
    if (label.includes("Previous")) {
        return "<<"
    } else if (label.includes("Next")) {
        return ">>"
    } else {
        return label
    }
}

</script>
<template>
    <div class="flex flex-col items-start lg:flex-row justify-between lg:items-center gap-3">
        <div class="flex items-center flew-wrap rounded-md overflow-hidden shadow-md">
            <div v-for="(link, index) in paginator.links" :key="index">
                <component :is="link.url ? Link : 'span'" :href="link.url" v-html="makeLabel(link.label)"
                    class="border-x border-slate-50 size-7  sm:size-12 grid place-items-center bg-white dark:bg-slate-900 dark:border-slate-800"
                    :class="{ 'hover:bg-slate-300 dark:hover:bg-slate-500': link.url, 'text-slate-300': !link.url, 'font-bold text-indigo-500 dark:text-indigo-400': link.active, }"
                    preserve-scroll />
            </div>
        </div>
        <p class="text-slate-600 dark:text-slate-400 text-sm">Showing {{ paginator.from }} to {{ paginator.to }} of {{
            paginator.total }} results.</p>
    </div>
</template>