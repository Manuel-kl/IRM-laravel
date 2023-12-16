<template>
    <div class="w-full flex flex-col justify-center items-center py-6 bg-gray-50">
        <div
            class="flex flex-col rounded-sm gap-y-1 bg-gray-200 w-fit min-w-[200px] py-4 px-2  text-center h-fit cursor-pointer hover:shadow-md hover:shadow-green-200 hover:bg-gray-300 transition-all ease">
            <h4 class="font-semibold text-2xl">{{ user.name }}</h4>
            <p class="text-lg font-medium">{{ user.email }}</p>
            <p class="text-md">
                Added on: <span class="font-semibold">{{ user.created_at }}</span>
            </p>
        </div>
        <div class="flex flex-row gap-x-2 mt-5">
            <button class="p-2 text-md rounded-sm bg-green-500 min-w-[80px] text-white font-semibold">Edit</button>
            <button class="p-2 text-md rounded-sm bg-red-500 min-w-[80px] text-white font-semibold">Delete</button>
        </div>
    </div>
</template>
<script setup>
import { useStore } from "vuex";
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

const store = useStore();
const user = ref({});
const loading = ref(true);
const route = useRoute();

const getUser = async () => {
    loading.value = true;
    let id = route.params.id;
    await store.dispatch("usersModule/getUser", id);
    user.value = store.state.usersModule.user;
    console.log(user.value);
    loading.value = false;
};

onMounted(() => {
    getUser();
});
</script>