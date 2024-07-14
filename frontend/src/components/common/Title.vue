<template>
    <div class="mb-10">
       <h1 class="text-xl lg:text-3xl font-bold">
         {{title}}
       </h1>
       <h6 class=" text-xs lg:text-sm text-gray-500">{{subTitle}}</h6>
    </div>
</template>
 
<script setup>
 defineProps({
   title: {
     type: String
   },
   subTitle: {
     type: String
   }
 })
</script>