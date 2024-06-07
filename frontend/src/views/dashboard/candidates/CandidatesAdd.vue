<template>
  <div>
    <Modal :status="isModalOpen" @close-modal="isModalOpen = false">
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
          <div class=" flex justify-center py-5" v-if="voters?.message">
            <p>{{ voters?.message }}</p>
          </div>
          <div class=" grid grid-cols-3 gap-3" v-else>
            <div class="voter flex flex-col items-center py-2 rounded-lg border border-gray-300 cursor-pointer"
              v-for="voter in voters" :key="voter.id" @click="selectVoter(voter)">
              <img src="../../../assets/images/BUERE_JOHNRON1.png" alt="voter"
                class=" w-[50px] h-[50px] border rounded-full object-cover">
              <span class=" text-sm font-bold">{{ voter.firstname }} {{ voter.lastname }}</span>
              <span class=" text-xs text-gray-600">{{ voter.course }} {{ voter.year_level }}</span>
            </div>
          </div>
        </div>
      </template>
    </Modal>
    <DashboardTemplate layout="w-full">
      <template #head>
        <Title title="Add new candidate"></Title>
      </template>
      <template #main>
        <form @submit.prevent="submitCandidateForm(form)">
          <input type="hidden" v-model="form.user_id">
          <div class="form-wrapper bg-white max-w-xl p-4 rounded-lg shadow-md space-y-3">
            <div v-if="errorsData?.candidate" class=" alert py-2 text-center border border-red-600 bg-red-100 text-red-600 text-sm">
              {{ errorsData?.candidate }}
            </div>
            <div class=" select-candidate-wrapper" @click="openModal">
              <span class=" text-sm">Select Candidate <span class="text-red-500">*</span></span>
              <div v-if="selectedToBeCandidate.firstname === ''"
                class=" flex flex-col items-center border cursor-pointer hover:ring-2 hover:ring-offset-1 border-gray-300 rounded-lg py-5">
                <i class='bx bx-search-alt-2 bx-lg text-blue-600'></i>
                <p class=" text-sm text-gray-500">Choose candidate</p>
              </div>
              <div v-else
                class="voter flex flex-col items-center py-2 rounded-lg border border-gray-300 cursor-pointer">
                <img src="../../../assets/images/BUERE_JOHNRON1.png" alt="voter"
                  class=" w-[50px] h-[50px] border rounded-full object-cover">
                <span class=" text-sm font-bold">{{ selectedToBeCandidate.firstname }} {{ selectedToBeCandidate.lastname
                  }}</span>
                <span class=" text-xs text-gray-600">{{ selectedToBeCandidate.course }} {{
                  selectedToBeCandidate.year_level }}</span>
              </div>
              <small class=" text-sm text-red-600">{{ errorsData?.user_id?.[0] }}</small>
            </div>
            <Selection labelText="Position" :required="true" v-model="form.position"
              :options="['President', 'Vice President', 'Secretary', 'Treasurer']"
              :errorMessage="errorsData?.position?.[0]" />
            <div class="text-right space-x-3">
              <RouterLink to="/elections">
                <Button buttonText="Cancel" class="bg-red-500" />
              </RouterLink>
              <Button buttonType="submit" buttonText="Add Candidate" class="bg-blue-600" />
            </div>
          </div>
        </form>
      </template>
    </DashboardTemplate>
  </div>
</template>

<script setup>
import DashboardTemplate from '../../../components/layouts/DashboardTemplate.vue'
import Title from '../../../components/common/Title.vue'
import Input from '../../../components/common/Input.vue';
import Selection from '../../../components/common/Selection.vue';
import Button from '../../../components/common/Button.vue';
import SubNav from '../../../components/common/SubNav.vue'; 
import Modal from '../../../components/common/Modal.vue';
import { onMounted, ref, onBeforeMount, provide } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '../../../stores/auth'; 
import { getElections, storeElection } from '../../../services/api/elections';
import { getRandomVoters, searchVoters } from '../../../services/api/voters';
import { storeCandidate } from '../../../services/api/candidates';
import { DateFormat } from '../../../services/dateFormat'; 

const authStore = useAuthStore(); 
const router = useRouter();
const route = useRoute();
const elections = ref([]);
const errorsData = ref([]);
const responseData = ref([]);

const isModalOpen = ref(false);
const voters = ref([]);
const search = ref('');
const selectedToBeCandidate = ref({
  firstname: '',
  lastname: '',
  course: '',
  year_level: '',
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
     router.push('/dashboard')
   }
   elections.value = await getElections(); 
   console.log(authStore.user) 
}) 
 
const submitCandidateForm = async (formData) => { 
    
   const {requestResponse, errors} = await storeCandidate(formData)
  
  if(errors.value) {
    errorsData.value = errors.value
    console.log(errorsData.value)
  }else{
    responseData.value = requestResponse.value 
    clearForm()
  }
}

const clearForm = () => { 
  for (const key in form.value) {
    if (!key === 'election_id') {
      form.value[key] = '';
    }
  }
  errorsData.value = [];
}
 
const openModal = () => {
  isModalOpen.value = true
  console.log(voters.value)
} 

const findVoters = async () => {
  if (search.value !== '') {
    voters.value = await searchVoters(search.value)
  }else{
    voters.value = await getRandomVoters()
  }
}

const selectVoter = (voter) => { 
  form.value.user_id = voter.id;  
  selectedToBeCandidate.value = voter;
  isModalOpen.value = false
}
</script>
 