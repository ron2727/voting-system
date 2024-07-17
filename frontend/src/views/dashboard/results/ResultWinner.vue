<template>
    <BackButton path="/dashboard/results/elections" />
    <Loader size="md" v-if="isLoading" />
    <CandidateList v-else :candidates="candidatesWinners" title="Candidates that won the election" /> 
</template>

<script setup>
import Loader from '../../../components/common/Loader.vue';
import BackButton from '../../../components/common/BackButton.vue';
import CandidateList from '../../../components/common/CandidateList.vue';
import { useRoute } from 'vue-router'; 
import { onBeforeMount, ref } from 'vue'; 
import { getCandidateTotalVotes } from '../../../services/api/vote'
import { VotesTally } from '../../../services/voteTally';
import { getElection } from '../../../services/api/elections';
const route = useRoute();
const isLoading = ref(true);
const candidatesWinners = ref([])

onBeforeMount(async () => {
    const data = await getCandidateTotalVotes(route.params.electionId)
    const election = await getElection(route.params.electionId)
    const votesTally = new VotesTally(data, JSON.parse(election.positions))   
    candidatesWinners.value = votesTally.getElectionCandidatesWinner()
    console.log(candidatesWinners.value)
    isLoading.value = false 
})
 
</script> 