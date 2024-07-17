<template>
   <div class="main h-screen flex items-center justify-center bg-gray-color">
     <div class="login w-[350px]">
         <h6 class=" text-center font-bold text-xl mb-2">Voting System</h6>
         <form @submit.prevent="submitForm">
           <div class=" bg-white form-container border border-gray-100 shadow-md rounded-lg p-3.5  space-y-3">
             <Input labelText="Email" v-model="formData.email" :errorMessage="authStore.errors?.email?.[0]"/>
             <Input labelText="Password" inputType="password" v-model="formData.password"/>
             <div class=" flex items-center justify-between">
                <div class=" text-xs md:text-sm">
                  Don't have an account ? <RouterLink to="/register"><span class=" text-blue-600 hover:underline">Register</span></RouterLink>
                </div>
                <Button buttonText="Login" buttonType="submit" :disabled="isSubmitting">
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
import { useRouter } from 'vue-router'; 
import { useAuthStore } from '../../stores/auth'; 

const authStore = useAuthStore(); 
const isSubmitting = ref(false)
const router = useRouter();
const formData = ref({
  email: '',
  password: ''
}) 

onMounted(async () => {
  await authStore.getAuthUser()
  authStore.authErrors = []
  console.log(authStore.user)
  if (authStore.user) {
    router.push('/dashboard/')
  }
})

const submitForm = async () => {
  isSubmitting.value = true
  await authStore.handleLogin(formData.value)
  isSubmitting.value = false
}
</script>
 