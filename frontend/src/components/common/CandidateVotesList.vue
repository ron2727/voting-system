<template>
    <div class=" candidates-wrapper px-4 pt-4 pb-8">
        <h6 class=" text-xl font-bold mb-5">{{title}}</h6>
        <div class="relative grid grid-cols-12 h-min pt-5 pb-10 bg-white rounded-xl space-x-5" v-for="candidate in candidates">
            <div class=" col-span-2 flex flex-col justify-between items-center">
                <img src="../../assets/images/BUERE_JOHNRON1.png" alt="a"
                    class="  w-16 h-16object-cover border rounded-full">
                <h6 class="text-xs font-bold">{{ candidate.user.firstname }} {{ candidate.user.lastname }}</h6>
                <small class=" text-xs text-gray-500">{{ candidate.user.year_level }}</small>
            </div>
            <div class="votes-wrapper col-span-9">
                <div class="border relative h-full bg-white border-gray-200 rounded-xl overflow-hidden">
                    <div :style="{width: `${getPercentageVote(totalVotes, candidate.votes)}%`}" class=" h-full w-1/2 bg-blue-600">
                    </div>
                    <span class="votes-percent absolute right-0 top-1/2 -translate-y-1/2 mr-5 font-bold">{{ getPercentageVote(totalVotes, candidate.votes) }}%</span>
                </div>
                <small class="votes">
                    <span class=" text-xs font-bold">Total Votes: </span>
                    <span class=" text-xs text-gray-600">{{ candidate.votes }}</span>
                </small>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

defineProps({
    title:{
        type: String,
        default: 'Title',
    },
    candidates: Array,
    totalVotes: Number
})
 
const getPercentageVote = (totalVote, candidateTotalVote) => {
    let totalPercentageVotes = Math.round((candidateTotalVote / totalVote) * 100)
    if (isNaN(totalPercentageVotes)) {
        totalPercentageVotes = 0
    }
    
    return totalPercentageVotes; 
}
</script> 