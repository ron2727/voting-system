<template>
    <div class="back-button">
        <RouterLink :to="path">
            <i class='bx bx-arrow-back text-lg md:text-2xl'></i>
        </RouterLink>
    </div>
</template>

<script setup> 
defineProps({
    path: String
})
</script>
 