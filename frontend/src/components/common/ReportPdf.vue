<template>
    <div class="wrapper-tables">
        <div class=" flex justify-between items-center mb-10">
            <h1 class="text-2xl">Election Report</h1>
            <div id="date" class=" text-sm"><span class=" font-bold">Date:</span> {{ getCurrentDate() }}</div>
        </div>
        <table class=" w-full border-collapse border">
            <thead>
                <tr>
                    <td class=" border p-2 text-sm font-bold text-white bg-blue-600">Election Information</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class=" border p-2 text-sm">
                        <span class=" font-bold">Election name:</span>
                        {{ reportData.electionName }}
                    </td>
                </tr>
                <tr class="even:bg-blue-600/10">
                    <td class=" border p-2 text-sm">
                        <span class=" font-bold">Description:</span> 
                        {{ reportData.electionDescription }}
                    </td>
                </tr>
                <tr class="even:bg-blue-600/10">
                    <td class=" border p-2 text-sm">
                        <span class=" font-bold">Start Date:</span> 
                        {{ reportData.electionStartDate }}
                    </td>
                </tr>
                <tr class="even:bg-blue-600/10">
                    <td class=" border p-2 text-sm">
                        <span class=" font-bold">End Date:</span> 
                        {{ reportData.electionEndDate }}
                    </td>
                </tr> 
            </tbody>
        </table> 
        <h1 class=" text-xl font-bold mt-16 mb-8">Detailed Results</h1> 
        <h6 class=" mb-3 text-lg">Candidates</h6>
        <table class=" w-full table-fixed mb-5 border-collapse border"
            v-for="(election, position) in reportData.candidates">
            <thead>
                <tr>
                    <td class=" border p-2 text-sm text-white font-bold bg-blue-600">Candidates for {{ position }}</td>
                    <td class=" border p-2 text-sm text-white font-bold bg-blue-600">Votes</td>
                    <td class=" border p-2 text-sm text-white font-bold bg-blue-600">Percentage</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="candidate in election.candidates" class="even:bg-blue-600/10">
                    <td class=" border p-2 text-sm"> {{ candidate.user.firstname }} {{ candidate.user.lastname }} </td>
                    <td class=" border p-2 text-sm"> {{ candidate.votes }} </td>
                    <td class=" border p-2 text-sm"> {{ candidate.votePercentage }}% </td>
                </tr>
                <tr>
                    <td class="p-2 text-xs" colspan="3">
                        <div class=" flex justify-end space-x-5">
                            <span class=" font-bold">Total Votes: </span> 
                            <span>{{ election.totalVotes }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <h6 class=" mb-3 text-lg">Election winners</h6>
        <table class=" w-full table-fixed mb-5 border-collapse border">
            <thead>
                <tr>
                    <td class=" border p-2 text-sm text-white font-bold bg-blue-600">Name</td>
                    <td class=" border p-2 text-sm text-white font-bold bg-blue-600">Position</td>
                    <td class=" border p-2 text-sm text-white font-bold bg-blue-600">Votes</td>
                    <td class=" border p-2 text-sm text-white font-bold bg-blue-600">Votes Percentage</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(candidate, position) in reportData.electionWinners" class="even:bg-blue-600/10">
                    <td class=" border p-2 text-sm"> {{ candidate.user.firstname }} {{ candidate.user.lastname }} </td>
                    <td class=" border p-2 text-sm"> {{ position }} </td>
                    <td class=" border p-2 text-sm">  {{ candidate.votes }} </td>
                    <td class=" border p-2 text-sm"> {{ candidate.votePercentage }}% </td>
                </tr> 
            </tbody>
        </table>
    </div>
</template>

<script setup>
defineProps({
    reportData: Object,
})

const getCurrentDate = () => {
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const date = new Date();
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    return `${months[month - 1]} ${day}, ${year}`;
}
</script>