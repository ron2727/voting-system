<template>
    <div ref="modal" class="modal fixed top-0 left-0 bottom-0 right-0 z-50 bg-black/20" id="modalId" v-if="status">
        <div class="modal-dialog relative flex justify-center my-8">
            <div class="modal-content relative w-[600px] bg-white border border-gray-300 rounded-lg">
                <div class="modal-header flex justify-between items-center p-4">
                    <h5 class="modal-title font-bold text-lg" id="modalTitleId">
                        Modal title
                    </h5> 
                    <button type="button" id="btnCloseModal" @click="$emit('closeModal')">
                        <i class='bx bx-x bx-md'></i>
                    </button>
                </div>
                <div class="modal-body p-4">
                   <slot name="body"></slot>
                </div>
                <div class="modal-footer p-4">
                   <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div> 
</template>

<script setup>
import { ref, watch } from 'vue';
const props = defineProps({
    isModalActive: {
        type: Boolean,
        default: false
    }
}) 


// const emits = defineEmits(['closeModal']);
 
// const closeModal = () => {
    
// }
 
</script>
 