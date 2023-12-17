<template>
    <div v-if="loading">
        <Loading />
    </div>
    <div v-if="!loading">
        <div class="w-full grid grid-cols-2 bg-gray-100 py-2">
            <router-link to="/admins" active-class="bg-gray-300"
                class="text-xl uppercase font-semibold mx-auto cursor-pointer hover:bg-gray-300 px-2 py-1 w-full text-center ">
                View Admins
            </router-link>
            <router-link to="/users"
                class="text-xl uppercase font-semibold mx-auto cursor-pointer hover:bg-gray-300 px-2 py-1 w-full text-center ">
                View Users
            </router-link>
        </div>
        <div v-if="!authorized" class="w-full items-center justify-center py-5 text-center">
            <p>{{ error }}</p>
        </div>
        <div v-if="authorized" class="flex flex-row flex-wrap bg-gray-100 px-5  gap-3 pb-5 justify-center">
            <div v-for="user in users" :key="user.id">
                <div
                    class="flex flex-col rounded-sm bg-gray-200 w-fit min-w-[200px] py-4 px-2  text-center h-fit cursor-pointer hover:shadow-md hover:shadow-green-200 hover:bg-gray-300 transition-all ease">
                    <div>
                        <h4 class="font-semibold text-xl">{{ user.name }}</h4>
                        <p class="text-md font-medium">{{ user.email }}</p>
                    </div>
                    <button v-if="isAdmin && loggedInUser.id !== user.id" @click="removeAdmin(user.admin.id)"
                        class="p-2 mt-3 text-md rounded-sm uppercase bg-green-500 min-w-[80px] text-white font-semibold">Remove
                        from Admins</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import Loading from "@/components/Loading.vue";

import { useStore } from "vuex";
import { ref, onMounted } from "vue";

const store = useStore();
const users = ref([]);
const loading = ref(true);
const loggedInUser = ref({});
const isAdmin = ref(false);
const authorized = ref("");
const error = ref("");

const getAdmins = async () => {
    loading.value = true;
    await store.dispatch("adminsModule/getAdmins");
    error.value = store.state.adminsModule.error;

    if (error.value === "Unauthorized.") {
        authorized.value = false;
    } else {
        authorized.value = true;
        users.value = store.state.adminsModule.admins;
    }

    users.value = store.state.adminsModule.admins;
    loading.value = false;
    console.log(error.value);
};

const getUser = async () => {
    await store.dispatch("authModule/getUser");
    loggedInUser.value = store.state.authModule.user;
    let userRole = loggedInUser.value.role;

    if (userRole === "admin") {
        isAdmin.value = true;
    }
};

const removeAdmin = async (id) => {
    loading.value = true;
    await store.dispatch("adminsModule/removeAdmin", id);
    await getAdmins();
    loading.value = false;
};

onMounted(() => {
    getAdmins();
    getUser();
});
</script>
