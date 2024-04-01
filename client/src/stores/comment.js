import { defineStore } from "pinia";
import axios from "axios";

export const useCommentStore = defineStore("comment", {
    state: () => ({
        commentsByTask: [],
    }),

    getters: {
        comments: (state) => state.commentsByTask,
    },

    actions: {
        async getToken() {
            await axios.get("/sanctum/csrf-cookie");
        },

        async getCommentsByTask(taskId) {
            await this.getToken()
            try {
                const response = await axios.get(`/api/comments/${taskId}`)
                const data = response.data
                if (response.status == 200) {
                    console.log("Comentario realizado correctamente", data)
                    this.commentsByTask = response.data
                }
            } catch (error) {
                console.log(error.message)
            }
        },
        async createComment (data){
            await this.getToken()
            try {
                const response = await axios.post('/api/comments', data)
                if (response.status == 200) {
                    alert("Comentario realizado correctamente")
                }
            } catch (error) {
                console.log(error.message)
            }
        },
        async editComment(comment){
            this.getToken()
            try {
                const response = await axios.put(`/api/comments/${comment.id}`, comment)
                const data = response.data
                if (response.status === 200) {
                    console.log('Task edited successfully', data );
                }
            } catch (error) {
                console.error("Error deleting task:", error);
            }
        },
        async deleteComment(comment_id) {
            await this.getToken();
            try {
                const response = await axios.delete(`/api/comments/${comment_id}`);
                if (response.status === 200) {
                  alert('Task deleted successfully');
                } else {
                    console.log('Error deleting task');
                }
            } catch (error) {
                console.error("Error deleting task:", error);
            }
        },
        
    }
});
