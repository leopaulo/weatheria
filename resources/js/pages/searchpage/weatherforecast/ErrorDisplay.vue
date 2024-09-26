<template>
    <div class="flex mx-auto w-full max-w-2xl p-5 flex-wrap">
        <div class="flex flex-wrap flex-col justify-end px-7 flex-grow">
            <div class="text-5xl capitalize">{{ route.params.city }},</div>
            <div class="flex flex-row text-lg opacity-60">
                <div class="pt-2">Weather info unavailable.</div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useRoute } from "vue-router";

let route = useRoute();
</script>
