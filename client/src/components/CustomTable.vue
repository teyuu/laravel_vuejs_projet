<script setup>
import { defineProps } from "vue";

const props = defineProps({
  tasks: { type: Array, required: true },
});
</script>
<template>
 
  <div class="overflow-x-auto">
    <table class="table-auto w-full border-collapse border border-gray-200">
      <thead>
        <tr class="bg-gray-100">
          <th class="px-4 py-2">Empleado</th>
          <th class="px-4 py-2">Tarea</th>
          <th class="px-4 py-2">Descripción</th>
          <th class="px-4 py-2">Adjunto</th>
          <th class="px-4 py-2">Estado</th>
          <th class="px-4 py-2">Ver más</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(task, index) in tasks"
          :key="index"
          class="hover:bg-gray-50 transition-colors duration-300"
        >
          <td class="border px-4 py-2">{{ task.user_name || task.user?.name  }}</td>
          <td class="border px-4 py-2">{{ task.title }}</td>
          <td class="border px-4 py-2">{{ task.description }}</td>
          <td class="border px-4 py-2">
            <a
              :href="task.attachment"
              target="_blank"
              class="text-blue-500 underline"
              >Ver Adjunto</a
            >
          </td>
          <td
            class="border px-4 py-2"
            :class="{
              'bg-slate-400': task.status === 'pendiente',
              'bg-yellow-400': task.status === 'en_proceso',
              'bg-red-400': task.status === 'bloqueado',
              'bg-green-400': task.status === 'completado',
            }"
          >
            {{
              task.status.charAt(0).toUpperCase() +
              task.status.slice(1).replace("_", " ")
            }}
          </td>
          <td class="border px-4 py-2">
            <router-link
              :to="{ name: 'TaskDetails', params: { id: task.id } }"
              class="text-blue-500 underline"
              >Ver más</router-link
            >
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
  
  