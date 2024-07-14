<template>
    <BackButton path="/dashboard/results/elections" />
    <Loader size="md" v-if="isLoading" />
    <div class="wrapper mt-4" v-else>
        <h1 class=" py-3 font-bold text-sm md:text-lg">Candidates that won the election</h1>
        <div ref="candidatesList" class=" grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
            <div v-if="candidatesWinners" v-for="candidateWinner in candidatesWinners"
                class="candidate relative h-min border bg-white rounded-2xl cursor-pointer p-1 ">
                <img :src="candidateWinner?.user?.profile_image" alt="a"
                    class=" w-full object-cover border rounded-2xl">
                <div class="px-1 py-2">
                    <h6 class=" text-sm md:text-lg font-bold">{{ candidateWinner?.user?.firstname }} {{
                        candidateWinner?.user?.lastname }}</h6>
                    <small class=" text-xs md:text-sm text-gray-500">{{ candidateWinner?.user?.course }} {{
                        candidateWinner?.user?.year_level}}</small><br>
                    <small class=" text-xs md:text-sm text-gray-500">{{ candidateWinner?.position }}</small>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Loader from '../../../components/common/Loader.vue';
import BackButton from '../../../components/common/BackButton.vue';
import { useRoute } from 'vue-router'; 
import { getElectionVotes } from '../../../services/api/vote'
import { onBeforeMount, ref } from 'vue';

const route = useRoute();
const isLoading = ref(true);
const candidatesWinners = ref([])
onBeforeMount(async () => {
    const data = await getElectionVotes(route.params.electionId)    
    console.log(data)
    candidatesWinners.value = getElectionCandidatesWinner(data)
    isLoading.value = false
})

const getElectionCandidatesWinner = (candidates) => {
    
    for (const position in candidates) { 
        if (candidates[position].candidates.length > 1) {
           const winner = {
              id: 0,
              votes: 0,
           } 
           candidates[position].candidates.forEach(candidate => {
              if (candidate.votes > winner.votes) {
                 winner.id = candidate.id
                 winner.votes = candidate.votes
              }
           })
           candidates[position].candidates.forEach(candidate => {
              if (candidate.id === winner.id) {
                candidates[position] = candidate  
              }
           })
        }else{
            candidates[position] = candidates[position].candidates[0]
        }
    }

    return candidates;
}
</script> 