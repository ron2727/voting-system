<template>
    <div :class="alertType === 'error' ? 'border-red-600 bg-red-100 text-red-600' :  ' border-green-600 bg-green-100 text-green-600'"
        class=" relative alert py-2 text-sm text-center border"
        >
        <slot></slot>
        <button class=" absolute top-0 right-0 mt-0.5 mr-1 text-black font-bold" @click="$emit('close-alert')">
            <i class='bx bx-x bx-xs'></i>
        </button>
    </div>
</template>

<script setup>
defineProps({
    alertType:{
        type: String,
        default: 'success'
    },
})

 
</script>
 