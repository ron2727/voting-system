<template>
    <div>
        <CandidateVotesList v-for="(candidates, position) in candidatesWithTotalVotes" :candidates="candidates.candidates" :totalVotes="candidates.totalVotes" :title="position"></CandidateVotesList>
    
    </div>
</template>

<script setup> 
import CandidateVotesList from '../../../components/common/CandidateVotesList.vue';
import NoRecordMessage from '../../../components/common/NoRecordMessage.vue';
import { ref, onMounted, onBeforeMount, provide } from 'vue';
import { useRoute } from 'vue-router';
import { useAuthStore } from '../../../stores/auth'; 
import { getCandidateTotalVotes } from '../../../services/api/vote';
import { getFilteredElection } from '../../../services/api/elections'

const authStore = useAuthStore(); 
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
    // console.log(candidatesWithTotalVotes.value)
} 

const getCandidatesPercentageVote = () => { 
     for (const key in candidatesWithTotalVotes.value) {
         const totalVotes = candidatesWithTotalVotes.value[key].candidates.reduce((total, candidate) => total + candidate.votes, 0);
         candidatesWithTotalVotes.value[key].totalVotes = totalVotes;
     }
     console.log(candidatesWithTotalVotes.value)
}

</script>
 