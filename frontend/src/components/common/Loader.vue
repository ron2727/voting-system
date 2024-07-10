<template>
    <div class=" flex justify-center py-3"> 
        <i :class="loadingSize[size]" class='bx bx-loader-alt bx-spin text-blue-700'></i> 
    </div>
</template>
 
<script setup>
import { ref } from 'vue';
defineProps({
    size:{
        type: String,
        default: 'lg'
    } 
})

const loadingSize = {
    xs: 'bx-xs',
    sm: 'bx-sm',
    md: 'bx-md',
    lg: 'bx-lg',
}
</script>