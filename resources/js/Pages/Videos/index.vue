<template>
  <AuthenticatedLayout>
    <div class="flex flex-col items-center justify-center h-screen">
      <Video :video="currentVideo" :key="currentVideo" />

      <div class="flex flex-col flex justify-center items-center mt-10">
        <p class="text-slate-500 py-2">Click to Change Videos</p>

        <div class="btn">
        <button class="text-blue-700 
                       hover:text-white 
                       border 
                       border-blue-700 
                       hover:bg-blue-800 
                       focus:ring-4 
                       focus:outline-none 
                       focus:ring-blue-300 
                       font-medium 
                       rounded-lg 
                       text-sm 
                       px-5 
                       py-2.5 
                       text-center 
                       me-2 
                       mb-2 
                       dark:border-blue-500 
                       dark:text-blue-500 
                       dark:hover:text-white 
                       dark:hover:bg-blue-500 
                       dark:focus:ring-blue-800" 
                type="button" 
                @click="clickVideo1">
                What da Hail
          </button>

        <button class="text-blue-700 
                       hover:text-white 
                       border 
                       border-blue-700 
                       hover:bg-blue-800 
                       focus:ring-4 
                       focus:outline-none 
                       focus:ring-blue-300 
                       font-medium 
                       rounded-lg 
                       text-sm 
                       px-5 
                       py-2.5 
                       text-center 
                       me-2 
                       mb-2 
                       dark:border-blue-500 
                       dark:text-blue-500 
                       dark:hover:text-white 
                       dark:hover:bg-blue-500 
                       dark:focus:ring-blue-800"
                type="button" 
                @click="clickVideo2">
                Got Emm
        </button>

        <button class="text-blue-700 
                       hover:text-white 
                       border 
                       border-blue-700 
                       hover:bg-blue-800 
                       focus:ring-4 
                       focus:outline-none 
                       focus:ring-blue-300 
                       font-medium 
                       rounded-lg 
                       text-sm 
                       px-5 
                       py-2.5 
                       text-center 
                       me-2 
                       mb-2 
                       dark:border-blue-500 
                       dark:text-blue-500 
                       dark:hover:text-white 
                       dark:hover:bg-blue-500 
                       dark:focus:ring-blue-800"
                type="button" 
                @click="clickVideo3">
                Oh my God
        </button>
      </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Video from '@/Components/Video.vue'
import { ref } from 'vue'

const currentVideo = ref('/videos/WhatdaHail.mp4')

const clickVideo1 = () => currentVideo.value = '/videos/WhatdaHail.mp4'


const clickVideo2 = () => currentVideo.value = '/videos/HaGotEm.mp4'

const clickVideo3 = () => currentVideo.value = '/videos/OMG.mp4'

</script>
