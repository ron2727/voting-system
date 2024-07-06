<template>
  <div class="wrapper-table">
    <table class="w-full text-sm bg-white rounded-lg border shadow-sm">
      <thead class=" text-left">
        <tr class="border">
          <th class=" p-2">ID</th>
          <th class=" p-2">Firstname</th>
          <th class=" p-2">Lastname</th>
          <th class=" p-2">Course</th>
          <th class=" p-2">Year</th>
          <th col-span="2" class=" p-2">Section</th>
        </tr>
      </thead>
      <tbody>
        <tr class="border text-slate-600 odd:bg-[#f2f2f2] ..." v-for="voter in dataTable.data" :key="voter.id">
          <td class=" p-2">{{ voter.student_id }}</td>
          <td class=" p-2">{{ voter.firstname }}</td>
          <td class=" p-2">{{ voter.lastname }}</td>
          <td class=" p-2">{{ voter.course }}</td>
          <td class=" p-2">{{ voter.year_level }}</td>
          <td class=" p-2">{{ voter.section }}</td>
          <td>
            <Dropdown>
              <template #head>
                <button type="button">
                  <i class='bx bx-dots-horizontal-rounded'></i>
                </button>
              </template>
              <template #body>
                <ul class="text-sm divide-y">
                  <li>
                    <RouterLink :to="`/voter/${voter.id}/update`">
                      <div class="text-sm p-2 text-blue-600">
                        <i class='bx bx-edit-alt bx-xs'></i> Edit
                      </div>
                    </RouterLink> 
                  </li>
                  <li>
                    <RouterLink :to="`/voter/${voter.id}/delete`">
                      <div class="text-sm p-2 text-red-600">
                        <i class='bx bx-trash bx-xs' ></i>  Delete
                      </div>
                    </RouterLink>  
                  </li>
                </ul>
              </template>
            </Dropdown>
          </td>
        </tr>
      </tbody>
    </table>
    <div id="pagination" class=" p-3 flex justify-between">
      <div id="results-number" class=" text-sm text-gray-800">
        Showing {{ dataTable.meta.from }} to {{ dataTable.meta.to }} of {{ dataTable.meta.total }} results
      </div>
      <div id="page-numbers">
        <ul class="flex items-center space-x-1">
          <li v-for="(link, index) in dataTable.meta.links">
            <button v-if="link.url" @click="$emit('changePage', link.url)" type="button"
              :class="dataTable.meta.current_page === Number(link.label) ? 'bg-blue-600 text-white' : 'bg-white'"
              class="active px-3 py-2 flex border text-xs hover:bg-blue-600 hover:text-white"
              v-html="link.label"></button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup> 
import Dropdown from './Dropdown.vue';
defineProps({
 dataTable: Object
})
 
</script>

<style>
 
</style>
 