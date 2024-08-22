<template>
  <Title title="Elections" subTitle="View and manage elections"></Title> 
  <RouterLink to="/dashboard/election/add">
    <Button buttonText="Create Election">
      <i class='bx bx-plus'></i>
    </Button>
  </RouterLink>
  <SubNav @getActive="getActiveMenu" :menus="['Active', 'Upcoming', 'Completed']" defaultActive="Active"></SubNav>
  <Loader size="md" v-if="isLoading" />
  <div class=" space-y-3" v-else>
    <Card v-if="elections.length" v-for="election in elections" class=" p-4">
      <template #title>
        <div class="flex justify-end">
          <RouterLink :to="`/dashboard/election/edit/${election.id}`">
            <button class="text-sm">
              <i class='bx bxs-edit bx-sm'></i>
            </button>
          </RouterLink>
        </div>
        <h6 class="title text-sm lg:text-lg font-bold">
          {{ election.title }}
        </h6>
      </template>
      <template #body>
        <div class="py-4 text-xs lg:text-sm">
          {{ election.description }}
        </div>
      </template>
      <template #footer>
        <div class=" space-y-4">
          <div class=" w-max text-xs text-gray-500">
            <span class=" font-bold">Start Date: </span>
            {{ DateFormat.getDateWithMonthName(election.start_date) }}
            {{ DateFormat.getTimeOfDate(election.start_date) }}
          </div>
          <div class=" w-max text-xs text-gray-500">
            <span class=" font-bold">End Date: </span>
            {{ DateFormat.getDateWithMonthName(election.end_date) }}
            {{ DateFormat.getTimeOfDate(election.end_date) }}
          </div>
        </div>
       <div class=" flex justify-end">
        <RouterLink :to="`/dashboard/election/${election.id}/candidates/${electionStatus}`">
          <Button buttonText="View Candidates" class=" block md:absolute right-0 bottom-0 mt-2 md:m-5"/>
        </RouterLink>
       </div>
      </template>
    </Card>
    <NoRecordMessage v-else>No election found</NoRecordMessage>
  </div>
</template>

<script setup>
import Title from '../../../components/common/Title.vue';
import Loader from '../../../components/common/Loader.vue';
import Button from '../../../components/common/Button.vue';
import Card from '../../../components/common/Card.vue';
import SubNav from '../../../components/common/SubNav.vue';
import NoRecordMessage from '../../../components/common/NoRecordMessage.vue';
import { onMounted, ref, onBeforeMount, provide } from 'vue';
import { RouterLink, useRouter } from 'vue-router';
import { useAuthStore } from '../../../stores/auth';
import { getElections, getFilteredElection } from '../../../services/api/elections';
import { DateFormat } from '../../../services/dateFormat';

const authStore = useAuthStore();
const route = useRouter();
const isLoading = ref(true);
const elections = ref([]);
const electionStatus = ref('active');
provide('userAuth', authStore);

onBeforeMount(async () => {
  await authStore.getAuthUser();
  if (!authStore.user.is_admin) {
    route.push('/dashboard/vote')
  }
  elections.value = await getFilteredElection('Active');
  isLoading.value = false;
  console.log(authStore.user)
})


const getActiveMenu = async (menuItem) => {
  isLoading.value = true;
  elections.value = await getFilteredElection(menuItem);
  electionStatus.value = menuItem.toLowerCase();
  isLoading.value = false;
}

 
</script>