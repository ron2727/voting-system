<template>
    <div class="main h-screen flex items-center justify-center bg-gray-color">
     <div class="login w-[350px]">
         <h6 class=" text-center font-bold text-xl mb-2">Voting System</h6>
         <form @submit.prevent="submitForm">
            <div class=" bg-white form-container border border-gray-100 shadow-md rounded-lg p-3.5  space-y-3">
                <Input labelText="Student ID" v-model="formData.student_id" :errorMessage="authStore.errors?.student_id?.[0]"/>
                <Input labelText="Password" inputType="password" v-model="formData.password" :errorMessage="authStore.errors?.password?.[0]"/>
                <Input labelText="Confirm Password" inputType="password" v-model="formData.password_confirmation" :errorMessage="authStore.errors?.password?.[1]"/>
                <div class=" flex items-center justify-between">
                   <div class=" text-xs md:text-sm">
                      Have an account ? <RouterLink to="/"><span class=" text-blue-600 hover:underline">Login</span></RouterLink>
                   </div>
                   <Button buttonText="Register" buttonType="submit" :disabled="isSubmitting">
                     <i class='bx bx-loader-alt bx-xs bx-spin text-white' v-if="isSubmitting"></i>
                   </Button>
                </div> 
            </div> 
          </form>
     </div>
   </div>
</template>

<script setup>
import Input from '../../components/common/Input.vue';
import Button from '../../components/common/Button.vue'; 
import { onMounted, ref } from 'vue';
import { useAuthStore } from '../../stores/auth';  

const authStore = useAuthStore();
const isSubmitting = ref(false)
const formData = ref({
   student_id: '',
   password: '',
   password_confirmation: ''
})

onMounted(() => {
   authStore.authErrors = []
})
const submitForm = async () => {
  isSubmitting.value = true
  await authStore.handleRegister(formData.value)
  isSubmitting.value = false
}
</script>
 