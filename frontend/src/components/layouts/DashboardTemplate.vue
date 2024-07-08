<template> 
    <div>
        <TopNav/> 
        <SideNav/> 
        <div class=" ml-64 p-5 space-y-10"> 
          <slot name="head"></slot>
          <div :class="layout" class="main">
            <slot name="main"></slot>
          </div>
        </div>
    </div>
</template>

<script setup>
import TopNav from '../../components/layouts/TopNav.vue';
import SideNav from '../../components/layouts/SideNav.vue';
defineProps({
  layout: {
    type: String,
    default: 'grid grid-cols-3 gap-10',
  } 
})
</script>
 