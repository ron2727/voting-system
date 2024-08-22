<template> 
    <Title title="Results" subTitle="View the results of elections"></Title>
    <div ref="menuBar" class="menuBar-wrapper my-8 space-x-2">
        <RouterLink to="/dashboard/results">
            <button @click="setActive('votes')" :class="activeNav == 'votes' ? 'bg-white shadow' : 'text-slate-600'"
                class=" px-5 py-2 text-xs lg:text-sm rounded-lg">
                Votes Tally
            </button>
        </RouterLink>
        <RouterLink to="/dashboard/results/elections">
            <button @click="setActive('winners')" :class="activeNav == 'winners' ? 'bg-white shadow' : 'text-slate-600'"
                class="px-5 py-2 text-xs lg:text-sm rounded-lg">
                Winners
            </button>
        </RouterLink>
    </div>
    <RouterView></RouterView>
</template>

<script setup> 
import Title from '../../../components/common/Title.vue' 
import { ref, onMounted, provide } from 'vue';
import { useAuthStore } from '../../../stores/auth';  
import { RouterLink, useRouter } from 'vue-router';

const authStore = useAuthStore();
const router = useRouter();  
const activeNav = ref('votes');
provide('userAuth', authStore);

onMounted(async () => {
   await authStore.getAuthUser();
   if (!authStore.user.is_admin) {
      router.push('/dashboard/vote');
   }
     
}) 
const setActive = (active) => {
    activeNav.value = active
}
 
</script>
 