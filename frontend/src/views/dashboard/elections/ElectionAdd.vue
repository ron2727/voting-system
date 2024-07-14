<template>
  <Title title="Create an election"></Title>
  <form @submit.prevent="submitElectionForm(form)">
    <div class="form-wrapper bg-white max-w-xl p-4 rounded-lg shadow-md space-y-3">
      <Input labelText="Title" :required="true" v-model="form.title" :errorMessage="errorsData?.title?.[0]" />
      <Input labelText="Description" :required="true" v-model="form.description"
        :errorMessage="errorsData?.description?.[0]" />
      <div class="grid grid-cols-2 gap-3">
        <Input labelText="Start Date " v-model="form.start_date" :inputType="'datetime-local'"
          :errorMessage="errorsData?.start_date?.[0]" :required="true" />
        <Input labelText="End Date" v-model="form.end_date" :inputType="'datetime-local'"
          :errorMessage="errorsData?.end_date?.[0]" :required="true" />
      </div>
      <div class="text-right space-x-3">
        <RouterLink to="/dashboard/elections">
          <Button buttonText="Cancel" class="bg-red-500" />
        </RouterLink>
        <Button buttonType="submit" buttonText="Create Election" class="bg-blue-600" :disabled="isSubmitting">
          <i class='bx bx-loader-alt bx-xs bx-spin text-white' v-if="isSubmitting"></i>
        </Button>
      </div>
    </div>
  </form>
</template>

<script setup> 
import Title from '../../../components/common/Title.vue'
import Input from '../../../components/common/Input.vue'; 
import Button from '../../../components/common/Button.vue'; 
import { onMounted, ref, onBeforeMount, provide } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '../../../stores/auth'; 
import { getElections, storeElection } from '../../../services/api/elections';
import { DateFormat } from '../../../services/dateFormat';

const authStore = useAuthStore(); 
const router = useRouter();
const route = useRoute();
const elections = ref([]);
const errorsData = ref([]);
const responseData = ref([]);
const isSubmitting = ref(false);
const form = ref({
   title: "",
   description: "", 
   start_date: "",
   end_date: "",
});
provide('userAuth', authStore);
  
onBeforeMount(async () => {
   await authStore.getAuthUser(); 
   if (!authStore.user.is_admin) {
     router.push('/dashboard')
   }
   elections.value = await getElections(); 
   console.log(authStore.user)
}) 
 
const submitElectionForm = async (formData) => {
  isSubmitting.value = true
  formData.start_date = DateFormat.getDateTime(formData.start_date)
  formData.end_date = DateFormat.getDateTime(formData.end_date)
    
  const {requestResponse, errors} = await storeElection(formData)
  
  if(errors.value) {
    errorsData.value = errors.value
    console.log(errorsData.value)
  }else{
    responseData.value = requestResponse.value 
    router.push('/elections')
  }

  isSubmitting.value = false
}

const clearForm = () => { 
  for (const key in form.value) {
    form.value[key] = '';
  }
  errorsData.value = [];
}
</script>
 