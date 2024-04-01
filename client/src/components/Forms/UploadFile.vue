<script setup>
import { ref, defineProps } from 'vue';
import { useTaskStore } from '../../stores/task';


const taskStore = useTaskStore()

const props = defineProps({
    taskId: String // Prop type: String (other types like Number, Boolean, etc. are also possible)
});

const fileInput = ref(null);
const fileData = ref({
    name: '',
    type: '',
    size: '',
    task_id: `${props.taskId}`
})

const handleChange = () => {

    fileData.value.name = fileInput.value.files[0].name
    fileData.value.type = fileInput.value.files[0].type
    fileData.value.size = fileInput.value.files[0].size
}


const handleSubmit = () => {
    const files = fileInput.value.files;
    if (files.length > 0) {
        const formData = new FormData();
        Array.from(files).forEach(file => formData.append('file', file));
        formData.append('task_id', props.taskId);
        taskStore.uploadFile(formData)
    }

    console.error("No se cargo ningun archivo")
};

</script>

<template>
    <div class="p-4">
        <p>{{ fileData }}</p>
        <h2 class="text-lg font-semibold mb-2">Subir Archivos</h2>
        <form @submit.prevent="handleSubmit">
            <input type="file" ref="fileInput" @change="handleChange" multiple class="mb-2" />
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Subir Archivos
            </button>
        </form>
    </div>
</template>