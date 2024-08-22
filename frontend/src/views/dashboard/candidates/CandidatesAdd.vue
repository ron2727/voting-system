<template> 
  <Title title="Add new candidate" sub-title="Create new candidate for election"></Title>
  <Loader size="md" v-if="isLoading" />
  <form @submit.prevent="submitCandidateForm()" v-else>
    <input type="hidden" v-model="form.user_id">
    <div class="form-wrapper bg-white max-w-xl p-4 rounded-lg shadow-md space-y-3">
      <AlertMessage v-if="alert.isOpen" :alertType="alert.type" @closeAlert="alert.isOpen = false">{{ alert.message }}
      </AlertMessage>
      <div class=" select-candidate-wrapper" @click="openModal">
        <span class=" text-sm">Select Candidate <span class="text-red-500">*</span></span>
        <div v-if="selectedToBeCandidate.firstname === ''"
          class=" flex flex-col items-center border cursor-pointer hover:ring-2 hover:ring-offset-1 border-gray-300 rounded-lg py-5">
          <i class='bx bx-search-alt-2 bx-lg text-blue-600'></i>
          <p class=" text-sm text-gray-500">Choose candidate</p>
        </div>
        <div v-else class="voter flex flex-col items-center py-2 rounded-lg border border-gray-300 cursor-pointer">
          <img :src="selectedToBeCandidate.profile_image" alt="voter"
            class=" w-[50px] h-[50px] border rounded-full object-cover">
          <span class=" text-sm font-bold">{{ selectedToBeCandidate.firstname }} {{ selectedToBeCandidate.lastname
            }}</span>
          <span class=" text-xs text-gray-600">{{ selectedToBeCandidate.course }} {{
            selectedToBeCandidate.year_level }}</span>
        </div>
        <small class=" text-sm text-red-600">{{ errorsData?.user_id?.[0] }}</small>
      </div>
      <Selection labelText="Position" :required="true" v-model="form.position"
        :options="positions"
        :errorMessage="errorsData?.position?.[0]" />
      <div class="text-right space-x-3">
        <RouterLink to="/dashboard/elections">
          <Button buttonText="Cancel" class="bg-red-500" />
        </RouterLink>
        <Button buttonType="submit" buttonText="Add Candidate" class="bg-blue-600" :disabled="isSubmitting">
          <i class='bx bx-loader-alt bx-xs bx-spin text-white' v-if="isSubmitting"></i>
        </Button>
      </div>
    </div>
  </form>

  <Modal @close-modal="isModalOpen = false" v-if="isModalOpen">
    <template #body>
      <div class="input-search mb-5 flex justify-end">
        <div class=" relative w-min">
          <input v-model="search" type="text" class=" w-52 border border-gray-200 rounded-lg outline-none text-sm p-2"
            placeholder="Search">
          <button type="button" class=" absolute right-0 top-0 bg-blue-600 px-2 pt-1 rounded-r-lg h-full"
            @click="findVoters">
            <i class='bx bx-search-alt-2 bx-xs text-white'></i>
          </button>
        </div>
      </div>
      <div class="content-wrapper h-[300px] overflow-y-auto">
        <Loader size="sm" v-if="isModalLoading" />
        <div class=" grid grid-cols-3 gap-3" v-else>
          <div class="voter flex flex-col items-center py-2 rounded-lg border border-gray-300 cursor-pointer"
            v-for="voter in voters" :key="voter.id" @click="selectVoter(voter)">
            <img :src="voter.profile_image" alt="voter" class=" w-[50px] h-[50px] border rounded-full object-cover">
            <span class=" text-sm font-bold">{{ voter.firstname }} {{ voter.lastname }}</span>
            <span class=" text-xs text-gray-600">{{ voter.course }} {{ voter.year_level }}</span>
          </div>
        </div>
      </div>
    </template>
  </Modal>
</template>

<script setup>  
import Title from '../../../components/common/Title.vue' 
import Selection from '../../../components/common/Selection.vue';
import Button from '../../../components/common/Button.vue'; 
import Modal from '../../../components/common/Modal.vue';
import AlertMessage from '../../../components/common/AlertMessage.vue';
import Loader from '../../../components/common/Loader.vue';
import { onMounted, ref, onBeforeMount, provide } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '../../../stores/auth'; 
import { getElections, getElection } from '../../../services/api/elections';
import { getRandomVoters, searchVoters } from '../../../services/api/voters';
import { storeCandidate } from '../../../services/api/candidates';
import { DateFormat } from '../../../services/dateFormat'; 

const authStore = useAuthStore(); 
const router = useRouter();
const route = useRoute(); 
const isLoading = ref(true);
const positions = ref(null)
const errorsData = ref([]);
const responseData = ref([]);
const isSubmitting = ref(false)

const isModalOpen = ref(false);
const isModalLoading = ref(false);
const voters = ref([]);
const search = ref('');

const alert = ref({
  isOpen: false,
  type: '',
  message: '',
});

const selectedToBeCandidate = ref({
  firstname: '',
  lastname: '',
  course: '',
  year_level: '',
  profile_image: '', 
});

const form = ref({
   election_id: "",
   user_id: "",
   position: "",  
});

provide('userAuth', authStore);
  
onBeforeMount(async () => {
   await authStore.getAuthUser(); 
   voters.value = await getRandomVoters();
   form.value.election_id = route.params.electionId;
   if (!authStore.user.is_admin) {
     router.push('/dashboard/vote')
   }
   const elections = await getElection(route.params.electionId); 
   setPositions(elections.positions)
   isLoading.value = false 
}) 
 
const submitCandidateForm = async () => { 
  isSubmitting.value = true  
  const {requestResponse, errors} = await storeCandidate(form.value)
  
  if(errors.value) {
    errorsData.value = errors.value
    if (errorsData.value?.candidate) { 
      showAlert('Error', errorsData.value.candidate)
    }
    console.log(errorsData.value)
  }else{
    responseData.value = requestResponse.value 
    showAlert('Success', 'Candidate added successfully')
    clearForm()
  }
  isSubmitting.value = false
}

const showAlert = (type, message) => {
  alert.value.isOpen = true;
  alert.value.type = type;
  alert.value.message = message;
} 
const clearForm = () => {   
  form.value.user_id = ''
  form.value.position = ''
  for (const key in selectedToBeCandidate.value) { 
    selectedToBeCandidate.value[key] = ''
  }
  errorsData.value = [];
}
 
const openModal = () => {
  isModalOpen.value = true
  console.log(voters.value)
} 

const findVoters = async () => {
  isModalLoading.value = true
  if (search.value !== '') {
    voters.value = await searchVoters(search.value)
  }else{
    voters.value = await getRandomVoters()
  }
  isModalLoading.value = false
}

const selectVoter = (voter) => {  
  form.value.user_id = voter.id;  
  for (const key in selectedToBeCandidate.value) { 
    selectedToBeCandidate.value[key] = voter[key]
  } 
  isModalOpen.value = false
}

const setPositions = (positionsArr) => {
  positions.value = JSON.parse(positionsArr)
}
</script>
 
 