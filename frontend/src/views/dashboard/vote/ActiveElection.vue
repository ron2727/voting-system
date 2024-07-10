<template>
     <DashboardTemplate layout="w-full">
      <template #head>
        <Title title="Vote" subTitle="Select election where you want to vote"></Title>
      </template>
      <template #main>
        <Loader size="md" v-if="isLoading"/>
        <div class=" space-y-3" v-else>
        <Card v-if="elections.length" v-for="election in elections" class=" p-4">
            <template #title> 
                <h6 class="title text-lg font-bold">
                    {{ election.title }}
                </h6>
            </template>
            <template #body>
                <div class="py-4">
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
                <RouterLink :to="`/vote/${election.id}`">
                    <Button buttonText="Vote" class=" absolute right-0 bottom-0 m-5"/>
                </RouterLink>
            </template>
        </Card>
        <NoRecordMessage v-else>No election found</NoRecordMessage>
       </div>
      </template>
    </DashboardTemplate>

</template>

<script setup>
import Loader from '../../../components/common/Loader.vue';
import DashboardTemplate from '../../../components/layouts/DashboardTemplate.vue'
import Title from '../../../components/common/Title.vue'
import Button from '../../../components/common/Button.vue';
import NoRecordMessage from '../../../components/common/NoRecordMessage.vue';
import Card from '../../../components/common/Card.vue';
import { onMounted, ref, onBeforeMount, provide } from 'vue'; 
import { getElections, getFilteredElection } from '../../../services/api/elections';
import { DateFormat } from '../../../services/dateFormat';
import { useAuthStore } from '../../../stores/auth'; 

const authStore = useAuthStore(); 
const isLoading = ref(true);
const elections = ref([]);

provide('userAuth', authStore);

onBeforeMount(async () => { 
    elections.value = await getFilteredElection('Active'); 
    isLoading.value = false;
})

 
</script>