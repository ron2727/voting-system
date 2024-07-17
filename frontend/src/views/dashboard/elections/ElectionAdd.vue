<template>
  <Title title="Create an election"></Title>
  <form>
    <div class="form-wrapper bg-white max-w-xl p-4 rounded-lg shadow-md space-y-3">
      <Input labelText="Title" :required="true" v-model="formData.title" :errorMessage="errorsData?.title?.[0]" />
      <Input labelText="Description" :required="true" v-model="formData.description" :errorMessage="errorsData?.description?.[0]" />
      <Listing :positions="positions" @add-position="addPosition" @remove-position="removePosition" :errorMessage="errorsData?.positions?.[0]"/>
      <div class="grid grid-cols-2 gap-3">
        <Input labelText="Start Date " v-model="formData.start_date" :inputType="'datetime-local'" :errorMessage="errorsData?.start_date?.[0]" :required="true" />
        <Input labelText="End Date" v-model="formData.end_date" :inputType="'datetime-local'" :errorMessage="errorsData?.end_date?.[0]" :required="true" />
      </div>
      <div class="text-right space-x-3">
        <RouterLink to="/dashboard/elections">
          <Button buttonText="Cancel" class="bg-red-500" />
        </RouterLink>
        <Button buttonType="button" buttonText="Create Election" class="bg-blue-600" :disabled="isSubmitting" @click="submitElectionForm()">
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
import Listing from '../../../components/common/Listing.vue';
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
const positions = ref([]);

const formData = ref({
   title: "",
   description: "",
   positions: [], 
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
const addPosition = (position) => {
    if (position !== '') {
        position = titleCase(position)
        positions.value.push(position)
        position = ''
    }
}

const removePosition = (position) => {
    positions.value = positions.value.filter((p, i) => i !== position)
}
 
const submitElectionForm = async () => { 
  isSubmitting.value = true
  const newFormData = mapFormData(formData.value)
  const {requestResponse, errors} = await storeElection(newFormData)
  
  if(errors.value) {
    errorsData.value = errors.value
    console.log(errorsData.value)
  }else{
    responseData.value = requestResponse.value 
    router.push('/dashboard/elections')
  }

  isSubmitting.value = false
}

const clearForm = () => { 
  for (const key in formData.value) {
    formData.value[key] = '';
  }
  errorsData.value = [];
}

const titleCase = (str) => {
  const arr = str.split(' ')
  let newStr = ''
  if (arr.length > 1) {
     for (let i = 0; i < arr.length; i++) { 
       arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1)
     }
     newStr = arr.join(' ')
  }else{ 
     newStr = arr[0].charAt(0).toUpperCase() + arr[0].slice(1)
  }
  return newStr;
}

const mapFormData = (form) => {  
  form.start_date = DateFormat.getDateTime(form.start_date)
  form.end_date = DateFormat.getDateTime(form.end_date)
  form.positions = JSON.stringify(positions.value)
  return form
}
</script>
 