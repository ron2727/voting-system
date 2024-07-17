<template>
    <div class="wrapper">
        <span class=" text-sm">Positions</span>
        <div :class="[errorMessage ? 'border-red-300' : 'border-gray-300']"
             class=" min-h-10 h-full border rounded-lg flex flex-wrap overflow-hidden">
            <span class="flex items-center m-2 px-3 py-2 bg-black text-white text-xs rounded-xl" v-for="(position, index) in positions">
                {{position}}
                <button type="button" class="ml-1 mt-0.5" @click="$emit('remove-position', index)">
                    <i class='bx bx-x'></i>
                </button>
            </span>
            <input type="text" v-model="position" class=" flex-grow text-sm p-2 border-0 outline-none" @keyup.enter="addPosition">
        </div>
        <small class=" text-xs text-red-600">{{ errorMessage }}</small>
    </div>
</template>

<script setup>
import { ref } from 'vue'; 
defineProps({
    positions: Array,
    errorMessage: String
})
const position = ref('')
const emits = defineEmits(['add-position'])

const addPosition = () => {
    emits('add-position', position.value)
    position.value = '' 
}
</script>
 