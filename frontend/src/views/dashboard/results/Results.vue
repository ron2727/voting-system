<template>
    <div>
        <DashboardTemplate layout="w-full">
            <template #head>
                <Title title="Results" subTitle="View the results of elections"></Title>
                <div ref="menuBar" class="menuBar-wrapper space-x-2">
                    <RouterLink to="/results">
                        <button @click="setActive('votes')" 
                                :class="activeNav == 'votes' ? 'bg-white shadow' : 'text-slate-600'" 
                                class=" px-5 py-2 text-sm rounded-lg">
                            Votes Tally
                        </button>
                    </RouterLink>
                    <RouterLink to="/results/elections">
                        <button  @click="setActive('winners')" 
                                :class="activeNav == 'winners' ? 'bg-white shadow' : 'text-slate-600'" 
                                class="px-5 py-2 text-sm rounded-lg">
                            Winners
                        </button>
                    </RouterLink>
                </div>
            </template>
            <template #main>
                <RouterView></RouterView>
            </template>
        </DashboardTemplate>
    </div>
</template>

<script setup>
import DashboardTemplate from '../../../components/layouts/DashboardTemplate.vue'
import Title from '../../../components/common/Title.vue'
import Button from '../../../components/common/Button.vue';
import SubNav from '../../../components/common/SubNav.vue';
import Card from '../../../components/common/Card.vue'; 
import { ref, onMounted, onBeforeMount, provide } from 'vue';
import { useAuthStore } from '../../../stores/auth';  
import { RouterLink } from 'vue-router';

const authStore = useAuthStore();  
const activeNav = ref('votes');
provide('userAuth', authStore);

onBeforeMount(async () => {
   await authStore.getAuthUser();  
}) 
const setActive = (active) => {
    activeNav.value = active
}
 
</script>
 