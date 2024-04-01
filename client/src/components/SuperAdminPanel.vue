<script setup>
import TaskList from './TaskList.vue';
import { useAuthStore } from '../stores/auth'
import { useUserStore } from '../stores/user'
const authStore = useAuthStore()

import CreateTaskForm from './Forms/CreateTaskForm.vue'

</script>

<template>
    <div class="h-screen">
        <div class="container mx-auto flex flex-col justify-center items-center mt-5">
            <h2 class="text-3xl">Bienvenido {{ authStore.user?.name }}</h2>
            <TaskList/>
        </div>
    </div>
</template>