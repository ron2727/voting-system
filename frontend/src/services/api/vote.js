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

export const getVotes = async (data) => {
    const response = await axios.get(`/api/vote/ballot/${data.user_id}/${data.election_id}`);
    return response.data.data
}

export const getCandidateTotalVotes = async (electionId) => {
    try {
      const response = await axios.get(`/api/vote/total/${electionId}`);
      return response.data.data
    } catch (error) {
      console.log(error)
    }
}