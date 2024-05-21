import axios from "axios"; 
import { ref } from "vue";

export const storeVote = async (data) => {
    const requestResponse = ref(null)
     const errors = ref(null) 
     try {
          const response = await axios.post('/api/vote', data);
          requestResponse.value = response
     } catch (error) {
          errors.value = error.response.data.errors
          console.log(error)
     }  

     return { requestResponse, errors }
}

export const getVotes = async () => {
    const response = await axios.get('/api/vote');
    return response.data.data
}