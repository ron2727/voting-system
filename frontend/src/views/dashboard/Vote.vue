<template>
  <div>
    <DashboardTemplate layout="w-full">
      <template #head>
        <Title :title="currentElection[0]?.title" :subTitle="currentElection[0]?.description"></Title>
      </template>
      <template #main>
        <div class="wrapper space-y-8">
          <div class="candidates space-y-2" v-for="(candidates, position) in positions">
            <h6 class=" text-lg font-bold">{{ position }}</h6>
            <div class=" grid grid-cols-4 gap-3">
              <Card v-for="candidate in candidates" class=" p-1">
                <template #body>
                  <img src="../../assets/images/BUERE_JOHNRON1.png" alt="a"
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
          </div>
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
import { ref, onMounted, provide } from 'vue';
import { useAuthStore } from '../../stores/auth'; 
import { getCandidatesFromElection } from '../../services/api/candidates'
import { getFilteredElection } from '../../services/api/elections'
const positions = ref({
    "President": [],
    "Vice President": [],
    "Treasurer": [],
    "Secretary": [], 
});
const currentElection = ref([]);
const authStore = useAuthStore(); 

provide('userAuth', authStore);

onMounted(async () => {
   await authStore.getAuthUser(); 
   currentElection.value = await getFilteredElection('Active')
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
</script>
 