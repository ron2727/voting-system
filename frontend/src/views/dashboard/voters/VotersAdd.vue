<template>
    <div>
        <DashboardTemplate layout="w-full"> 
            <template #head>
              <Title title="Add new voter"></Title> 
             </template>
             <template #main> 
                <form @submit.prevent="submitVoterForm(form)">       
                  <div class="form-wrapper bg-white max-w-xl p-4 rounded-lg shadow-md space-y-3">
                    <Input labelText="Student ID" :required="true" v-model="form.student_id" :errorMessage="errorsData?.student_id?.[0]"/>
                    <Input labelText="First Name" :required="true" v-model="form.firstname" :errorMessage="errorsData?.firstname?.[0]"/>
                    <Input labelText="Last Name" :required="true" v-model="form.lastname" :errorMessage="errorsData?.lastname?.[0]"/>
                    <Input labelText="Email" :required="true" v-model="form.email" :errorMessage="errorsData?.email?.[0]"/>  
                    <Selection labelText="Course" :required="true" v-model="form.course" :options="['BSIS', 'BSIT', 'BSCS']" :errorMessage="errorsData?.course?.[0]"/>
                    <Selection labelText="Year Level" :required="true" v-model="form.year_level" :options="['1st year', '2nd year', '3rd year', '4rth year']" :errorMessage="errorsData?.year_level?.[0]"/>
                    <Selection labelText="Section" :required="true" v-model="form.section" :options="['1', '2', '3']" :errorMessage="errorsData?.section?.[0]"/>
                    <div class="text-right space-x-3">
                       <RouterLink to="/voters">
                          <Button buttonText="Cancel" class="bg-red-500"/>
                       </RouterLink>
                       <Button buttonType="submit" buttonText="Add new voter" class="bg-blue-600" :disabled="isSubmitting">
                         <i class='bx bx-loader-alt bx-xs bx-spin text-white' v-if="isSubmitting"></i>
                       </Button>
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
import { useAuthStore } from '../../../stores/auth'; 
import { onMounted, provide, ref } from 'vue';
import { RouterView } from 'vue-router';
import { storeVoter } from '../../../services/api/voters'

const authStore = useAuthStore(); 
const errorsData = ref([]);
const responseData = ref([]);
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

provide('userAuth', authStore);

onMounted(async () => {
   await authStore.getAuthUser(); 
   console.log(authStore.user)
}) 
const submitVoterForm = async (formData) => { 
  isSubmitting.value = true
  const {requestResponse, errors} = await storeVoter(formData)
  
  if(errors.value) {
    errorsData.value = errors.value
    console.log(errorsData.value)
  }else{
    responseData.value = requestResponse.value
    console.log(responseData.value.data[0].message)
    clearForm()
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
 