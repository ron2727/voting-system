<template>
    <div class="input">
       <label for="" class="text-sm">{{ labelText }} <span class="text-red-500" v-if="required">*</span></label>
       <input v-model="input" :type="inputType" 
              :class="[errorMessage ? 'border-red-300 focus:ring-red-600/60' : 'border-gray-300 focus:ring-blue-700/60']" 
              class="w-full border text-sm outline-none rounded-md p-2 focus:ring-2 focus:ring-offset-1" 
              :placeholder="`Enter ${labelText}`" autocomplete="on">
       <small class=" text-xs text-red-500">{{errorMessage}}</small>
    </div>
</template>

<script setup> 
const input = defineModel()

defineProps({
  labelText: {
    type: String, 
  },
  inputType: {
    type: String,
    default: 'text'
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