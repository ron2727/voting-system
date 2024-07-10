<template>
    <Loader size="md" v-if="isLoading" />
    <div class=" space-y-3" v-else>
        <Card v-if="elections.length" v-for="election in elections" class=" p-4">
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
        <NoRecordMessage v-else>No election found</NoRecordMessage>
    </div>
</template>

<script setup> 
import Loader from '../../../components/common/Loader.vue';
import Button from '../../../components/common/Button.vue'; 
import Card from '../../../components/common/Card.vue';
import NoRecordMessage from '../../../components/common/NoRecordMessage.vue';
import { ref, onBeforeMount } from 'vue'; 
import { getFilteredElection } from '../../../services/api/elections';
import { DateFormat } from '../../../services/dateFormat';

const isLoading = ref(true);
const elections = ref([]);
 
onBeforeMount(async () => { 
    elections.value = await getFilteredElection('Completed'); 
    isLoading.value = false;
})

 
</script>