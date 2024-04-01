<script setup>
  import { ref, onMounted, defineProps } from "vue";
  import { useCommentStore } from "../stores/comment";
  import { useAuthStore } from "../stores/auth";

  const authStore = useAuthStore();
  const commentStore = useCommentStore();
  const props = defineProps({
    comment: {
      type: Object,
      required: true,
      default: () => ({
        user_name: "",
        comment: "",
        id: "", 
        task_id: "", 
        user_id: "", 
      }),
    },
  });

  const currentUser = ref('');
  const editMode = ref(false);
  const editedComment = ref({ ...props.comment });
  const currentCommentData = ref({ ...props.comment });

  const editComment = () => {
    editMode.value = !editMode.value;
  };

  const saveComment = async (data) => {
    await commentStore.editComment(data);
    await commentStore.getCommentsByTask(data.task_id);
    editMode.value = false;
  };

  const handleDeleteComment = async (comment_id, task_id) => {
    const confirmDelete = window.confirm("¿Estás seguro de que deseas eliminar este comentario?");
    if (confirmDelete) {
      await commentStore.deleteComment(comment_id);
      await commentStore.getCommentsByTask(task_id);
    }
  };

  onMounted(async () => {
    await authStore.getUser();
    currentUser.value = authStore.authUser.rol === 'superadmin' ? 'superadmin' : currentCommentData.value.user_id ===  authStore.authUser.id ? 'userAuthor' : 'otherUser';
  });
</script>


<template>
 <form
    @submit.prevent="saveComment(currentCommentData)"
    class=" p-5 border rounded shadow-md"
  >
    <div class="mb-4">
      <label for="name" class="block text-sm font-medium text-gray-700"
        >Nombre:</label
      >
      <p>{{ comment.user_name }}</p>
    </div>
    <div class="mb-4">
      <label for="comment" class="block text-sm font-medium text-gray-700"
        >Comentario:</label
      >
      <p v-if="!editMode">{{ comment.comment }}</p>
      <textarea
        v-else
        v-model="currentCommentData.comment"
        id="comment"
        name="comment"
        rows="5"
        class="mt-1 p-2 border-gray-300 rounded-md w-full"
        required
      ></textarea>
    </div>
    <div class="flex space-x-2 mt-2">
      <!-- Botones de edición y eliminación -->
      <button
        v-if="!editMode  && (currentUser === 'superadmin' || currentUser === 'userAuthor') "
        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600"
        type="button"
        @click="editComment(currentCommentData)"
      >
        {{ editMode ? "Cancelar" : "Editar" }}
      </button>
      <button
      
        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600"
        type="button"
        v-if="!editMode && currentUser === 'superadmin' || currentUser === 'userAuthor'  "
        @click="handleDeleteComment(currentCommentData.id, currentCommentData.task_id)"
      >
        Eliminar
      </button>

      <button
        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600"
        type="submit"
        v-if="editMode"
      >
        Guardar
      </button>
    </div>
  </form>
</template>