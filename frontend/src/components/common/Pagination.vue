<template> 
    <div id="pagination" class=" p-3 flex justify-between">
      <div id="results-number" class=" text-sm text-gray-800">
        <!-- Showing {{ pagination[1].to - pagination[1].to }} to {{ pagination[1].to }} of {{ pagination[1].total }} results -->
      </div>
      <div id="page-numbers">
         <ul class="flex items-center space-x-1"> 
           <li v-for="(link, index) in pagination[1].links"> 
              <button @click="$emit('changePage', link.url)" type="button" class="active px-3 py-2 flex bg-white border text-xs hover:bg-blue-600 hover:text-white" v-html="link.label"></button>
           </li> 
         </ul>
      </div> 
    </div>
</template>

<script setup>
defineProps({
  pagination: Array,
})

const page = (label, page) => {
  if (isNumber(label) && page) {
    console.log('change page')
  }
}
</script>
 