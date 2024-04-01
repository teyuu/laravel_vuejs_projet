import { createRouter, createWebHistory } from "vue-router";

import Home from "../components/Home.vue";

const routes = [
  { path: "/", name: "Home", component: Home },
  {
    path: "/login",
    name: "Login",
    component: () => import("../components/Login.vue"),
  },
  {
    path: "/register",
    name: "Register",
    component: () => import("../components/Register.vue"),
  },
  {
    path: "/forgot-password",
    name: "ForgotPassword",
    component: () => import("../components/ForgotPassword.vue"),
  },
  {
    path: "/password-reset/:token",
    name: "ResetPassword",
    component: () => import("../components/ResetPassword.vue"),
  },
  {
    path: "/tareas",
    name: "Tareas",
    component: () => import("../components/TaskList.vue"),
  },
  {
    path: '/tarea/:id', // Define una ruta dinámica con el parámetro ":id"
    name: 'TaskDetails',
    component: () => import("../components/TaskDetail.vue"),
  },
  {
    path: '/tarea/editar/:id', 
    name: 'EditTask',
    component: () => import("../components/EditTaskDetail.vue"),
  }  ,
  {
    path: "/crear-teareas",
    name: "CrearTarea",
    component: () => import("../components/Forms/CreateTaskForm.vue"),
  },

];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;