<template>
    <div>
        <DashboardTemplate layout="w-full"> 
            <template #head>
              <Title title="Voters" subTitle="View and manage voters"></Title>
              <RouterLink to="/voter/add">
                <Button buttonText="Add new voter" class="mt-10">
                  <i class='bx bx-plus'></i> 
                </Button>
              </RouterLink>
              </template>
             <template #main> 
                <Table :dataTable="votersData"></Table>
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
import Table from '../../../components/common/Table.vue';
import { onMounted, provide, ref } from 'vue';
import { useAuthStore } from '../../../stores/auth'; 
import { RouterView } from 'vue-router';
import { getVoters } from '../../../services/api/voters'

const authStore = useAuthStore(); 
const votersData = ref([]);
provide('userAuth', authStore);

onMounted(async () => {
   await authStore.getAuthUser(); 
   votersData.value = await getVoters() 
   console.log(votersData.value)
  
}) 
const getActiveMenu = (menuItem) => {
    console.log(menuItem)
}


</script>
 