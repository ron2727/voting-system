import axios from "axios"; 
import { ref } from "vue";

export const getVoters = async (url = '/api/voters') => { 
    const response = await axios.get(url);
    return response.data
}
export const getVoter = async (voterId) => { 
    const response = await axios.get(`/api/voters/${voterId}`);
    return response.data
}
export const getRandomVoters = async () => {
    const response = await axios.get('/api/voters/random');
    return response.data.data
}

export const searchVoters = async (search) => {
    const response = await axios.get(`/api/voters/find/${search}`);
    if (response.data?.message) {
        return response.data
    }
    return response.data.data
}

export const storeVoter = async (data) => {
   const requestResponse = ref(null)
    const errors = ref(null) 
    try {
        const response = await axios.post('/api/voters', data);
        requestResponse.value = response
    } catch (error) {
        errors.value = error.response.data.errors
        console.log(error)
    }

    return { requestResponse, errors }
}

export const updateVoter = async (data, voterId) => {
    const requestResponse = ref(null)
     const errors = ref(null) 
     try {
         const response = await axios.post(`/api/voters/update/${voterId}`, data);
         requestResponse.value = response
     } catch (error) {
         errors.value = error.response.data.errors
         console.log(error)
     }
 
     return { requestResponse, errors }
 }

 export const deleteVoter = async (voterId) => { 

        const response = await axios.delete(`/api/voters/${voterId}`);
        return response.data
 }

 export const getTotalVoters = async () => {
    try {
      const response = await axios.get(`/api/voters/total`);
      return response.data
    } catch (error) {
      console.log(error)
    }
  }