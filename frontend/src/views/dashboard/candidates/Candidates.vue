<template>
  <div>
    <DashboardTemplate :layout="'w-full'">
      <template #head v-if="!isLoading">
        <Title :title="election.title" :subTitle="election.description"></Title>
        <RouterLink :to="`/election/${election.id}/candidates/add`">
          <Button buttonText="Add new candidate" class="mt-10">
            <i class='bx bx-plus'></i>
          </Button>
        </RouterLink>
      </template>
      <template #main>
        <div class="wrapper space-y-8" v-if="!isLoading">
          <div class="candidates space-y-2" v-for="(candidates, position) in positions">
            <h6 class=" text-lg font-bold">{{ position }}</h6>
            <div class=" grid grid-cols-4 gap-3" v-if="candidates.length">
              <Card v-for="candidate in candidates" class=" p-1">
                <template #body>
                  <img :src="candidate.user.profile_image" alt="a"
                    class=" w-full object-cover border rounded-2xl">
                </template>
                <template #footer>
                  <div class="px-1 py-2">
                    <h6 class="text-lg font-bold">{{ candidate.user.firstname }} {{ candidate.user.lastname }}</h6>
                    <small class=" text-sm text-gray-500">{{ candidate.position }}</small>
                  </div>
                </template>
              </Card>
            </div>
            <NoRecordMessage v-else>No candidate found</NoRecordMessage>
          </div>
        </div>
        
        <Loader size="md" v-else />
      </template>
    </DashboardTemplate>
  </div>
</template>
  
  <script setup>
  import Loader from '../../../components/common/Loader.vue';
  import DashboardTemplate from '../../../components/layouts/DashboardTemplate.vue'
  import Title from '../../../components/common/Title.vue'
  import Button from '../../../components/common/Button.vue';
  import SubNav from '../../../components/common/SubNav.vue';
  import Card from '../../../components/common/Card.vue';
  import NoRecordMessage from '../../../components/common/NoRecordMessage.vue';
  import { onMounted, ref, onBeforeMount, provide } from 'vue';
  import { RouterLink, useRouter, useRoute } from 'vue-router';
  import { useAuthStore } from '../../../stores/auth'; 
  import { getElections, getElection } from '../../../services/api/elections';
  import { getCandidatesFromElection } from '../../../services/api/candidates'
  import { DateFormat } from '../../../services/dateFormat';
  
  const authStore = useAuthStore(); 
  const router = useRouter();
  const route = useRoute();
  const isLoading = ref(true);
  const election = ref([]);  
  const positions = ref({
    "President": [],
    "Vice President": [],
    "Treasurer": [],
    "Secretary": [], 
  });

  provide('userAuth', authStore);
  
  onBeforeMount(async () => {
     await authStore.getAuthUser(); 
     if (!authStore.user.is_admin) {
       router.push('/dashboard')
     }
     election.value = await getElection(route.params.electionId); 
     const response = await getCandidatesFromElection(route.params.electionId);
     isLoading.value = false
     processCandidates(response.data)
    //  console.log(candidates.value.data)
  }) 
  
  const processCandidates = (candidates) => {
    for (const candidate of candidates) {
       positions.value[candidate.position].push(candidate) 
    } 
    console.log(positions.value)
  }
  </script>
   