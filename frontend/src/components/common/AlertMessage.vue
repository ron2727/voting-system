<template>
  <div :class="alertType === 'Success' ? 'bg-green-600/15' : 'bg-red-600/15'"
       class=" fixed right-0 bottom-0 p-4 m-5 border bg-green-600/15 rounded-xl">
     <button @click="$emit('closeAlert')" type="button" class=" absolute top-0 right-0 m-2 text-gray-600 hover:text-gray-600/60">
        <i class='bx bx-x bx-xs'></i>
     </button>
     <h6 :class="alertType === 'Success' ? 'text-green-600' : 'text-red-600'" 
          class=" text-sm font-bold mb-2">{{ alertType }}</h6>
     <p :class="alertType === 'Success' ? 'text-green-600' : 'text-red-600'" 
        class=" text-xs"><slot></slot></p>
  </div>
</template>

<script setup>
defineProps({
    alertType:{
        type: String,
        default: 'Success'
    },
})

 
</script>
 