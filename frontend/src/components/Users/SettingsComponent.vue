<template>
    <div v-if="loading">
        <Loading :loading="loading" />
    </div>
    <div v-if="!loading" class="flex flex-col bg-gray-100 items-center py-5">
        <h4 class="mb-5 text-xl  uppercase font-bold">Update account details</h4>
        <form @submit.prevent="updateDetails" class="p-5 rounded-sm bg-gray-200 flex flex-col gap-y-5">
            <div class="flex flex-col gap-1 min-w-[300px]">
                <label class="font-semibold text-xl" for="name">Name</label>
                <input class="p-2 text-md rounded-sm" type="text" name="name" id="name" placeholder="Name"
                    v-model="user.name" required />
            </div>
            <div class="flex flex-col gap-1 min-w-[300px]">
                <label class="font-semibold text-xl" for="email">Email</label>
                <input class="p-2 text-md rounded-sm" type="email" name="email" id="email" placeholder="Email"
                    v-model="user.email" required />
            </div>
            <div class="flex flex-col gap-1 min-w-[300px]">
                <button class="p-2 text-md rounded-sm bg-green-500 text-white font-semibold" type="submit">Update</button>
            </div>
            <ErrorComponent :errors="store.state.usersModule.errors" />
        </form>
        <div class="p-5">
            <button @click="deleteUser(user.id)" class="p-2 text-md rounded-sm bg-red-500  text-white font-semibold">Delete
                Account</button>
        </div>
    </div>
</template>
<script setup>
import ErrorComponent from "../ErrorComponent.vue"
import Loading from "../Loading.vue"

import { ref, onMounted } from "vue"
import { useStore } from "vuex";
import router from "@/router";

const store = useStore()
const loading = ref(false)
const currentDetails = ref({})

const user = ref({
    name: '',
    email: '',
    id: ''
})

const getUser = async () => {
    loading.value = true
    await store.dispatch("authModule/getUser")
    currentDetails.value = store.state.authModule.user
    loading.value = false
    user.value.email = currentDetails.value.email
    user.value.name = currentDetails.value.name
    user.value.id = currentDetails.value.id
}

const updateDetails = async () => {
    loading.value = true
    await store.dispatch("usersModule/updateUser", user.value)

    if (!store.state.usersModule.errors || store.state.usersModule.errors.length === 0) {
        loading.value = false
    }
    loading.value = false
}

const deleteUser = async (id) => {
    loading.value = true
    await store.dispatch("usersModule/deleteUser", id)
    loading.value = false
    router.push('/')
}

onMounted(() => {
    getUser()
})
</script>