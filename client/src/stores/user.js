import { defineStore } from "pinia";
import axios from "axios";

export const useUserStore = defineStore("user", {
    state: () => ({
        allUsers: [],
        userTasks: [],
    }),
    getters: {
        users: (state) => state.allUsers,
        tasksByUser: (state) => state.userTasks,
    },
    actions: {
        async getToken() {
            try {
                await axios.get("/sanctum/csrf-cookie");
            } catch (error) {
                console.error("Error fetching CSRF token:", error);
                throw error; // Rethrow the error to handle it in the calling code
            }
        },
        
        async getAllUsers() {
            try {
                await this.getToken(); // Ensure CSRF token is fetched first
                const response = await axios.get('/api/users');
                this.allUsers = response.data;
            } catch (error) {
                console.error("Error fetching users:", error);
                throw error; // Rethrow the error to handle it in the calling code
            }
        },
        async getUserTasks(user_id){
            
            try{

                const response = await axios.get(`api/tasks/user/${user_id}`)
                if(response.status === 200){
                    this.userTasks = response.data
                    console.log('Tareas por usuario cargadas correctamente')
                }

            }catch(error){
                console.log(error)
            }
        }
    }
})