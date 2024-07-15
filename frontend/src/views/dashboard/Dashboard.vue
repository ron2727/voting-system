<template>
     <div  v-if="isLoading" class=" w-screen h-screen flex items-center justify-center">
        <Loader size="lg"/>
     </div>
    <DashboardTemplate layout="w-full" v-else> 
        <template #main>
            <RouterView/>
        </template>
    </DashboardTemplate>
</template>

<script setup>
import Loader from '../../components/common/Loader.vue';
import DashboardTemplate from '../../components/layouts/DashboardTemplate.vue'
import Title from '../../components/common/Title.vue'  
import { onMounted, ref, provide, onBeforeMount } from 'vue';
import { useRouter, RouterView } from 'vue-router'
import { useAuthStore } from '../../stores/auth';  

const authStore = useAuthStore(); 
const isLoading = ref(true);
const router = useRouter();  
provide('userAuth', authStore);

onMounted(async () => {
   await authStore.getAuthUser(); 
   isLoading.value = false
   if (!authStore.user.is_admin) {
    router.push('/dashboard/vote')
   } 
   console.log(authStore.user)
}) 


</script>
 