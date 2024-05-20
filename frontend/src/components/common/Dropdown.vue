<template>
    <div ref="dropDown" class=" relative profile flex flex-col items-center">
       <div @click="toggleDropdown">
        <slot name="head"></slot>
       </div>
       <div :class="{ 'block': isDropdownOpen, 'hidden': !isDropdownOpen }" class="dropdown-list w-36 absolute left-0 bottom-0 bg-white translate-y-full -translate-x-full border shadow-md rounded-lg">
         <slot name="body"></slot>
       </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
const isDropdownOpen = ref(false);
const dropDown = ref(null);

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value; 
};

const closeDropDown = (element) => { 
  if (!dropDown.value.contains(element.target)) {
     isDropdownOpen.value = false;  
  } 
}
onMounted(() => { 
  window.addEventListener('click', closeDropDown);
})

onBeforeUnmount(() => {
   window.removeEventListener('click', closeDropDown)
})
</script>
 