<template>
    <nav class="flex flex-row items-center justify-between py-4 px-10 bg-gray-200 relative">
        <router-link class="text-2xl font-bold" to="/"> Home</router-link>
        <div class="items-center flex flex-row relative">
            <div class="items-center flex flex-row" v-if="!loggedIn">
                <router-link to="/login" class="mx-2 px-2 font-semibold text-lg hover:underline">Login</router-link>
                <router-link to="/register" class="mx-2 px-2 font-semibold text-lg hover:underline">Register</router-link>
            </div>
            <div class="items-center flex flex-row relative" v-if="loggedIn">
                <div class="flex flex-row items-center py-1 cursor-pointer" @click="toggleProfile">
                    <h4 class="text-md px-2 font-semibold">{{ user.name }} ({{ user.role }})</h4>
                    <font-awesome-icon :icon="['fas', 'chevron-down']" />
                </div>
                <div v-if="showProfile"
                    class="items-center flex flex-col absolute top-8 right-0 bg-gray-300 px-2 py-2 rounded-sm gap-y-2">
                    <router-link :to="{ name: 'settings', params: { id: user.id } }"
                        class="font-semibold hover:text-green-700 cursor-pointer px-6 hover:bg-gray-100 text-lg">Settings
                    </router-link>
                    <h5 @click="logout"
                        class="font-semibold hover:text-green-700 cursor-pointer px-6 hover:bg-gray-100 text-lg">Logout</h5>
                </div>
            </div>
        </div>
    </nav>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import { useStore } from 'vuex';
import router from '@/router';
import { computed } from 'vue';

const showProfile = ref(false);
const store = useStore();
const user = ref({});
let token = localStorage.getItem('access_token')

const toggleProfile = () => {
    showProfile.value = !showProfile.value;
};


const getUser = async () => {
    loggedIn.value = false;
    await store.dispatch('authModule/getUser')
    user.value = store.state.authModule.user
    if (user.value) {
        loggedIn.value = true
    }
}

const logout = () => {
    loggedIn.value = false
    localStorage.removeItem('access_token')
    store.commit('authModule/setUser', {})
    router.push('/login')
}

const loggedIn = computed(() => {
    if (token) {
        return true
    }
    return false
})

onMounted(() => {
    getUser()
})
</script>  