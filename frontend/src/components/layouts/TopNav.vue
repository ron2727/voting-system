<template>
    <nav class="relative z-0">
      <div class="w-full flex justify-between py-2 px-3 md:px-6 border bg-white">
         <button id="openNav" @click="$emit('openNav')">
            <i class='bx bx-menu bx-md'></i>
         </button >
         <Dropdown>
            <template #head>
              <img :src="userAuth.user?.profile_image" alt="user-image" class=" w-12 h-12 object-cover rounded-full border">
            </template> 
            <template #body>
                <ul class="text-sm divide-y">
                    <li class="dropdown-header">
                       <div class="p-2">
                          <h6 class="font-bold text-sm text-gray-600">{{ userAuth.user?.firstname }} {{ userAuth.user?.lastname }}</h6>
                          <small class="text-xs text-gray-500">{{ getUserRole() }}</small>
                       </div>
                    </li>
                    <li>
                      <button @click="userAuth.handleLogout()" class="dropdown-item p-2">
                        Logout
                      </button>
                    </li>
                </ul>
             </template> 
         </Dropdown>  
      </div>
    </nav>
</template>

<script setup> 
import Dropdown from '../common/Dropdown.vue'
import { inject } from 'vue'; 


const userAuth = inject('userAuth');  
const getUserRole = () => {
  return userAuth.user?.is_admin ? 'Admin' : 'Voter';
}
</script>
 