<template>
    <div v-if="loading">
        <Loading :loading="loading" />
    </div>
    <div v-if="!loading" class="flex flex-col bg-gray-100 items-center py-5">
        <h4 class="mb-5 text-xl  uppercase font-bold">Login</h4>
        <form @submit.prevent="login" class="p-5 rounded-sm bg-gray-200 flex flex-col gap-y-5">
            <div class="flex flex-col gap-1 min-w-[300px]">
                <label class="font-semibold text-xl" for="email">Email</label>
                <input class="p-2 text-md rounded-sm" type="email" name="email" id="email" placeholder="Email" required
                    v-model="user.email" />
            </div>
            <div class="flex flex-col gap-1 min-w-[300px]">
                <label class="font-semibold text-xl" for="password">Password</label>
                <input class="p-2 text-md rounded-sm" type="password" name="password" id="password" required
                    v-model="user.password" placeholder="Password" />
            </div>
            <div class="flex flex-col gap-1 min-w-[300px]">
                <button class="p-2 text-md rounded-sm bg-green-500 text-white font-semibold" type="submit">Login</button>
            </div>
        </form>
        <ErrorComponent :errors="store.state.authModule.errors" :error="loginError" />
    </div>
</template>
<script setup>
import router from '@/router';
import ErrorComponent from '../ErrorComponent.vue';
import Loading from '../Loading.vue';

import { ref } from 'vue';
import { useStore } from 'vuex';

const loginError = ref('');
const store = useStore();
const loading = ref(false);

const user = ref({
    email: '',
    password: '',
});

const login = async () => {
    loading.value = true;
    await store.dispatch('authModule/login', user.value);
    loginError.value = store.state.authModule.error

    if (!loginError.value) {
        router.push('/')
    }
    loading.value = false;
};
</script>