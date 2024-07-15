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
                            :style="{ width: `${candidate.votePercentage}%`, backgroundColor: getRandomHexColorCode() }"
                            class="votes-meter h-full"></div>
                    </div>
                    <div class="votes-percentage text-xs md:text-sm mr-5 text-black font-bold">{{ candidate.votePercentage }}%</div>
                </div>
                <small class=" text-xs text-gray-600">{{ candidate.votes }} Votes</small>
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
const colors = ref(['#EC2049', '#F26B38', '#F7DB4F', '#2F9599']) 
const getRandomHexColorCode = () => {
    return colors.value[Math.floor(Math.random() * colors.value.length)]
}
 
</script> 