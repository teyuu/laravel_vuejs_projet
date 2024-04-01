<script setup>
import { onMounted, ref } from "vue";
import { useTaskStore } from "../stores/task";
import { useAuthStore } from "../stores/auth";
import { useUserStore } from "../stores/user";
import { useRoute } from "vue-router";
import CommentsView from "./CommentsView.vue";

const authStore = useAuthStore();
const taskStore = useTaskStore();
const userStore = useUserStore();

const route = useRoute();
const taskId = route.params.id;

const editMode = ref(false);

const taskToEdit = ref({
  id: "",
  title: "",
  description: "",
  status: "",
  user_id: "",
  user_name:""
});

const currentUser = ref(null);

const handleEditTask = () => {
  editMode.value = !editMode.value;

  if (!editMode.value) return;

  taskToEdit.value = { ...taskStore.selectedTask };
};

const handleSubmit = async (taskEdited) => {
  if (editMode) {
    await taskStore.saveEditedTask(taskEdited);
    await taskStore.getTaskById(taskEdited.id);
    editMode.value = false;
  } else {
    editMode.value = false;
  }
};

const handleDeleteTask = async (id) => {
  await taskStore.deleteTask(id);
};

onMounted(async () => {
  await taskStore.getTaskById(taskId);
  await authStore.getUser();
  await userStore.getAllUsers();

  currentUser.value =
    authStore.authUser.rol === "superadmin"
      ? "superadmin"
      : taskStore.selectedTask.user_id === authStore.authUser.id
      ? "assignedUser"
      : "otherUser";
});
</script>

<template >

  <div v-if="currentUser !== null" class="flex flex-col w-full justify-center mt-5">
    <div class="flex justify-center items-center">
    <div class="w-[50%] p-5 border rounded shadow-md ">
      <p class="text-lg font-bold mb-3">Detalles de la Tarea</p>
      <form>
        <div class="mb-3 space-x-5">
          <button
            v-if="
              (!editMode && currentUser === 'superadmin') ||
              currentUser === 'assignedUser'
            "
            type="button"
            @click="handleEditTask"
            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600"
          >
            {{ !editMode ? "Editar" : "Cancelar" }}
          </button>
          <button
            v-if="!editMode && currentUser === 'superadmin'"
            type="button"
            @click="handleDeleteTask(taskId)"
            class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600"
          >
            Eliminar
          </button>

          <button
            v-if="editMode"
            type="button"
            @click="handleSubmit(taskToEdit)"
            class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600"
          >
            Guardar
          </button>
        </div>
        <div class="flex items-centermb-3">
          <label class="w-20 font-semibold">Empleado:</label>
          <div
            v-if="editMode && currentUser === 'superadmin'"
            class="w-full ml-3 mb-3"
          >
            <select v-model="taskToEdit.user_id" id="opciones" name="opciones">
              <option
                v-for="user in userStore.allUsers"
                :key="user.id"
                :value="user.id"
              >
                {{ user.name }}
              </option>
            </select>
          </div>

          <p v-else class="w-full bg-gray-100 p-2 rounded-md">
            {{ taskStore.selectedTask.user.name || "Cargando..." }}
          </p>
        </div>
        <div class="flex items-center mb-3">
          <label class="w-20 font-semibold">Título:</label>
          <div v-if="editMode && currentUser === 'superadmin'" class="w-full">
            <input
              type="text"
              v-model="taskToEdit.title"
              class="input"
              placeholder="Título de la Tarea"
            />
          </div>
          <p v-else class="w-full bg-gray-100 p-2 rounded-md">
            {{ taskStore.selectedTask.title || "Cargando..." }}
          </p>
        </div>
        <div class="flex items-center mb-3">
          <label class="w-20 font-semibold">Descripción:</label>
          <div v-if="editMode && currentUser === 'superadmin'" class="w-full">
            <textarea
              v-model="taskToEdit.description"
              class="border border-gray-300 rounded-md px-4 py-2 resize-none focus:outline-none focus:border-blue-500 shadow-sm w-[80%] ml-4"
              placeholder="Descripción de la Tarea"
            ></textarea>
          </div>
          <p v-else class="w-full bg-gray-100 p-2 rounded-md">
            {{ taskStore.selectedTask.description || "Cargando..." }}
          </p>
        </div>
        <div class="mb-4 flex items-center">
          <label for="estado" class="block text-gray-700 font-semibold mb-2"
            >Estado:</label
          >
          <div
            v-if="
              editMode && (currentUser === 'superadmin' ||
              currentUser === 'assignedUser')
            "
            class="w-full"
          >
            <select
              name="estado"
              id="estado"
              v-model="taskToEdit.status"
              class="appearance-none border rounded-md py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500"
            >
              <option value="pendiente" class="text-gray-900">Pendiente</option>
              <option value="en_proceso" class="text-yellow-600">
                En Proceso
              </option>
              <option value="bloqueado" class="text-red-600">Bloqueado</option>
              <option value="completado" class="text-green-600">
                Completado
              </option>
            </select>
          </div>
          <p
            v-if="!editMode"
            class="ml-5 text-white px-3 py-4"
            :class="{
              'bg-slate-400  ': taskStore.selectedTask.status === 'pendiente',
              'bg-yellow-400 ': taskStore.selectedTask.status === 'en_proceso',
              'bg-red-400 ': taskStore.selectedTask.status === 'bloqueado',
              'bg-green-400 ': taskStore.selectedTask.status === 'completado',
            }"
          >
            {{
              taskStore.selectedTask.status
                ? taskStore.selectedTask.status.charAt(0).toUpperCase() +
                  taskStore.selectedTask.status.slice(1).replace(/-/g, " ")
                : ""
            }}
          </p>
        </div>
      </form>
    </div>
  </div>


    <!-- Realizar comentario -->
    <div class="flex flex-col justify-center items-center mt-5 mb-5">
      <span class="mb-2">Realizar un Comentario</span>
      <CommentsView />
    </div>
  </div>
  <div v-else class="flex justify-center items-center h-screen">
    <div class="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 border-gray-900"></div>
</div>
</template>