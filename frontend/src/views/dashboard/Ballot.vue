<template>
    <div>
      <DashboardTemplate layout="w-full">
        <template #head v-if="!isLoading">
          <Title :title="currentElection.title" :subTitle="currentElection.description"></Title>
        </template>
        <template #main>
          <div class="wrapper space-y-8">
            <Loader size="md" v-if="isLoading"/>
            <CandidateList v-else :candidates="voteBallot" title="Candidates you had voted"></CandidateList>
           </div>  
        </template>
      </DashboardTemplate>
    </div>
  </template>
  
  <script setup>
  import DashboardTemplate from '../../components/layouts/DashboardTemplate.vue'
  import Loader from '../../components/common/Loader.vue'
  import Title from '../../components/common/Title.vue' 
  import CandidateList from '../../components/common/CandidateList.vue';
  import { ref, onMounted, provide } from 'vue';
  import { useAuthStore } from '../../stores/auth';  
  import { getElection } from '../../services/api/elections'
  import { getVotes } from '../../services/api/vote'
  import { useRoute } from 'vue-router';

  const route = useRoute();
  const currentElection = ref([]);
  const authStore = useAuthStore(); 
   
  const isLoading = ref(true);
  const voteBallot = ref(null)
  provide('userAuth', authStore);
  
  onMounted(async () => {
     await authStore.getAuthUser();  
     currentElection.value = await getElection(route.params.electionId)
     const candidates = await getVotes({
       user_id: authStore.user.id,
       election_id: currentElection.value.id
     }) 
     voteBallot.value = candidates.map(data => {
        const candidateInfo = {
          candidate_id: data.candidate_id,
          user_id: data.user_id,
          position: data.position,
          user:{
             firstname: data.firstname,
             lastname: data.lastname,
             email: data.email,
             course: data.course,
             year_level: data.year_level,
             section: data.section,
             profile_image: data.profile_image
          }
        }

        return candidateInfo
     })
    isLoading.value = false
  }) 
 
</script>
   