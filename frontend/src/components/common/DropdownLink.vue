<template>
  <div class="relative">
    <a href="#" class="flex items-center" @click="toggleDropdown">{{ title }}</a>
    <div class="origin-top-left absolute z-10 mt-1 w-48 rounded-lg shadow-lg bg-white" :class="{ 'block': isDropdownOpen, 'hidden': !isDropdownOpen }">
      <slot></slot>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  props: {
    title: {
      type: String,
      required: true,
    },
  },
  setup() {
    const isDropdownOpen = ref(false);

    const toggleDropdown = () => {
      isDropdownOpen.value = !isDropdownOpen.value;
    };

    return {
      isDropdownOpen,
      toggleDropdown,
    };
  },
};
</script>
