<template>
    <div class="card mt-4 p-3 rounded-2xl bg-gray-color">
        <h6 class=" text-sm font-bold mb-3">{{election.title}}</h6>
        <p class=" text-xs pb-3 border-b">{{election.description}}</p>
        <div class=" flex justify-between">
            <div class=" w-max mt-5 p-2 text-xs bg-white rounded-full">
                <i class='bx bx-calendar'></i> {{ DateFormat.getDateWithMonthName(election.start_date) }}
            </div>
            <div class=" w-max mt-5 p-2 text-xs bg-white rounded-full">
                <i class='bx bx-time-five'></i> {{ DateFormat.getTimeOfDate(election.start_date) }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { DateFormat } from '../../services/dateFormat';
defineProps({
    election: Object
})
 
</script>