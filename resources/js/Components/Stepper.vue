<template>
  <ol class="flex 
             items-center 
             w-full text-sm 
             font-medium 
             text-center 
             text-gray-500 
             dark:text-gray-400 
             sm:text-base 
             transition-all">

    <!-- STEP 1 -->
    <li :class="`${steps > 1 ? 'after:border-blue-600' : 'after:border-gray-200' } 
                 flex 
                 md:w-full 
                 items-center 
                 text-blue-600 
                 dark:text-blue-500 
                 sm:after:content-[''] 
                 after:w-full after:h-1 
                 after:border-b  
                 after:border-3 
                 after:hidden 
                 sm:after:inline-block 
                 after:mx-6 xl:after:mx-10 
                 dark:after:border-gray-700`">

        <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">

           <span v-if="steps > 1"> 
                 <stepsDoneIcon />
            </span>
           <span v-else class="me-3">1</span>
            Products <span class="hidden sm:inline-flex sm:ms-2">Info</span>
        </span>

    </li>

    <!-- STEP 2 -->
    <li :class="`${steps > 2 ? 'after:border-blue-600 text-blue-600' : 'after:border-gray-200' }
                 ${steps === 2 && 'text-blue-600' } 
                 flex 
                 md:w-full 
                 items-center after:content-[''] 
                 after:w-full after:h-1 
                 after:border-b 
                 after:border-1 
                 after:hidden 
                 sm:after:inline-block 
                 after:mx-6 
                 xl:after:mx-10 
                 dark:after:border-gray-700`">

        <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">

            <span v-if="steps > 2"> 
                <stepsDoneIcon />
            </span>

            <span class="me-2">2</span>
            Product <span class="hidden sm:inline-flex sm:ms-2">Images</span>

        </span>

    </li>

    <!-- STEP 3 -->
    <li :class="`${steps > 2 && 'text-blue-600'} flex items-center`">
        <span class="me-2">3</span>
         Date&Time
    </li>
</ol>
</template>

<script setup>
    import { defineProps } from 'vue';
    import stepsDoneIcon from '@/assets/steps-done-icon.vue';

    defineProps({
        steps : Number
    })
</script>