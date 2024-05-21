<template>
    <div>
      <DashboardTemplate layout="w-full">
        <template #head>
          <Title :title="currentElection[0]?.title" :subTitle="currentElection[0]?.description"></Title>
        </template>
        <template #main>
          <div class="wrapper space-y-8">
            Ballot
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
  import { storeVote } from '../../services/api/vote'
   
  const currentElection = ref([]);
  const authStore = useAuthStore(); 
   
  const errorsData = ref(null);
  provide('userAuth', authStore);
  
  onMounted(async () => {
     await authStore.getAuthUser(); 
     votersBallot.value.user_id = authStore.user.id
     currentElection.value = await getFilteredElection('Active')
  
  }) 
 
  </script>
   