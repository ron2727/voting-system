import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {  
    state: () => ({
        authUser: null,
        authErrors: []
    }),
    getters: {
        user: (state) => state.authUser,
        errors: (state) => state.authErrors
    },
    actions: {
        async getToken() {
           await axios.get('/sanctum/csrf-cookie')
        },
        async getAuthUser() {
            try {
               const response = await axios.get("/api/user");
               this.authUser = response.data.data;
            } catch (error) { 
                console.error(error);
            }
        },
        async handleLogin(data) {
            this.authUser = null;
            this.authErrors = [];
            await this.getToken(); 
            try {
                const response = await axios.post("/login", data); 
                this.authUser = response.data.user;
                this.router.push('/dashboard');
            } catch (error) {
                if(error.response.status === 422) {
                    this.authErrors = error.response.data.errors;
                }
                console.error(error);
            }   
        },
        async handleRegister(data){
            this.authUser = null;
            this.authErrors = [];
            await this.getToken();
            try {
                const response = await axios.post("/register", data);
                this.authUser = response.data.user;
                this.router.push('/dashboard');
            } catch (error) {
                if(error.response.status === 422) {
                    this.authErrors = error.response.data.errors;
                }
                console.error(error);
            }
        },
        async handleLogout() {
            await axios.post('/logout');
            this.authUser = null;
            this.router.push('/');
        }, 

        async handleChangePassword(data){ 
            this.authErrors = [];
            await this.getToken();
            try {
                await axios.post("/change-password", data);  
            } catch (error) {
                if(error.response.status === 422) {
                    this.authErrors = error.response.data.errors;
                }
                console.error(error);
            }
        },

    }
});