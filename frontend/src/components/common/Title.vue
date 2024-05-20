<template>
    <div>
       <h1 class=" text-3xl font-bold">
         {{title}}
       </h1>
       <h6 class=" text-sm text-gray-500">{{subTitle}}</h6>
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