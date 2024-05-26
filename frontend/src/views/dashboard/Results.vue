<template>
    <div>
        <DashboardTemplate layout="w-full"> 
            <template #head>
              <Title title="Results" subTitle="View the results of elections"></Title>
              <SubNav @getActive="getActiveMenu" :menus="['Votes', 'Winners']" defaultActive="Votes"></SubNav>
             </template>
             <template #main>
                <CandidateVotesList v-for="(candidates, position) in candidatesWithTotalVotes" :candidates="candidates.candidates" :totalVotes="candidates.totalVotes" :title="position"></CandidateVotesList>
             </template>
        </DashboardTemplate> 
    </div>
</template>

<script setup>
import DashboardTemplate from '../../components/layouts/DashboardTemplate.vue'
import Title from '../../components/common/Title.vue'
import Button from '../../components/common/Button.vue';
import SubNav from '../../components/common/SubNav.vue';
import Card from '../../components/common/Card.vue';
import CandidateVotesList from '../../components/common/CandidateVotesList.vue';
import { ref, onMounted, onBeforeMount, provide } from 'vue';
import { useAuthStore } from '../../stores/auth'; 
import { getCandidateTotalVotes } from '../../services/api/vote';
import { getFilteredElection } from '../../services/api/elections'

const authStore = useAuthStore(); 
const candidatesWithTotalVotes = ref({
    "President":{ candidates: [] },
    "Vice President": { candidates: [] },
    "Treasurer": { candidates: [] },
    "Secretary": { candidates: [] },
});

const currentElection = ref([]);

provide('userAuth', authStore);

onBeforeMount(async () => {
   await authStore.getAuthUser(); 
   currentElection.value = await getFilteredElection('Active');
   const candidates = await getCandidateTotalVotes(currentElection.value[0].id);
   mapCandidatesVote(candidates)
//    console.log(candidates)
}) 
const getActiveMenu = (menuItem) => {
    console.log(menuItem)
}

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
 