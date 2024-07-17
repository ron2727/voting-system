<template>
    <Loader size="md" v-if="isLoading" />
    <div class="wrapper" v-else>
        <div v-if="elections.length">
            <h6 class="text-lg font-bold mb-5">Votes tally</h6>
            <div class="election mb-5">
                <h6 class=" font-bold text-sm">{{ election.title }}</h6>
                <h6 class=" text-xs text-gray-400">{{ election.description }}</h6>
            </div>
            <div class="wrapper mb-12" v-for="(data, position) in candidatesWithTotalVotes">
                <div class=" flex justify-between mb-2">
                    <h6 class=" text-sm">{{ position }}</h6>
                    <span class=" text-xs text-gray-400">{{ data.totalVotes }} Votes</span>
                </div>
                <div class=" mb-2 relative border-blue-200" v-if="data.candidates.length" v-for="candidate in data.candidates">
                    <div class="wrapper flex items-center space-x-2 mb-1">
                        <img :src="candidate.user.profile_image" alt="a" class="w-10 h-10 object-cover border rounded-full">
                        <span class=" text-xs">{{ candidate.user.firstname }} {{ candidate.user.lastname }}</span>
                    </div>
                    <div class="grid grid-cols-12 gap-x-2">
                        <div class=" overflow-hidden  col-span-10 bg-gray-100 rounded-full">
                            <div id="votesMeter"
                                :style="{ width: `${candidate.votePercentage}%`, backgroundColor: getRandomHexColorCode() }"
                                class="votes-meter h-full"></div>
                        </div>
                        <div class="votes-percentage text-xs mr-5 text-black font-bold">{{ candidate.votePercentage }}%</div>
                    </div>
                    <small class=" text-xs text-gray-600">{{ candidate.votes }} Votes</small>
                </div>
                <NoRecordMessage v-else>No candidates yet</NoRecordMessage>
            </div>
        </div>
        <NoRecordMessage v-else>No active election</NoRecordMessage>
    </div>
</template>

<script setup>
import Loader from '../common/Loader.vue';
import NoRecordMessage from '../common/NoRecordMessage.vue';
import { onBeforeMount, ref } from 'vue';
import { getCandidateTotalVotes } from '../../services/api/vote';
import { getFilteredElection } from '../../services/api/elections';
import { VotesTally } from '../../services/voteTally';
const isLoading = ref(true);
const elections = ref([]);
const election = ref();
const candidatesWithTotalVotes = ref(null); 

const colors = ref(['#EC2049', '#F26B38', '#F7DB4F', '#2F9599'])

onBeforeMount(async () => { 
    elections.value = await getFilteredElection('Active'); 
    if (elections.value.length) {
        const { electionId, positions } = getRandomId(elections.value);
        const candidates = await getCandidateTotalVotes(electionId);
        const voteTally = new VotesTally(candidates, positions)
        candidatesWithTotalVotes.value = voteTally.getCandidates()
    }
   isLoading.value = false
})   

const getRandomHexColorCode = () => {
    return colors.value[Math.floor(Math.random() * colors.value.length)]
}

const getRandomId = (electionsArr) => {
    const electionIds = electionsArr.map(election => election.id)
    const randomNumber = Math.floor(Math.random() * electionIds.length)
    election.value = electionsArr.filter(election => election.id === electionIds[randomNumber])[0] 
    const electionId = electionIds[randomNumber]
    const positions = JSON.parse(election.value.positions)
    
    return { electionId, positions }
}
</script>