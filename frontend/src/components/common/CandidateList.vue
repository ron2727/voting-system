<template>
    <div class=" candidates-wrapper mt-10">
        <h6 class=" text-lg font-bold">{{ title }}</h6>
        <div ref="candidatesList" class=" grid grid-cols-4 gap-5">
            <div v-for="candidate in candidates" @click="selectCandidate(candidate, $event)" class="candidate relative h-min border bg-white rounded-2xl cursor-pointer p-1 hover:border-blue-600">
                <img :src="candidate.user.profile_image" alt="a"
                    class=" w-full object-cover border rounded-2xl">
                <div class="px-1 py-2">
                    <h6 class="text-lg font-bold">{{ candidate.user.firstname }} {{ candidate.user.lastname }}</h6>
                    <small class=" text-sm text-gray-500">{{ candidate.position }}</small>
                </div>
            </div>
        </div>
        <small class=" text-red-500" v-if="errorMessage">
            {{ errorMessage }}</small>
    </div>
</template>

<script setup>
import { ref } from 'vue';

defineProps({
    candidates: Array,
    title: {
        type: String,
        default: ''
    },
    errorMessage: {
        type: String,
        default: ''
    }
})
const emits = defineEmits(['selectCandidate'])

const candidatesList = ref(null);

const selectCandidate = (candidate, element) => {
    const selectedCardCandidate = element.target.parentElement;
    removeSelectedCardCandidate();
    
    if (selectedCardCandidate.classList.contains('border-blue-600')) {
        selectedCardCandidate.classList.remove('border-blue-600')
    }else{
       selectedCardCandidate.classList.add('border-blue-600')
    }
    emits('selectCandidate', candidate)
}

const removeSelectedCardCandidate = () => {
    Array.from(candidatesList.value.children).forEach(element => {
        if (element.classList.contains('border-blue-600')) {
            element.classList.remove('border-blue-600')
        }
    })
}
</script> 