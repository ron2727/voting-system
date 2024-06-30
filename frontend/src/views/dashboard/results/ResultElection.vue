<template>
    <div class=" space-y-3">
        <Card v-for="election in elections" class=" p-4">
            <template #title>
                <div class="flex justify-end">
                    <button class="text-sm">
                        <i class='bx bx-dots-vertical-rounded bx-sm'></i>
                    </button>
                </div>
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
                <RouterLink :to="`/results/winners/${election.id}`">
                    <Button buttonText="View Winners" class=" absolute right-0 bottom-0 m-5"></Button>
                </RouterLink>
            </template>
        </Card>
    </div>
</template>

<script setup>
import DashboardTemplate from '../../../components/layouts/DashboardTemplate.vue'
import Title from '../../../components/common/Title.vue'
import Button from '../../../components/common/Button.vue';
import SubNav from '../../../components/common/SubNav.vue';
import Card from '../../../components/common/Card.vue';
import { onMounted, ref, onBeforeMount, provide } from 'vue'; 
import { getElections, getFilteredElection } from '../../../services/api/elections';
import { DateFormat } from '../../../services/dateFormat';

 
const elections = ref([]);
 
onBeforeMount(async () => { 
    elections.value = await getFilteredElection('Completed'); 
})

 
</script>