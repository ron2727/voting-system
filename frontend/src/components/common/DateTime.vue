<template>
    <div class="input">
       <input type="datetime-local" :class="[errorMessage ? 'border-red-300 focus:ring-red-600/60' : 'border-gray-300 focus:ring-blue-700/60']" 
              class="w-full border text-sm outline-none rounded-md p-2 focus:ring-2 focus:ring-offset-1">
    </div>
</template>

<script setup>

</script>
 