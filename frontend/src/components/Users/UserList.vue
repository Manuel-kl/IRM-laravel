<template>
    <div v-if="loading">
        <Loading />
    </div>
    <div v-if="!loading">
        <div class="w-full grid grid-cols-2 bg-gray-100 py-2">
            <h5
                class="text-xl uppercase font-semibold mx-auto cursor-pointer hover:bg-gray-300 px-2 py-1 w-full text-center ">
                View Admins
            </h5>
            <h5
                class="text-xl uppercase font-semibold mx-auto cursor-pointer hover:bg-gray-300 px-2 py-1 w-full text-center ">
                View Users
            </h5>
        </div>
        <div class="flex flex-row flex-wrap bg-gray-100 px-5  gap-3 pb-5 justify-center">
            <div v-for="user in users" :key="user.id">
                <div @click="viewUser(user.id)"
                    class="flex flex-col rounded-sm bg-gray-200 w-fit min-w-[200px] py-4 px-2  text-center h-fit cursor-pointer hover:shadow-md hover:shadow-green-200 hover:bg-gray-300 transition-all ease">
                    <h4 class="font-semibold text-xl">{{ user.name }}</h4>
                    <p class="text-md font-medium">{{ user.email }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import Loading from "@/components/Loading.vue";

import { useRouter } from "vue-router";
import { useStore } from "vuex";
import { ref, onMounted } from "vue";

const store = useStore();
const router = useRouter();
const users = ref([]);
const loading = ref(true);

const viewUser = (id) => {
    router.push({ name: "view-user", params: { id: id } });
};

const getUsers = async () => {
    loading.value = true;
    await store.dispatch("usersModule/getUsers");
    users.value = store.state.usersModule.users;
    loading.value = false;
};

onMounted(() => {
    getUsers();
});
</script>