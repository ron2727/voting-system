<template>
    <DashboardTemplate layout="w-full"> 
        <template #main>
            <RouterView/>
        </template>
    </DashboardTemplate>
</template>

<script setup>
import DashboardTemplate from '../../components/layouts/DashboardTemplate.vue'
import Title from '../../components/common/Title.vue'  
import { onMounted, ref, provide, onBeforeMount } from 'vue';
import { useRouter, RouterView } from 'vue-router'
import { useAuthStore } from '../../stores/auth';  

const authStore = useAuthStore(); 
const router = useRouter();  
provide('userAuth', authStore);

onMounted(async () => {
   await authStore.getAuthUser(); 
   if (!authStore.user.is_admin) {
    router.push('/dashboard/vote')
   } 
   console.log(authStore.user)
}) 


</script>
 