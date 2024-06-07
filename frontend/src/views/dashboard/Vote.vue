<template>
  <div>
    <DashboardTemplate layout="w-full">
      <template #head>
        <Title :title="currentElection[0]?.title" :subTitle="currentElection[0]?.description"></Title>
      </template>
      <template #main>
        <div class="wrapper space-y-8" v-if="currentElection.length">
          <CandidateList v-for="(candidates, position) in positions" :candidates="candidates" :title="position"
            @select-candidate="selectCandidate" :errorMessage="errorsData?.[removeSpace(position)]?.[0]" />
          <div class=" flex justify-center">
            <Button buttonText="Submit Vote" class="m-5" @click="submitVote" />
          </div>
        </div>
        <NoRecordMessage v-else>No Election yet</NoRecordMessage>
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
import NoRecordMessage from '../../components/common/NoRecordMessage.vue';
import { ref, onMounted, provide } from 'vue';
import { useAuthStore } from '../../stores/auth'; 
import { getCandidatesFromElection } from '../../services/api/candidates'
import { getFilteredElection } from '../../services/api/elections'
import { storeVote } from '../../services/api/vote'
 
const currentElection = ref([]);
const authStore = useAuthStore(); 

const positions = ref({
    "President": [],
    "Vice President": [],
    "Treasurer": [],
    "Secretary": [], 
});

const votersBallot = ref({
    "user_id": null,
    "election_id": null,
    "President": null,
    "Vice_President": null,
    "Treasurer": null,
    "Secretary": null,
});

const errorsData = ref(null);
provide('userAuth', authStore);

onMounted(async () => {
   await authStore.getAuthUser(); 
   votersBallot.value.user_id = authStore.user.id
   currentElection.value = await getFilteredElection('Active')
  if (currentElection.value.length) {
    votersBallot.value.election_id = currentElection.value[0].id
    const response = await getCandidatesFromElection(currentElection.value[0].id);
    processCandidates(response.data)
  }
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
    votersBallot.value[removeSpace(candidate.position)] = candidate.id;
    console.log(votersBallot.value)
}

const submitVote = async () => {
    const response = await storeVote(votersBallot.value)
    errorsData.value = response.errors.value

    console.log(errorsData.value)
}

const removeSpace = (text) => {
    return text.replace(/\s/g, '_');
}
</script>
 