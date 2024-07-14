<template> 
    <div>
        <TopNav @open-nav="triggerNav(true)"/> 
        <SideNav @close-nav="triggerNav(false)"/> 
        <div class=" m-0 lg:ml-64 p-5">  
          <div :class="layout" class="main">
            <slot name="main"></slot>
          </div>
        </div>
    </div>
</template>

<script setup>
import TopNav from '../../components/layouts/TopNav.vue';
import SideNav from '../../components/layouts/SideNav.vue';
import { ref, provide } from 'vue'; 
defineProps({
  layout: {
    type: String,
    default: 'grid grid-cols-3 gap-10',
  }, 
 
})

const isNavOpen = ref(false);
 
const triggerNav = (trigger) => {
   isNavOpen.value = trigger
}
 
provide('nav', {
  isNavOpen,
  triggerNav
});
</script>
 