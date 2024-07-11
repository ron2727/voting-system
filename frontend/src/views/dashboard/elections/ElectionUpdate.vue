<template>
    <div>
        <DashboardTemplate layout="w-full"> 
            <template #head>
              <Title title="Update voter"></Title> 
             </template>
             <template #main>  
                <Loader size="md" v-if="isLoading"/> 
                <div class="form-wrapper bg-white max-w-xl p-4 rounded-lg shadow-md space-y-3" v-else>
                 <form @submit.prevent="submitElectionForm(form)">       
                    <div class=" space-y-2">
                      <Input labelText="Title" :required="true" v-model="form.title" :errorMessage="errorsData?.title?.[0]"/>
                      <Input labelText="Description" :required="true" v-model="form.description" :errorMessage="errorsData?.description?.[0]"/>
                      <div class="text-right space-x-3">
                         <RouterLink to="/elections">
                            <Button buttonText="Cancel" class="bg-red-500"/>
                         </RouterLink>
                        <Button buttonType="submit" buttonText="Update Election" class="bg-blue-600" :disabled="isSubmitting">
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
import Loader from '../../../components/common/Loader.vue';
import DashboardTemplate from '../../../components/layouts/DashboardTemplate.vue'
import Title from '../../../components/common/Title.vue'
import Input from '../../../components/common/Input.vue';
import Selection from '../../../components/common/Selection.vue';
import Button from '../../../components/common/Button.vue';
import SubNav from '../../../components/common/SubNav.vue'; 
import { onMounted, ref, onBeforeMount, provide } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '../../../stores/auth'; 
import { getElection, storeElection, updateElection } from '../../../services/api/elections';
 

const authStore = useAuthStore(); 
const router = useRouter(); 
const route = useRoute();
const isLoading = ref(true);
const errorsData = ref([]);
const responseData = ref([]); 
const isSubmitting = ref(false);

const form = ref({
   title: "",
   description: "",  
});
provide('userAuth', authStore);
  
onBeforeMount(async () => {
   await authStore.getAuthUser(); 
   if (!authStore.user.is_admin) {
     router.push('/dashboard')
   } 
   const response = await getElection(route.params.electionId)
   storeDataToForm(response) 
   isLoading.value = false
   console.log(response.end_date)
}) 
 
const submitElectionForm = async (formData) => {  
  isSubmitting.value = true   
  const {requestResponse, errors} = await updateElection(formData, route.params.electionId)
  
  if(errors.value) {
    errorsData.value = errors.value
    console.log(errorsData.value)
  }else{
    responseData.value = requestResponse.value  
  }

  isSubmitting.value = false
}
 

const storeDataToForm = (data) => {
   for (const key in form.value) { 
     form.value[key] = data[key] 
   } 
}
  
</script>
 