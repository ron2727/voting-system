<template>
    <div class="wrapper bg-white border rounded-2xl p-5 mb-10"> 
        <div class="wrapper">
            <div class=" flex justify-between items-center mb-5">
                <h6 class=" text-sm md:text-xl font-bold">{{ title }}</h6>
                <span class=" text-xs md:text-lg text-gray-400">{{ totalVotes }} Votes</span>
            </div>
            <div class=" mb-2 relative border-blue-200" v-for="candidate in candidates">
                <div class="wrapper flex items-center space-x-2 mb-1">
                    <img :src="candidate.user.profile_image" alt="a" class="w-10 h-10 md:w-16 md:h-16 object-cover border rounded-full">
                    <span class=" text-xs md:text-sm">{{ candidate.user.firstname }} {{ candidate.user.lastname }}</span>
                </div>
                <div class="grid grid-cols-12 gap-x-2">
                    <div class=" overflow-hidden  col-span-10 bg-gray-100 rounded-full">
                        <div id="votesMeter"
                            :style="{ width: `${getPercentageVote(totalVotes, candidate.votes)}%`, backgroundColor: getRandomHexColorCode() }"
                            class="votes-meter h-full"></div>
                    </div>
                    <div class="votes-percentage text-xs md:text-sm mr-5 text-black font-bold">{{ getPercentageVote(totalVotes, candidate.votes) }}%</div>
                </div>
                <small class=" text-xs text-gray-600">{{ candidate.votes }} Votes</small>
            </div>
        </div>
    </div>
    <!-- <div class=" candidates-wrapper px-0 md:px-4 pt-4 pb-8">
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
    </div> -->
</template>

<script setup>
import NoRecordMessage from './NoRecordMessage.vue';
import { ref } from 'vue';
defineProps({
    title:{
        type: String,
        default: 'Title',
    },
    candidates: Array,
    totalVotes: Number
})
const colors = ref(['#EC2049', '#F26B38', '#F7DB4F', '#2F9599'])
const getPercentageVote = (totalVote, candidateTotalVote) => {
    let totalPercentageVotes = Math.round((candidateTotalVote / totalVote) * 100)
    if (isNaN(totalPercentageVotes)) {
        totalPercentageVotes = 0
    }
    
    return totalPercentageVotes; 
}

const getRandomHexColorCode = () => {
    return colors.value[Math.floor(Math.random() * colors.value.length)]
}
 
</script> 