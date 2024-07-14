<template>
    <div class=" candidates-wrapper px-0 md:px-4 pt-4 pb-8">
        <h6 class=" text-xl font-bold mb-5">{{title}}</h6>
        <div class="wrapper border rounded-lg bg-white"  v-if="candidates.length">
           <div class="relative px-3 md:px-0 grid grid-cols-1 md:grid-cols-12 items-center gap-y-2 md:gap-y-0 h-min pt-5 pb-10 md:space-x-5" v-for="candidate in candidates">
            <div class=" md:col-span-2 flex flex-col justify-between items-center">
                <img :src="candidate.user.profile_image" alt="a"
                    class=" w-12 h-12  md:w-16 md:h-16 object-cover border rounded-full">
                <h6 class="text-xs font-bold">{{ candidate.user.firstname }} {{ candidate.user.lastname }}</h6>
                <small class=" text-xs text-gray-500">{{ candidate.user.year_level }}</small>
            </div>
            <div class="votes-wrapper md:col-span-9 h-12">
                <div class="border border-blue-200 relative h-full bg-white rounded-xl overflow-hidden">
                    <div :style="{width: `${getPercentageVote(totalVotes, candidate.votes)}%`}" class=" h-full bg-blue-500/25">
                    </div>
                    <span class="votes-percent absolute right-0 top-1/2 text-blue-600 -translate-y-1/2 mr-5 font-bold">{{ getPercentageVote(totalVotes, candidate.votes) }}%</span>
                </div>
                <small class="votes">
                    <span class=" text-xs font-bold">Total Votes: </span>
                    <span class=" text-xs text-gray-600">{{ candidate.votes }}</span>
                </small>
            </div>
           </div>
        </div>
        <NoRecordMessage v-else>No candidate for {{ title }}</NoRecordMessage>
    </div>
</template>

<script setup>
import NoRecordMessage from './NoRecordMessage.vue';

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