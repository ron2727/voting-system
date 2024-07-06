<template>
    <div>
        <Modal @close-modal="isDeleteModalOpen = false" v-if="isDeleteModalOpen">
           <template #title>Delete Voter</template>
           <template #body>Are you sure you want to delete this voter <span class=" font-bold">{{ voterToBeDeleted.firstname }} {{ voterToBeDeleted.lastname }}</span>?</template>
           <template #footer>
             <div class="flex justify-end space-x-2">
               <Button buttonText="No" @click="isDeleteModalOpen = false"></Button>
               <Button buttonText="Yes" bgColor="bg-red-600" @click="submitVoterToDelete"></Button>
             </div>
           </template>
        </Modal>
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
                <div v-if="loading">Loading</div>
                <Table v-else :dataTable="votersData" @change-page="changePage" @open-delete-modal="openDeleteModal"></Table>
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
import Modal from '../../../components/common/Modal.vue';
import { onMounted, onBeforeMount, provide, ref } from 'vue';
import { useAuthStore } from '../../../stores/auth'; 
import { RouterView } from 'vue-router';
import { getVoters, deleteVoter } from '../../../services/api/voters'

const authStore = useAuthStore(); 
const loading = ref(true);
const votersData = ref([]);
const voterToBeDeleted = ref('')
const isDeleteModalOpen = ref(false);

provide('userAuth', authStore);

onBeforeMount(async () => {
   await authStore.getAuthUser(); 
   votersData.value = await getVoters()
   loading.value = false  
   
}) 
const changePage = async (page) => {
  votersData.value = await getVoters(page)  
}

const openDeleteModal = (voterData) => {
  isDeleteModalOpen.value = true
  voterToBeDeleted.value = voterData 
}

const submitVoterToDelete = async () => { 
  const response = await deleteVoter(voterToBeDeleted.value.id)
  console.log(response)
  await removeVoterInTable()
  isDeleteModalOpen.value = false
}
const removeVoterInTable = async () => {
  const url = `${votersData.value.meta.path}?page=${votersData.value.meta.current_page}`;
  votersData.value = await getVoters(url)
}
// const removeVoterInTable = () => {
//   const voters = votersData.value.data
//   votersData.value.data = voters.filter(voter => voter.id !== voterToBeDeleted.value.id)
// }

</script>
 