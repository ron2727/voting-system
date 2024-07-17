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
import { VotesTally } from '../../../services/voteTally';
import { getElection } from '../../../services/api/elections';
const authStore = useAuthStore(); 
const isLoading = ref(true);
const candidatesWithTotalVotes = ref(null);

const currentElection = ref([]);
const route = useRoute();

provide('userAuth', authStore);

onBeforeMount(async () => {
   await authStore.getAuthUser();  
   const candidates = await getCandidateTotalVotes(route.params.electionId); 
   const election = await getElection(route.params.electionId);
   const positions = JSON.parse(election.positions)
   const voteTally = new VotesTally(candidates, positions)
//    console.log(voteTally.getCandidates())
   candidatesWithTotalVotes.value = voteTally.getCandidates()
   isLoading.value = false 
})  
 

</script>
 