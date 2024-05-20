<template>
    <table class="w-full text-sm bg-white rounded-lg overflow-hidden border shadow-sm">
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
           <tr class="border text-slate-600 odd:bg-[#f2f2f2] ..." v-for="voter in dataTable" :key="voter.id">
             <td class=" p-2">{{ voter.student_id }}</td>
             <td class=" p-2">{{ voter.firstname }}</td>
             <td class=" p-2">{{ voter.lastname }}</td>
             <td class=" p-2">{{ voter.course }}</td>
             <td class=" p-2">{{ voter.year_level }}</td>
             <td class=" p-2">{{ voter.section }}</td>
             <td>
                <button type="button">
                    <i class='bx bx-edit-alt'></i>
                </button>
             </td>
           </tr>
        </tbody>
    </table>
</template>

<script setup>
defineProps({
 dataTable: {
   type: Array
 }
})
</script>

<style>

</style>
 