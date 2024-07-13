<template>
  <div>
    <DashboardTemplate layout="w-full">
      <template #head v-if="!isLoading">
        <BackButton path="/vote"/>
        <Title :title="currentElection.title" :subTitle="currentElection.description"></Title>
      </template>
      <template #main>
        <Loader size="md" v-if="isLoading"/>
        <div class="wrapper space-y-8" v-else>
          <div class="wrapper" v-if="!alreadyVoted">
            <CandidateList v-for="(candidates, position) in positions" :candidates="candidates" :title="position"
              @select-candidate="selectCandidate" :errorMessage="errorsData?.[removeSpace(position)]?.[0]" />
            <div class=" flex justify-center">
              <Button buttonText="Submit Vote" class="m-5" @click="submitVote" :disabled="isSubmitting">
                <i class='bx bx-loader-alt bx-xs bx-spin text-white' v-if="isSubmitting"></i>
              </Button>
            </div>
          </div>
          <div class="wrapper" v-else> 
            <NoRecordMessage>You have already voted in this election</NoRecordMessage>
            <div class=" flex justify-center">
              <RouterLink :to="`/ballot/${$route.params.electionId}`">
                <button type="button" class=" px-4 py-2 bg-blue-600 rounded-md text-white text-xs lg:text-sm">View my
                  candidates</button>
              </RouterLink>
            </div>
          </div>
        </div> 
      </template>
    </DashboardTemplate>
  </div>
</template>

<script setup>
import Loader from '../../../components/common/Loader.vue';
import DashboardTemplate from '../../../components/layouts/DashboardTemplate.vue'
import Title from '../../../components/common/Title.vue'
import Button from '../../../components/common/Button.vue';  
import CandidateList from '../../../components/common/CandidateList.vue';
import NoRecordMessage from '../../../components/common/NoRecordMessage.vue'; 
import BackButton from '../../../components/common/BackButton.vue';
import { ref, onMounted, provide } from 'vue';
import { useAuthStore } from '../../../stores/auth'; 
import { getCandidatesFromElection } from '../../../services/api/candidates'
import { getElection, getFilteredElection } from '../../../services/api/elections'
import { storeVote, checkVote } from '../../../services/api/vote'
import { RouterLink, useRoute, useRouter } from 'vue-router';
const route = useRoute();
const router = useRouter();
const currentElection = ref([]);
const authStore = useAuthStore(); 
const isLoading = ref(true);
const alreadyVoted = ref(true);
const isSubmitting = ref(false);

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
   currentElection.value = await getElection(route.params.electionId)
   const dataForIfVoted = await checkVote(authStore.user.id, route.params.electionId)
   isLoading.value = false
   if (dataForIfVoted.message == "You have not voted yet") {
     alreadyVoted.value = false
     votersBallot.value.election_id = currentElection.value.id
     const response = await getCandidatesFromElection(currentElection.value.id); 
     processCandidates(response.data)
   }
}) 
const getActiveMenu = (menuItem) => {
    console.log(menuItem)
}
const processCandidates = (candidates) => {
    for (const candidate of candidates) {
       positions.value[candidate.position].push(candidate) 
    }  
  }

const selectCandidate = (candidate) => {
    votersBallot.value[removeSpace(candidate.position)] = candidate.id; 
}

const submitVote = async () => {
    isSubmitting.value = true
    const response = await storeVote(votersBallot.value)
    errorsData.value = response.errors.value 
    
    if (errorsData.value == null) { 
      router.push('/ballot/' + currentElection.value.id)
    }

    isSubmitting.value = false
}

const removeSpace = (text) => {
    return text.replace(/\s/g, '_');
}
</script>
 