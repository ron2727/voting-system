<template> 
      <button @click="$emit('getClicked')" :type="buttonType" :class="bgColor" class=" text-xs lg:text-sm text-white rounded-md py-1.5 px-4">
         <slot></slot> {{ buttonText }}
      </button>
</template>

<script setup>
defineEmits(['getClicked'])

defineProps({
  buttonText: {
    type: String, 
  },
  buttonType: {
    type: String,
    default: 'button'
  }, 
  bgColor: {
    type: String,
    default: 'bg-blue-600'
  }
})
</script>


<style scoped>
[disabled] {
  opacity: 0.9;
  cursor: not-allowed; 
}
</style>
 