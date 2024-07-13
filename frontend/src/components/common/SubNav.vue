<template>
    <div ref="menuBar" class="menuBar-wrapper space-x-2"> 
       <button v-for="(menu, index) in menus" :id="index" @click="setActive" 
               :class="[defaultActive == menu ? 'bg-white shadow' : 'text-slate-600']" 
                class="px-5 py-2 text-xs lg:text-sm rounded-lg">
          {{ menu }}
       </button>    
    </div>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  menus: {
    type: Array,
    default: ['Item 1', 'Item 2']
  },
  defaultActive: {
    type: String
  }
})
const emit = defineEmits(['getActive'])

const menuBar = ref(null)
const isActive = ref(false)
const removeActive = () => { 
   Array.from(menuBar.value.children).forEach(element => {
      if (!element.classList.contains('text-slate-600')) {
         element.classList.remove('bg-white')
         element.classList.remove('shadow')
         element.classList.add('text-slate-600')
      }
   })
}
const setActive = (event) => {
    removeActive() 
    if (event.target.classList.contains('text-slate-600')) {
        event.target.classList.remove('text-slate-600')
        event.target.classList.add('bg-white')
        event.target.classList.add('shadow')
    } 
    emit('getActive', event.target.textContent)
}
</script>
 