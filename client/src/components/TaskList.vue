<script setup>
import { onMounted, ref } from 'vue'
import { useTaskStore } from '../stores/task'
import { useAuthStore } from '../stores/auth'
import { useUserStore } from '../stores/user'
import CustomTable from './CustomTable.vue'

const authStore = useAuthStore()
const taskStore = useTaskStore()
const userStore = useUserStore()

const currentUser = ref(null)

const taskToEdit = ref({
    id: null,
    title: '',
    description: '',
    status: ''
})



onMounted(async () => {
    currentUser.value = authStore.authUser.rol === 'employee' ? 'employee' : 'superadmin'
    await taskStore.getAllTasks()
    const userId = authStore.authUser.id
    await userStore.getUserTasks(userId)

})
</script>



<template>
  <div class="container mx-auto px-4 py-8" v-if="currentUser === 'employee'">
    <span class="text-center text-2xl font-bold">Mis tareas</span>
    <CustomTable v-if="userStore.userTasks.length > 0" :tasks="userStore.userTasks" />
    <p v-else>No se encontraron tareas pendientes</p>
  </div>

  <div class="container mx-auto px-4 py-8">
    <span class="text-2xl font-bold mb-4">Lista de Tareas</span>
    <CustomTable :tasks="taskStore.allTasks" />
  </div>
</template>