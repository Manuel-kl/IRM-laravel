<template>
    <div v-if="loading">
        <Loading :loading="loading" />
    </div>
    <div v-if="!loading" class="flex flex-col bg-gray-100 items-center py-5">
        <h4 class="mb-5 text-xl  uppercase font-bold">Create an account</h4>
        <form @submit.prevent="registerNewUser" class="p-5 rounded-sm bg-gray-200 flex flex-col gap-y-5">
            <div class="flex flex-col gap-1 min-w-[300px]">
                <label class="font-semibold text-xl" for="name">Name</label>
                <input class="p-2 text-md rounded-sm" type="text" name="name" id="name" placeholder="Name"
                    v-model="user.name" />
            </div>
            <div class="flex flex-col gap-1 min-w-[300px]">
                <label class="font-semibold text-xl" for="email">Email</label>
                <input class="p-2 text-md rounded-sm" type="email" name="email" id="email" placeholder="Email"
                    v-model="user.email" />
            </div>
            <div class="flex flex-col gap-1 min-w-[300px]">
                <label class="font-semibold text-xl" for="password">Password</label>
                <input class="p-2 text-md rounded-sm" type="password" name="password" id="password" placeholder="Password"
                    v-model="user.password" />
            </div>
            <div class="flex flex-col gap-1 min-w-[300px]">
                <button class="p-2 text-md rounded-sm bg-green-500 text-white font-semibold" type="submit">Register</button>
            </div>
        </form>
        <ErrorComponent :errors="store.state.authModule.errors" />
    </div>
</template>
<script setup>
import ErrorComponent from "../ErrorComponent.vue"
import router from "@/router";
import Loading from "../Loading.vue"

import { ref } from "vue"
import { useStore } from "vuex";

const store = useStore()
const loading = ref(false)

const user = ref({
    name: "",
    email: "",
    password: "",
})

const registerNewUser = async () => {
    loading.value = true
    await store.dispatch("authModule/register", user.value)

    if (!store.state.authModule.errors || store.state.authModule.errors.length === 0) {
        loading.value = false
        router.push('/')
    }
    loading.value = false
}
</script>