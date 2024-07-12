<template>
    <div>
        <DashboardTemplate layout="w-full">
            <template #head>
                <Title title="Reports" subTitle="Generate report for elections"></Title>
            </template>
            <template #main>
                <Loader size="md" v-if="isLoading"/>
                <div class="wrapper" v-else> 
                   <InputSearch searchType="month" @submit-search="findElections"/>
                    <Loader size="sm" v-if="isSearching"/>
                    <div class="wrapper space-y-3" v-else>
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
                            <RouterLink :to="`/reports/pdf/${election.id}`">
                                <Button buttonText="Generate Report" class=" absolute right-0 bottom-0 m-5"></Button>
                            </RouterLink>
                        </template>
                    </Card>
                    <NoRecordMessage v-else>No election found</NoRecordMessage>
                    </div>
                </div>
            </template>
        </DashboardTemplate>
    </div>
</template>

<script setup>
import DashboardTemplate from '../../../components/layouts/DashboardTemplate.vue';
import Title from '../../../components/common/Title.vue';
import InputSearch from '../../../components/common/InputSearch.vue';
import Card from '../../../components/common/Card.vue';
import Button from '../../../components/common/Button.vue';
import NoRecordMessage from '../../../components/common/NoRecordMessage.vue';
import Loader from '../../../components/common/Loader.vue';
import { getElectionByMonthYear } from '../../../services/api/elections';
import { DateFormat } from '../../../services/dateFormat';
import { onMounted, ref, provide, onBeforeMount } from 'vue';
import { useAuthStore } from '../../../stores/auth';


const authStore = useAuthStore(); 
const isLoading = ref(true);
const isSearching = ref(false);
const elections = ref([]);

provide('userAuth', authStore);

onMounted(async () => {
    const date = new Date();
    await authStore.getAuthUser();
    elections.value = await getElectionByMonthYear(date.getMonth() + 1, date.getFullYear());
    isLoading.value = false;
    console.log(date.getFullYear())
}) 

const findElections = async ({month, year}) => { 
    isSearching.value = true;
    const response = await getElectionByMonthYear(month, year); 
    elections.value = response; 
    isSearching.value = false;
}

 
</script>