<template>
    <div> 
     <RouterLink :to="link">
        <div class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-color">
          <slot name="icon"></slot>
          <span class=" text-sm">
            {{navText}}
          </span>
         </div>
     </RouterLink>              
    </div>
</template>

<script setup>
defineProps({
    navText: {
        type: String
    },
    link: {
        type: String
    }
})
</script> 