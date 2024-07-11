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
        console.log(error);
    }
}
 

export const updateElection = async (data, electionId) => {
    const requestResponse = ref(null)
    const errors = ref(null) 
    try {
        const response = await axios.put(`/api/elections/${electionId}`, data);
        requestResponse.value = response
    } catch (error) {
        errors.value = error.response.data.errors
        console.log(error)
    }

    return { requestResponse, errors }
}


export const getFilteredElection = async (status) => { 
    try {
        const response = await axios.get(`/api/elections/filtered/${status}`);
        return response.data;
    } catch (error) {
        console.log(error.data);
    }
}

export const getElectionByMonthYear = async (month, year) => { 
    try {
        const response = await axios.get(`api/elections/report/search/${month}/${year}`);
        return response.data;
    } catch (error) {
        console.log(error.data);
    }
}

