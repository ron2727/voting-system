<template>
    <div class=" candidates-wrapper mt-10">
        <h6 class=" text-lg md:text-xl font-bold mb-5">{{ title }}</h6>
        <div ref="candidatesList" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
            <div v-for="candidate in candidates" class="candidate relative h-min border bg-white rounded-2xl p-1">
                <img :src="candidate.user.profile_image" alt="a"
                    class=" w-full object-cover border rounded-2xl">
                <div class="px-1 py-2">
                    <h6 class=" text-sm md:text-lg font-bold">{{ candidate.user.firstname }} {{ candidate.user.lastname }}</h6>
                    <small class=" text-xs md:text-sm text-gray-500">{{ candidate.position }}</small>
                </div>
            </div>
        </div> 
    </div>
</template>

<script setup> 
defineProps({
    candidates: Array,
    title: {
        type: String,
        default: ''
    }, 
}) 
</script> 