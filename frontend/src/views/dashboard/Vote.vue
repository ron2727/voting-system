<template>
  <div>
    <DashboardTemplate layout="w-full">
      <template #head>
        <Title :title="currentElection[0]?.title" :subTitle="currentElection[0]?.description"></Title>
      </template>
      <template #main>
        <div class="wrapper space-y-8">
          <CandidateList v-for="(candidates, position) in positions" :candidates="candidates" :position="position" @select-candidate="selectCandidate"/> 
        </div>
      </template>
    </DashboardTemplate>
  </div>
</template>

<script setup>
import DashboardTemplate from '../../components/layouts/DashboardTemplate.vue'
import Title from '../../components/common/Title.vue'
import Button from '../../components/common/Button.vue'; 
import Card from '../../components/common/Card.vue';
import CandidateList from '../../components/common/CandidateList.vue';
import { ref, onMounted, provide } from 'vue';
import { useAuthStore } from '../../stores/auth'; 
import { getCandidatesFromElection } from '../../services/api/candidates'
import { getFilteredElection } from '../../services/api/elections'


const currentElection = ref([]);
const authStore = useAuthStore(); 

const positions = ref({
    "President": [],
    "Vice President": [],
    "Treasurer": [],
    "Secretary": [], 
});

const votersBallot = ref({
    "user_id": authStore.user.id,
    "election_id": null,
    "President": null,
    "Vice President": null,
    "Treasurer": null,
    "Secretary": null,
});


provide('userAuth', authStore);

onMounted(async () => {
   await authStore.getAuthUser(); 
   currentElection.value = await getFilteredElection('Active')
   votersBallot.value.election_id = currentElection.value[0].id
   const response = await getCandidatesFromElection(currentElection.value[0].id);

   processCandidates(response.data)
   console.log(authStore.user)
}) 
const getActiveMenu = (menuItem) => {
    console.log(menuItem)
}
const processCandidates = (candidates) => {
    for (const candidate of candidates) {
       positions.value[candidate.position].push(candidate) 
    } 
    console.log(positions.value)
  }

const selectCandidate = (candidate) => {
    votersBallot.value[candidate.position] = candidate.id;
    console.log(votersBallot.value)
}
</script>
 