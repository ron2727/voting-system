<template>
  <div>
    <DashboardTemplate layout="w-full">
      <template #head>
        <Title title="User settings" subTitle="Update your account information"></Title>
      </template>
      <template #main>
        <Loader size="md" v-if="isLoading"/> 
        <div class="form-wrapper bg-white max-w-xl p-4 rounded-lg shadow-md" v-else>
         <form @submit.prevent="submitVoterForm()" enctype="multipart/form-data">
            <div class=" space-y-3">
              <AlertMessage v-if="alert.isOpen" :alertType="alert.type" @closeAlert="alert.isOpen = false">{{alert.message }}</AlertMessage>
              <Input labelText="Student ID" :required="true" v-model="form.student_id":errorMessage="errorsData?.student_id?.[0]" />
              <Input labelText="First Name" :required="true" v-model="form.firstname":errorMessage="errorsData?.firstname?.[0]" />
              <Input labelText="Last Name" :required="true" v-model="form.lastname":errorMessage="errorsData?.lastname?.[0]" />
              <Input labelText="Email" :required="true" v-model="form.email" :errorMessage="errorsData?.email?.[0]" />
              <Selection labelText="Course" :required="true" v-model="form.course" :options="['BSIS', 'BSIT', 'BSCS']":errorMessage="errorsData?.course?.[0]" />
              <Selection labelText="Year Level" :required="true" v-model="form.year_level"
                :options="['1st year', '2nd year', '3rd year', '4rth year']" :errorMessage="errorsData?.year_level?.[0]" />
              <Selection labelText="Section" :required="true" v-model="form.section" :options="['1', '2', '3']":errorMessage="errorsData?.section?.[0]" />
              <FileInput @select-file="selectFile" @remove-file="removeFilePhoto()" :errorMessage="errorsData?.profile_image?.[0]"/>
              <div class="text-right space-x-3">
                <Button buttonType="submit" buttonText="Update" class="bg-blue-600" :disabled="isSubmitting">
                  <i class='bx bx-loader-alt bx-xs bx-spin text-white' v-if="isSubmitting"></i>
                </Button>
              </div>
            </div>
         </form> 
       </div>
      </template>
    </DashboardTemplate>
  </div>
</template>

<script setup>
import Loader from '../../components/common/Loader.vue';
import DashboardTemplate from '../../components/layouts/DashboardTemplate.vue'
import Title from '../../components/common/Title.vue' 
import Input from '../../components/common/Input.vue';
import Selection from '../../components/common/Selection.vue';
import Button from '../../components/common/Button.vue';
import AlertMessage from '../../components/common/AlertMessage.vue';
import FileInput from '../../components/common/FileInput.vue';
import { useAuthStore } from '../../stores/auth'; 
import { onMounted, provide, ref } from 'vue';
import { RouterView, useRoute } from 'vue-router';
import { updateVoter, getVoter } from '../../services/api/voters'
import axios from 'axios';

const authStore = useAuthStore();  
const isLoading = ref(true);
const isSubmitting = ref(false)
const errorsData = ref([]);
const responseData = ref([]);
const form = ref({
   student_id: "",
   firstname: "",
   lastname: "",
   course: "",
   year_level: "",
   section: "",
   email: "",
   profile_image: "",
});
const alert = ref({
  isOpen: false,
  type: 'success',
  message: 'Updated successfully',
});

provide('userAuth', authStore);

onMounted(async () => {
   await authStore.getAuthUser();  
   storeDataToForm(authStore.user)
   isLoading.value = false
   console.log(authStore.user)
}) 
const submitVoterForm = async () => {  
  isSubmitting.value = true 
  const {requestResponse, errors} = await updateVoter(getFormData(), authStore.user.id)
  
  if(errors.value) {
    errorsData.value = errors.value 
    openAlert('error')
    console.log(errorsData.value)
  }else{
    responseData.value = requestResponse.value 
    openAlert('success')
    errorsData.value = []
    console.log(responseData.value.data) 
  }
  isSubmitting.value = false
}
 

const storeDataToForm = (data) => {
   for (const key in form.value) { 
    if (key === "profile_image") {
      continue
    }
     form.value[key] = data[key] 
   } 
}

const submitTest = async () => {
  const response = await axios.post('/api/testrequest', getFormData())
  console.log(response.data)  
  // console.log(getFormData())
}
const selectFile = async (file) => { 
  form.value.profile_image = file
}

const getFormData = () => {
  const formData = new FormData();
  if (form.value.profile_image == '') {
    delete form.value.profile_image
    console.log(form.value)
  }
  for (const key in form.value) {
    formData.append(key, form.value[key]);
  }
  return formData
}

const removeFilePhoto = () => {
  form.value.profile_image = ''
}

const openAlert = (type) => {
  const message = {
    success: 'Updated successfully',
    error: 'Failed to update',
  }
  alert.value.isOpen = true
  alert.value.type = type
  alert.value.message = message[type]
}
</script>
 