import axios from "axios";
import { ref } from "vue";

export const getElections = async () => { 
    try {
        const response = await axios.get('/api/elections');
        return response.data;
    } catch (error) {
        console.error(error);
    }
}

export const storeElection = async (data) => {
     const requestResponse = ref(null)
     const errors = ref(null) 
     try {
         const response = await axios.post('/api/elections', data);
         requestResponse.value = response
     } catch (error) {
         errors.value = error.response.data.errors
         console.log(error)
     }
 
     return { requestResponse, errors }
}

export const getElection = async (id) => { 
    try {
        const response = await axios.get(`/api/election/${id}`);
        return response.data;
    } catch (error) {
        console.error(error);
    }
}