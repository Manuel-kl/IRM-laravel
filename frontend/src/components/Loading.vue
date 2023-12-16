<template>
    <div v-if="loading" class="w-full bg-sky-50  flex items-center justify-center h-[80vh]">
        <img class="h-20 w-20" src="../assets/loading.gif" alt="loading gif">
    </div>
</template>
<script setup>
import { ref } from 'vue';

const loading = ref(true);

const props = defineProps({
    loading: {
        type: Boolean,
        default: false
    }
})


</script>