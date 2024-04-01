<script setup>
import  {onMounted } from 'vue'
import { useAuthStore } from '../stores/auth'
import SuperAdminPanel from './SuperAdminPanel.vue'
const authStore = useAuthStore()


onMounted(async ()=>{
   
    await authStore.getUser();

})

 console.log
</script>

<template>
    <div v-if="authStore.user">
        <SuperAdminPanel/>
    </div>
    <div class="h-screen w-full flex flex-col items-center justify-center" v-else>
      <p class="uppercase text-3xl">Inicie sesión para continuar</p>
      <router-link to="/login" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Iniciar Sesión</router-link>
    </div>
</template>