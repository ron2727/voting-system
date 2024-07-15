<template>
    <Title title="Reports" subTitle="Generate report for elections"></Title>
    <BackButton path="/dashboard/reports" />
    <Loader size="md" v-if="isLoading" />
    <div class="wrapper-main overflow-x-auto" v-else>
        <div class=" w-[896px] flex justify-end m-auto mb-5">
            <Button buttonText="Print to pdf" bg-color="bg-red-600" @click="generatePdf"></Button>
         </div>
        <div class=" w-[896px] m-auto border p-10 bg-white">
            <div ref="pdfContent">
                <ReportPdf v-if="reportData.electionName !== ''" :report-data="reportData" />
            </div>
        </div>
    </div>
</template>

<script setup>
import DashboardTemplate from '../../../components/layouts/DashboardTemplate.vue';
import Title from '../../../components/common/Title.vue';  
import ReportPdf from '../../../components/common/ReportPdf.vue'; 
import Loader from '../../../components/common/Loader.vue';
import Button from '../../../components/common/Button.vue';
import BackButton from '../../../components/common/BackButton.vue';
import html2pdf from 'html2pdf.js';
import { onMounted, ref, provide, onBeforeMount } from 'vue';
import { useRoute } from 'vue-router';
import { useAuthStore } from '../../../stores/auth';
import { getCandidateTotalVotes } from '../../../services/api/vote';
import { getElection } from '../../../services/api/elections';
import { VotesTally } from '../../../services/voteTally';
const authStore = useAuthStore(); 
const isLoading = ref(true); 
const pdfContent = ref(null);
const election = ref([]);
const candidatesWithTotalVotes = ref(null);
const reportData = ref({
    electionName: '',
    electionDescription : '',
    electionStartDate: '',
    electionEndDate: '',
    totalVotes: 0, 
    candidates: {},
})
const route = useRoute(); 
provide('userAuth', authStore);

onBeforeMount(async () => {
   await authStore.getAuthUser();  
   election.value = await getElection(route.params.electionId); 
   const candidates = await getCandidateTotalVotes(route.params.electionId); 
   const votesTally = new VotesTally(candidates, ["President", "Vice President", "Treasurer", "Secretary"])
   candidatesWithTotalVotes.value = votesTally.getCandidates()
   storeDataToReportData(election) 
   isLoading.value = false
})    

const getTotalVotesOfELection = () => {
    let totalVotes = 0
    for (const key in candidatesWithTotalVotes.value) {
        totalVotes += candidatesWithTotalVotes.value[key].totalVotes
    }
    return totalVotes
}

const storeDataToReportData = () => {
    reportData.value.electionName = election.value.title
    reportData.value.electionDescription = election.value.description
    reportData.value.electionStartDate = election.value.start_date
    reportData.value.electionEndDate = election.value.end_date 
    reportData.value.totalVotes = getTotalVotesOfELection()
    reportData.value.candidates = candidatesWithTotalVotes.value
    console.log(reportData.value)
}

const generatePdf = () => {
      const element = pdfContent.value;

      // Configure options
      const options = {
        margin: 0.5,
        filename: `ElectionReport-${reportData.value.electionStartDate}.pdf`,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
      };

      // Generate PDF
      html2pdf().from(element).set(options).save();
}

</script>