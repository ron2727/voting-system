<template>
    <div class="input-file flex flex-col items-center py-4 border rounded-md">
        <div v-if="selectedFileName != ''" class=" text-xs bg-black/10 p-2 flex items-center space-x-1 rounded-md">
            <i class='bx bx-photo-album bx-sm'></i>
            <span>{{ selectedFileName }}</span>
            <button type="button" class="flex items-center justify-center w-4 h-4 bg-gray-400 rounded-full" @click="removeFile()"><i class='bx bx-x'></i></button>
        </div>
        <button type="button" class=" flex flex-col items-center" @click="inputFile.click()">
            <i class='bx bx-download text-2xl md:text-3xl mt-2'></i>
            <span class=" text-xs md:text-sm text-gray-600">Change photo</span>
        </button>
       <input ref="inputFile" @change="fileChange"
              type="file"  
              class="hidden" 
              placeholder="Upload file"> 
    </div>
</template>

<script setup>
import { ref } from 'vue' 

const emits = defineEmits(['select-file', 'remove-file'])
const inputFile = ref(null)
const selectedFileName = ref('')
const fileChange = (e) => {
     const file = e.target.files[0]
     emits('select-file', file) 
     selectedFileName.value = file.name 
}
const removeFile = () => { 
     selectedFileName.value = ''  
     emits('remove-file') 
}

</script> 