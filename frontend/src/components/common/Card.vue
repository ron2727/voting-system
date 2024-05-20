<template> 
    <div class="card-wrapper relative h-min border bg-white rounded-2xl">
       <div class="card-head">
         <slot name="title"></slot> 
       </div>
       <div class="card-body overflow-hidden">
          <slot name="body"></slot>
       </div>
       <div class="card-footer">
          <slot name="footer"></slot>
       </div>
    </div>
</template>

<script setup>

</script>
 