import { defineStore } from "pinia";
import axios from "axios";

export const useTaskStore = defineStore("task", {
    state: () => ({
        allTasks: [],
        selectedTask: []
    }),

    getters: {
        tasks: (state) => state.allTasks,
        taskDetail: (state) => state.selectedTask,
    },

    actions: {
        async getToken() {
            await axios.get("/sanctum/csrf-cookie");
        },

        async getAllTasks() {
            await this.getToken();
            try {
                const response = await axios.get("/api/tasks");
                this.allTasks = response.data;
            } catch (error) {
                console.error("Error fetching tasks:", error);
            }
        },
        async getTaskById(id) {
            await this.getToken();
            try {
                const response = await axios.get(`/api/tasks/${id}`);
                this.selectedTask = response.data;
            } catch (error) {
                console.error("Error fetching tasks:", error);
            }
        },
        async createTask(form) {
            const { title, description, user_id } = form;

            if (!title || !description || !user_id) {
                console.error("Please fill in all fields");
                return;
            }

            try {
                await axios.get("/sanctum/csrf-cookie"); // Get CSRF token

                const response = await axios.post('api/tasks', {
                    title,
                    description,
                    user_id
                });

                console.log("Task created successfully:", response.data);
                this.router.push('/')
            } catch (error) {
                console.error("Error creating task:", error);
            }
        },
        async saveEditedTask(taskToEdit) {
            this.getToken()
            try {
                const response = await axios.put(`/api/tasks/${taskToEdit.id}`, taskToEdit)
                const data = response.data
                if (response.status === 200) {
                    console.log('Task edited successfully', data);
                }
            } catch (error) {
                console.error("Error deleting task:", error);
            }
        },
        async deleteTask(task_id) {
            await this.getToken();
            try {
                const response = await axios.delete(`/api/tasks/${task_id}`);
                if (response.status === 200) {
                    console.log('Task deleted successfully');
                    this.router.push("/")
                } else {
                    console.log('Error deleting task');
                }
            } catch (error) {
                console.error("Error deleting task:", error);
            }
        },
        async uploadFile(formData) {
            this.getToken()

            try {

                const response = await axios.post('/api/files', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })

                console.log(response.data)

            } catch (error) {
                console.log(error.message)
            }
        }
    }
});
