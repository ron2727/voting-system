import axios from "axios";
import { ref } from "vue";

export const getCandidatesFromElection = async (electionId) => { 
    try {
        const response = await axios.get(`/api/candidates/${electionId}`);
        return response.data;
    } catch (error) {
        console.error(error);
    }
}


export const storeCandidate = async (data) => {
    const requestResponse = ref(null)
    const errors = ref(null) 
    try {
        const response = await axios.post('/api/candidates', data);
        requestResponse.value = response
    } catch (error) {
        errors.value = error.response.data.errors
        console.log(error)
    }

    return { requestResponse, errors }
}