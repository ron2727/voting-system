<template>
    <div> 
        <DashboardTemplate></DashboardTemplate>
    </div>
</template>

<script setup>
import DashboardTemplate from '../../components/layouts/DashboardTemplate.vue'
import { onMounted, ref, provide, onBeforeMount } from 'vue';
import { useAuthStore } from '../../stores/auth'; 


const authStore = useAuthStore(); 

provide('userAuth', authStore);

onMounted(async () => {
   await authStore.getAuthUser(); 
   console.log(authStore.user)
}) 
</script>
 