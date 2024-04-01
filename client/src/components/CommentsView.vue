<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import { useTaskStore } from "../stores/task";
import { useAuthStore } from "../stores/auth";
import { useCommentStore } from "../stores/comment";
import Comment from "./Comment.vue";

const route = useRoute();
const taskId = route.params.id;
const taskStore = useTaskStore();
const authStore = useAuthStore();
const commentStore = useCommentStore();
const editMode = ref(false);

const commentData = ref({
  comment: "",
  task_id: "",
  user_id: "",
});

const editComment = () => {
  editMode.value = !editMode.value;
  if (!editMode.value) return;

  commentData.value.comment = taskStore.selectedTask.id;
  commentData.value.task_id = taskStore.selectedTask.title;
  commentData.value.user_id = taskStore.selectedTask.description;
};

const submitComment = async (data) => {
  await commentStore.createComment(data);
  await commentStore.getCommentsByTask(taskId);

  commentData.value.comment = "";
};

const toggleEditing = () => {
  editMode.value = true;
};

const submitEditedComment = () => {
  editMode.value = false;
};

onMounted(async () => {
  await taskStore.getTaskById(taskId);
  await authStore.getUser();
  await commentStore.getCommentsByTask(taskId);

  commentData.value.task_id = taskStore.selectedTask.id;
  commentData.value.user_id = authStore.authUser.id;
});
</script>


<template>
  <div class="bg-gray-100 p-4 rounded-lg w-[50%] mt-5">
    <form @submit.prevent="submitComment(commentData)">
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700"
          >Nombre:</label
        >
        <p
          type="text"
          id="name"
          name="name"
          class="mt-1 p-2 border-gray-300 rounded-md w-full"
        >
          {{ authStore.authUser?.name }}
        </p>
      </div>
      <div class="mb-4">
        <label for="comment" class="block text-sm font-medium text-gray-700"
          >Comentario:</label
        >
        <textarea
          v-model="commentData.comment"
          id="comment"
          name="comment"
          rows="3"
          class="mt-1 p-2 border-gray-300 rounded-md w-full"
          required
        ></textarea>
      </div>
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
        Enviar comentario
      </button>
    </form>
  </div>

  <!-- Lista de COMENTARIOS -->
  <div class="bg-gray-100 p-4 rounded-lg w-[50%] mt-5">
    <h2 class="text-lg font-semibold mb-4">Lista de Comentarios</h2>
    <div class="flex flex-col gap-5">
      <Comment
        v-for="comment in commentStore.commentsByTask"
        :key="comment.id"
        :comment="comment"
      />
    </div>
  </div>
</template>