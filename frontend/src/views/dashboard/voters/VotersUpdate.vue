<template> 
  <Title title="Update voter" subTitle="Update voter information"></Title>
  <Loader size="md" v-if="isLoading" />
  <form @submit.prevent="submitVoterForm(form)" v-else>
    <div class="form-wrapper bg-white max-w-xl p-4 rounded-lg shadow-md space-y-3">
      <Input labelText="Student ID" :required="true" v-model="form.student_id" :errorMessage="errorsData?.student_id?.[0]" />
      <Input labelText="First Name" :required="true" v-model="form.firstname" :errorMessage="errorsData?.firstname?.[0]" />
      <Input labelText="Last Name" :required="true" v-model="form.lastname" :errorMessage="errorsData?.lastname?.[0]" />
      <Input labelText="Email" :required="true" v-model="form.email" :errorMessage="errorsData?.email?.[0]" />
      <Selection labelText="Course" :required="true" v-model="form.course" :options="['BSIS', 'BSIT', 'BSCS']" :errorMessage="errorsData?.course?.[0]" />
      <Selection labelText="Year Level" :required="true" v-model="form.year_level" :options="['1st year', '2nd year', '3rd year', '4rth year']" :errorMessage="errorsData?.year_level?.[0]" />
      <Selection labelText="Section" :required="true" v-model="form.section" :options="['1', '2', '3']" :errorMessage="errorsData?.section?.[0]" />
      <div class="text-right space-x-3">
        <RouterLink to="/dashboard/voters">
          <Button buttonText="Cancel" class="bg-red-500" />
        </RouterLink>
        <Button buttonType="submit" buttonText="Update" class="bg-blue-600" :disabled="isSubmitting">
          <i class='bx bx-loader-alt bx-xs bx-spin text-white' v-if="isSubmitting"></i>
        </Button>
      </div>
    </div>
  </form>
</template>

<script setup> 
import Title from '../../../components/common/Title.vue' 
import Input from '../../../components/common/Input.vue';
import Selection from '../../../components/common/Selection.vue';
import Button from '../../../components/common/Button.vue';
import Loader from '../../../components/common/Loader.vue';
import { useAuthStore } from '../../../stores/auth'; 
import { onMounted, provide, ref } from 'vue';
import { RouterView, useRoute } from 'vue-router';
import { updateVoter, getVoter } from '../../../services/api/voters'

const authStore = useAuthStore(); 
const errorsData = ref([]);
const responseData = ref([]);
const isLoading = ref(true);
const isSubmitting = ref(false);
const form = ref({
   student_id: "",
   firstname: "",
   lastname: "",
   course: "",
   year_level: "",
   section: "",
   email: "",
});
const route = useRoute();
provide('userAuth', authStore);

onMounted(async () => {
   await authStore.getAuthUser(); 
   const voter = await getVoter(route.params.voterId) 
   storeDataToForm(voter.data)
   isLoading.value = false
   console.log(voter)
}) 
const submitVoterForm = async (formData) => { 
  isSubmitting.value = true
  const {requestResponse, errors} = await updateVoter(formData, route.params.voterId)
  
  if(errors.value) {
    errorsData.value = errors.value
    console.log(errorsData.value)
  }else{
    responseData.value = requestResponse.value
    console.log(responseData.value.message)
    clearForm()
  }

  isSubmitting.value = false
}

const clearForm = () => {
  const formData = form.value;
  for (const key in form.value) {
    form.value[key] = '';
  }
  errorsData.value = [];
}

const storeDataToForm = (data) => {
   for (const key in data) { 
     form.value[key] = data[key] 
   } 
}

</script>
 