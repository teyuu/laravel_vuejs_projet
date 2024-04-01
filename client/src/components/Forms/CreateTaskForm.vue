<script setup>
import {useTaskStore} from '../../stores/task'
import {useUserStore} from '../../stores/user'
import {ref, onMounted} from 'vue'

const taskStore = useTaskStore();
const userStore = useUserStore()
const form = ref({
    title: "",
    description: "",
    user_id:"",
});


const handleTaskCreation  = async () => {
    taskStore.createTask(form.value);
};



onMounted(async () =>{
     userStore.getAllUsers()
})



</script>

<template>
    <div class="container mx-auto flex justify-center items-center mt-5">
        <div class="container bg-white p-8 border rounded shadow-md w-96">
            <h1 class="text-xl font-bold mb-4">Crear Nueva Tarea</h1>
            <form class="space-y-4" @submit.prevent="handleTaskCreation">
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                    <input v-model="form.title" type="text" id="titulo" name="title"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea v-model="form.description" id="descripcion" name="description" rows="3"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                </div>
                <div>
                    <label for="opciones">Selecciona una opción:</label>
                    <select v-model="form.user_id" id="opciones" name="opciones">
                        <option  v-for="user in  userStore.allUsers" :key="user.id" :value="user.id">{{ user.name }}</option>
                    </select>
                </div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Crear Tarea
                </button>
            </form>
        </div>
    </div>
</template>