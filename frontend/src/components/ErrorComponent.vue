<template>
    <div class="flex flex-col gap-2">
        <p v-if="error" class="text-sm text-red-800 bg-red-50 w-fit min-w-[50%] px-2 rounded-sm ">{{ error }}</p>
        <div v-for="(errorArray, index) in errors" :key="index" class="flex flex-col gap-2">
            <p v-for="(errorMessage, innerIndex) in errorArray" :key="innerIndex"
                class="text-sm text-red-800 bg-red-50 w-fit min-w-[50%] px-2 rounded-sm">
                {{ errorMessage }}
            </p>
        </div>
    </div>
</template>
<script setup>
const props = defineProps({
    errors: Array,
    error: String
})
</script>
