<template>
    <div>
        <DashboardTemplate> 
            <template #head>
              <Title title="Results" subTitle="View the results of elections"></Title>
              <SubNav @getActive="getActiveMenu" :menus="['Votes', 'Winners']" defaultActive="Votes"></SubNav>
             </template>
             <template #main>
                <Card v-for="n in 3" class=" p-1"> 
                  <template #body>
                     <img src="../../assets/images/BUERE_JOHNRON1.png" alt="" class=" w-full object-cover border rounded-2xl">
                  </template>
                  <template #footer>
                    <div class=" flex justify-between items-center text-sm px-1 py-2">
                        <div>
                          <h6 class="text-lg font-bold">John Doe</h6>
                          <small class=" text-sm text-gray-500">President</small>
                        </div>
                        <div>
                          Votes: 1124(20%)
                        </div>
                    </div>
                  </template>
               </Card>
             </template>
        </DashboardTemplate> 
    </div>
</template>

<script setup>
import DashboardTemplate from '../../components/layouts/DashboardTemplate.vue'
import Title from '../../components/common/Title.vue'
import Button from '../../components/common/Button.vue';
import SubNav from '../../components/common/SubNav.vue';
import Card from '../../components/common/Card.vue';
import { onMounted, provide } from 'vue';
import { useAuthStore } from '../../stores/auth'; 


const authStore = useAuthStore(); 

provide('userAuth', authStore);

onMounted(async () => {
   await authStore.getAuthUser(); 
   console.log(authStore.user)
}) 
const getActiveMenu = (menuItem) => {
    console.log(menuItem)
}

</script>
 