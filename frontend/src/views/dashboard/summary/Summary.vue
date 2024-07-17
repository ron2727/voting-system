<template> 
    <Title title="Dashboard" subTitle="View your dashboard" />
    <Loader v-if="isLoading" />
    <div class="wrapper grid grid-cols-1 lg:grid-cols-3 gap-2" v-else>
        <div class=" col-1 col-span-2">
            <div class=" grid grid-cols-2 gap-2">
                <DashboardCard class="bg-blue-600">
                    <template #icon>
                        <i class='bx bx-group bx-sm'></i>
                    </template>
                    <template #label>Total voters</template>
                    <template #value>{{ totalVoters }}</template>
                </DashboardCard>
                <DashboardCard class="bg-violet-600">
                    <template #icon>
                        <i class='bx bx-receipt bx-sm'></i>
                    </template>
                    <template #label>Total votes cast</template>
                    <template #value>{{ totaVotesCasted }}</template>
                </DashboardCard>
                <div class="border p-4 bg-white rounded-3xl col-span-2">
                    <DasboardVoteTally />
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class=" wrapper border rounded-3xl bg-white p-3">
                <h1 class="mt-3 font-bold text-lg">Upcoming elections</h1>
                <DashboardElectionCard v-if="upcomingElections.length" v-for="election in upcomingElections" :election="election" />
                <NoRecordMessage v-else>No upcoming election found</NoRecordMessage>
            </div>
        </div>
    </div>
</template>

<script setup>
import Loader from '../../../components/common/Loader.vue';
import Title from '../../../components/common/Title.vue';
import DashboardCard from '../../../components/dashboard/DashboardCard.vue';
import DashboardElectionCard from '../../../components/dashboard/DashboardElectionCard.vue';
import DasboardVoteTally from '../../../components/dashboard/DasboardVoteTally.vue';
import NoRecordMessage from '../../../components/common/NoRecordMessage.vue';
import { onMounted, ref, provide, onBeforeMount } from 'vue';
import { getFilteredElection } from '../../../services/api/elections';
import { getTotalVotes } from '../../../services/api/vote';
import { getTotalVoters } from '../../../services/api/voters';
const upcomingElections = ref([]);
const totaVotesCasted = ref(0);
const totalVoters = ref(0);
const isLoading = ref(true);

onMounted(async () => { 
   upcomingElections.value = await getFilteredElection('Upcoming') 
   totaVotesCasted.value = await getTotalVotes()
   totalVoters.value = await getTotalVoters()
   isLoading.value = false
   console.log(totaVotesCasted.value)
}) 


</script>

<style lang="scss" scoped></style>