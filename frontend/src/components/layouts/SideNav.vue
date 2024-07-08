<template>
    <nav class=" fixed top-0 left-0 z-10 bg-white h-full border px-5">
       <div class=" w-52">
           <h6 class="text-2xl font-bold py-7 px-2">VOTING SYSTEM</h6>
           <ul>
             <li>
               <SideNavLink navText="Dashboard" link="/dashboard">
                  <template #icon>
                    <i class='bx bx-tachometer bx-sm'></i>
                  </template> 
               </SideNavLink>
             </li> 
             <li v-if="userAuth.user?.is_admin">
               <SideNavLink navText="Elections" link="/elections">
                  <template #icon>
                    <i class='bx bx-poll bx-sm' ></i>
                  </template> 
               </SideNavLink> 
             </li> 
             <li v-if="userAuth.user?.is_admin">
               <SideNavLink navText="Voters" link="/voters">
                  <template #icon>
                    <i class='bx bx-group bx-sm'></i>
                  </template> 
               </SideNavLink> 
             </li> 
             <li v-if="!userAuth.user?.is_admin"> 
                <SideNavLink navText="Vote" link="/vote">
                  <template #icon>
                    <i class='bx bx-file bx-sm' ></i>
                  </template> 
               </SideNavLink> 
             </li>
             <li> 
                <SideNavLink navText="Results" link="/results">
                  <template #icon>
                    <i class='bx bx-stats bx-sm' ></i> 
                  </template> 
               </SideNavLink> 
             </li>
             <li v-if="userAuth.user?.is_admin"> 
                <SideNavLink navText="Reports" link="/reports">
                  <template #icon>
                    <i class='bx bx-file bx-sm' ></i>
                  </template> 
               </SideNavLink> 
             </li> 
             <li> 
                <SideNavLink navText="Settings" link="/settings">
                  <template #icon>
                    <i class='bx bx-cog bx-sm' ></i> 
                  </template> 
               </SideNavLink> 
             </li>
           </ul>
       </div>
    </nav>
</template>

<script setup>
 import { inject } from 'vue';
 import SideNavLink from '../../components/common/SideNavLink.vue';
 
 const userAuth = inject('userAuth');
</script>
 