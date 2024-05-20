<template>
    <div class="input">
       <label class="text-sm">{{ labelText }} <span class="text-red-500" v-if="required">*</span></label>
       <select v-model="input" :class="[errorMessage ? 'border-red-300 focus:ring-red-600/60' : 'border-gray-300 focus:ring-blue-700/60']" 
              class="w-full border text-sm outline-none rounded-md p-2 focus:ring-2 focus:ring-offset-1">
         <option disabled selected value="">Select {{ labelText }}</option>
         <option v-for="option in options" :value="option">{{ option }}</option> 
       </select>
       <small class=" text-xs text-red-500">{{errorMessage}}</small>
    </div>
</template>

<script setup> 
const input = defineModel()
defineProps({
  labelText: {
    type: String, 
  },
  options: {
    type: Array,
    default: ['Option 1', 'Option 2', 'Option 3']
  },
  errorMessage: {
    type: String,
    default: null
  },
  required: {
    type: Boolean,
    default: false
  }
  
});
</script> 