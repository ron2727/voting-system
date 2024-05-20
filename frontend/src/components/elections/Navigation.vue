<template>
    <div class="menuBar-wrapper space-x-2">
       <button v-for="menu in menus" class="px-3 py-2">
          {{ menu }}
       </button>    
    </div>
</template>

<script setup>
import { ref } from 'vue'

const menus = ref([ 
    'Active',
    'Completed',
])


</script>
 