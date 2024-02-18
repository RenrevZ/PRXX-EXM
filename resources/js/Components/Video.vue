<template>
     <div class="w-full object-fit-cover">
      <video class="w-full h-96 max-w-full border border-gray-200 rounded-lg dark:border-gray-700" controls>
        <source :src="video" autoplay controls type="video/mp4">
        Your browser does not support the video tag.
      </video>
     </div>
   
</template>

<script setup>
   import { defineProps } from 'vue';

    defineProps({
        video : String
    })
</script>

<style>

</style>