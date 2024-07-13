<template>
    <div class="input-search mb-5 flex justify-end">
        <div class="w-min flex items-center">
            <input v-model="search" type="month" class=" w-40 border-l border-t border-b border-r-0 border-gray-200 rounded-l-lg  outline-none text-xs md:text-sm p-2"
                placeholder="Search">
            <button type="button" class="bg-blue-600 px-2 pt-1 rounded-r-lg h-full"
                @click="findVoters">
                <i class='bx bx-search-alt-2 bx-xs text-white'></i>
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
defineProps({
    searchType: {
        type: String,
        default: 'text'
    }
})
const search = ref('')

const emits = defineEmits(['submit-search'])

const findVoters = () => { 
    const [year, month] = search.value.split('-')
    emits('submit-search', {month, year})  
}
</script> 