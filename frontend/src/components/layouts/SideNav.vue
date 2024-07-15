<template>
    <nav :class="isNavOpen ? 'translate-x-0' : '-translate-x-full'" class="w-full lg:w-max fixed top-0 left-0 z-10 lg:translate-x-0 transition-transform duration-300 h-full border">
       <div :class="isNavOpen ? 'opacity-100' : 'opacity-0'" class="overlay block lg:hidden fixed top-0 left-0 z-0 transition-opacity duration-200 delay-300 w-full h-full bg-black/20" @click="$emit('closeNav')"></div>
       <div class=" relative z-10 w-64 h-full px-3 md:px-5 bg-white">
           <div class="header flex lg:block justify-between items-center py-4 md:py-7 pl-2">
              <h6 class=" text-lg lg:text-2xl font-bold">VOTING SYSTEM</h6>
              <button  @click="$emit('closeNav')" id="closeNav" type="button" class="block lg:hidden">
                <i class='bx bx-x bx-md'></i>
              </button>
           </div>
           <ul class=" space-y-1">
             <li v-if="userAuth.user?.is_admin">
               <SideNavLink @click="activeNav='Dashboard'" :currentNav="activeNav" navText="Dashboard" link="/dashboard">
                  <template #icon>
                    <i class='bx bx-tachometer text-lg md:text-2xl'></i>
                  </template> 
               </SideNavLink>
             </li> 
             <li v-if="userAuth.user?.is_admin">
               <SideNavLink @click="activeNav='Elections'" :currentNav="activeNav" navText="Elections" link="/dashboard/elections">
                  <template #icon>
                    <i class='bx bx-poll text-lg md:text-2xl' ></i>
                  </template> 
               </SideNavLink> 
             </li> 
             <li v-if="userAuth.user?.is_admin">
               <SideNavLink @click="activeNav='Voters'" :currentNav="activeNav" navText="Voters" link="/dashboard/voters">
                  <template #icon>
                    <i class='bx bx-group text-lg md:text-2xl'></i>
                  </template> 
               </SideNavLink> 
             </li> 
             <li v-if="!userAuth.user?.is_admin"> 
                <SideNavLink @click="activeNav='Vote'" :currentNav="activeNav" navText="Vote" link="/dashboard/vote">
                  <template #icon>
                    <i class='bx bx-file text-lg md:text-2xl' ></i>
                  </template> 
               </SideNavLink> 
             </li>
             <li v-if="userAuth.user?.is_admin"> 
                <SideNavLink @click="activeNav='Results'" :currentNav="activeNav" navText="Results" link="/dashboard/results">
                  <template #icon>
                    <i class='bx bx-stats text-lg md:text-2xl' ></i> 
                  </template> 
               </SideNavLink> 
             </li>
             <li v-if="userAuth.user?.is_admin"> 
                <SideNavLink @click="activeNav='Reports'" :currentNav="activeNav" navText="Reports" link="/dashboard/reports">
                  <template #icon>
                    <i class='bx bx-file text-lg md:text-2xl' ></i>
                  </template> 
               </SideNavLink> 
             </li> 
             <li> 
                <SideNavLink @click="activeNav='Settings'" :currentNav="activeNav" navText="Settings" link="/dashboard/settings">
                  <template #icon>
                    <i class='bx bx-cog text-lg md:text-2xl' ></i> 
                  </template> 
               </SideNavLink> 
             </li>
           </ul>
       </div>
    </nav>
</template>

<script setup>
 import { inject, onMounted, provide, ref } from 'vue';
 import { useRoute } from 'vue-router';
 import SideNavLink from '../../components/common/SideNavLink.vue';
 defineProps({
   navOpen: Boolean,
 })
 const userAuth = inject('userAuth');  
 const route = useRoute();
 const activeNav = ref('');
 const {isNavOpen, triggerNav} = inject('nav');

 onMounted(() => {
   const currentPage = route.path.split('/')[route.path.split('/').length - 1];
   activeNav.value = getStringWithFirstLetterUppercase(currentPage);
 })
const getStringWithFirstLetterUppercase = (str) => { 
    console.log(str.charAt(0).toUpperCase() + str.slice(1))
    return str.charAt(0).toUpperCase() + str.slice(1);
}
</script>
 