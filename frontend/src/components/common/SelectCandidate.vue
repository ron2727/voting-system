<template>
    <div class=" candidates-wrapper mt-5">
        <h6 class=" text-lg md:text-xl font-bold mb-5">{{ title }}</h6>
        <div ref="candidatesList" class=" space-y-3">
            <div v-for="candidate in candidates" @click="selectCandidate(candidate)"
                 :class="selectedCandidateId === candidate.id ? 'border-blue-600' : 'border-gray-200'"
                 class="candidate group relative flex items-center p-3 h-min border bg-white rounded-2xl overflow-hidden cursor-pointer">
                <img :src="candidate.user.profile_image" alt="a"
                    class=" w-14 h-14 object-cover border rounded-full">
                <div class="px-1 py-2">
                    <h6 class=" text-sm font-bold">{{ candidate.user.firstname }} {{ candidate.user.lastname }}</h6>
                    <small class=" text-xs text-gray-500">{{ candidate.position }}</small>
                </div> 
                <div v-if="selectedCandidateId === candidate.id" class="absolute right-0 top-0 flex items-center justify-center w-1/6 h-full bg-blue-600">
                    <i class='bx bx-check text-2xl text-white'></i>
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

const selectedCandidateId = ref(null)

const emits = defineEmits(['selectCandidate'])

const candidatesList = ref(null);
const candidate = ref(null) 
const selectCandidate = (candidate) => { 
    selectedCandidateId.value = candidate.id
    console.log(selectedCandidateId.value)
    emits('selectCandidate', candidate)
}

const removeSelectedCardCandidate = () => {
    Array.from(candidatesList.value.children).forEach(element => {
        if (element.classList.contains('border-blue-600')) {
            element.classList.remove('border-blue-600')
        }
    })
}

const setClickEvent = (elements) => { 
    for (let i = 0; i < elements.length; i++) { 
        console.log(elements[i])
        elements[i].addEventListener('click', selectCandidate);
    }
}
</script> 