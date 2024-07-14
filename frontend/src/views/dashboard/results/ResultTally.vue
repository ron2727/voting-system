<template>
    <BackButton path="/dashboard/results" />
    <Loader size="md" v-if="isLoading" />
    <CandidateVotesList v-else v-for="(candidates, position) in candidatesWithTotalVotes" :candidates="candidates.candidates" :totalVotes="candidates.totalVotes" :title="position" />
</template>

<script setup> 
import Loader from '../../../components/common/Loader.vue';
import CandidateVotesList from '../../../components/common/CandidateVotesList.vue'; 
import BackButton from '../../../components/common/BackButton.vue';
import { ref, onMounted, onBeforeMount, provide } from 'vue';
import { useRoute } from 'vue-router';
import { useAuthStore } from '../../../stores/auth'; 
import { getCandidateTotalVotes } from '../../../services/api/vote'; 

const authStore = useAuthStore(); 
const isLoading = ref(true);
const candidatesWithTotalVotes = ref({
    "President":{ candidates: [] },
    "Vice President": { candidates: [] },
    "Treasurer": { candidates: [] },
    "Secretary": { candidates: [] },
});

const currentElection = ref([]);
const route = useRoute();

provide('userAuth', authStore);

onBeforeMount(async () => {
   await authStore.getAuthUser();  
   const candidates = await getCandidateTotalVotes(route.params.electionId); 
   mapCandidatesVote(candidates) 
})  

const mapCandidatesVote = (data) => {
    data.forEach(candidate => {
        candidatesWithTotalVotes.value[candidate.position].candidates.push(candidate)
    })
    getCandidatesPercentageVote()
    isLoading.value = false
} 

const getCandidatesPercentageVote = () => { 
     for (const key in candidatesWithTotalVotes.value) {
         const totalVotes = candidatesWithTotalVotes.value[key].candidates.reduce((total, candidate) => total + candidate.votes, 0);
         candidatesWithTotalVotes.value[key].totalVotes = totalVotes;
     }
     console.log(candidatesWithTotalVotes.value)
}

</script>
 