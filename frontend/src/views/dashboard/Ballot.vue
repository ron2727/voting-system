<template>
    <div>
      <DashboardTemplate layout="w-full">
        <template #head>
          <Title :title="currentElection[0]?.title" :subTitle="currentElection[0]?.description"></Title>
        </template>
        <template #main>
          <div class="wrapper space-y-8">
            <CandidateList :candidates="voteBallot" title="Candidates you had voted"></CandidateList>
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
  import { storeVote, getVotes } from '../../services/api/vote'
  import { useRoute } from 'vue-router';

  const route = useRoute();
  const currentElection = ref([]);
  const authStore = useAuthStore(); 
   
  const errorsData = ref(null);
  const voteBallot = ref(null)
  provide('userAuth', authStore);
  
  onMounted(async () => {
     await authStore.getAuthUser();  
     currentElection.value = await getFilteredElection('Active')
     const candidates = await getVotes({
       user_id: authStore.user.id,
       election_id: currentElection.value[0].id
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
             section: data.section
          }
        }

        return candidateInfo
     })

     console.log(voteBallot.value)
  }) 
 
</script>
   