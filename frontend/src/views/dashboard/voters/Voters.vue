<template> 
  <Title title="Voters" subTitle="View and manage voters"></Title>
  <RouterLink to="/dashboard/voter/add" v-if="!loading">
    <Button buttonText="Add new voter" class="my-10">
      <i class='bx bx-plus'></i>
    </Button>
  </RouterLink>
  <Loader size="md" v-if="loading" />
  <Table v-else :dataTable="votersData" @change-page="changePage" @open-delete-modal="openDeleteModal"></Table>
  <Modal @close-modal="isDeleteModalOpen = false" v-if="isDeleteModalOpen">
    <template #title>Delete Voter</template>
    <template #body>Are you sure you want to delete this voter <span class=" font-bold">{{ voterToBeDeleted.firstname }}
        {{ voterToBeDeleted.lastname }}</span>?</template>
    <template #footer>
      <div class="flex justify-end space-x-2">
        <button @click="isDeleteModalOpen = false"
          class=" text-xs px-2.5 py-1.5 md:px-3 md:py-2 border rounded-md">Cancel</button>
        <button @click="submitVoterToDelete"
          class=" text-xs px-2.5 py-1.5 md:px-3 md:py-2 bg-red-600 text-white rounded-md" :disabled="isSubmitting">
          <i class='bx bx-loader-alt bx-xs bx-spin text-white' v-if="isSubmitting"></i> Yes, Delete</button>
      </div>
    </template>
  </Modal>
</template>

<script setup>
import Loader from '../../../components/common/Loader.vue';
import Title from '../../../components/common/Title.vue'
import Button from '../../../components/common/Button.vue';
import Table from '../../../components/common/Table.vue';
import Modal from '../../../components/common/Modal.vue';
import { onMounted, onBeforeMount, provide, ref } from 'vue';
import { useAuthStore } from '../../../stores/auth';
import { useRouter } from 'vue-router';
import { getVoters, deleteVoter } from '../../../services/api/voters'

const authStore = useAuthStore();
const router = useRouter();
const loading = ref(true);
const votersData = ref([]);
const voterToBeDeleted = ref('')
const isDeleteModalOpen = ref(false);
const isSubmitting = ref(false);

provide('userAuth', authStore);

onBeforeMount(async () => {
  await authStore.getAuthUser();
  if (!authStore.user.is_admin) {
    router.push('/vote')
  }
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
  isSubmitting.value = true
  const response = await deleteVoter(voterToBeDeleted.value.id)
  console.log(response)
  await removeVoterInTable()
  isSubmitting.value = false
  isDeleteModalOpen.value = false
}
const removeVoterInTable = async () => {
  const url = `${votersData.value.meta.path}?page=${votersData.value.meta.current_page}`;
  votersData.value = await getVoters(url)
}

</script>

<style scoped>
[disabled] {
  opacity: 0.9;
  cursor: not-allowed;
}
</style>