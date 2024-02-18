<template>
   <!-- Pagination controls -->
   <nav aria-label="Page navigation example" class="flex justify-end mt-10">
      <div v-if="totalPages > 1">
         <ul class="flex items-center h-8 text-sm">

            <!-- PREV BUTTON -->
            <li @click="goToPage(currentPage - 1)" 
               :disabled="currentPage === 1" 
               class="flex items-center 
                     justify-center 
                     px-3 h-8 
                     ms-0
                     m-3 
                     leading-tight 
                     text-gray-500 
                     bg-white border 
                     rounded-full
                     hover:bg-gray-100 
                     hover:text-gray-700 
                     dark:bg-gray-800 
                     dark:border-gray-700 
                     dark:text-gray-400 
                     dark:hover:bg-gray-700 
                     dark:hover:text-white">
               <span class="sr-only">Previous</span>
               <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
               </svg>
            </li>

            <!-- TOTAL PAGES -->
            <li  v-for="page in totalPages" :key="page" @click="goToPage(page)" 
               :disabled="currentPage === page" 
               :class="`${currentPage === page && 'border border-gray-500 rounded-full dark:border-gray-300'} 
               flex items-center 
               justify-center 
               px-3
               h-8
               rounded-full
               leading-tight 
               text-gray-500 
               bg-white 
               hover:bg-gray-100 
               hover:text-gray-700 
               dark:border-gray-700 
               dark:text-gray-400 
               dark:hover:bg-gray-700 
               dark:hover:text-white
               select-none`"
               >

               {{ page }}
            </li>

            <!-- NEXT BUTTON -->
            <li @click="goToPage(currentPage + 1)" 
               :disabled="currentPage === totalPages"  
               class="flex 
                     items-center 
                        justify-center 
                        px-3 
                        h-8 
                        leading-tight 
                        text-gray-500 
                        bg-white border 
                        rounded-full 
                        hover:bg-gray-100 
                        hover:text-gray-700 
                        dark:bg-gray-800 
                        dark:border-gray-700 
                        dark:text-gray-400 
                        dark:hover:bg-gray-700 
                        dark:hover:text-white">
               <span class="sr-only">Next</span>
               <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
               </svg>
            </li>

         </ul>
      </div>
   </nav>
</template>

<script setup>
    import { defineProps,defineEmits } from 'vue';

    defineProps({
        currentPage : Number,
        totalPages : Number
    })

    // EMIT THE GOTOPAGE FUNCTION
    const emit = defineEmits(['goToPage'])
    
    const goToPage = (page) => {
        emit('goToPage', page); // Emit the goToPage event with the selected page
    };
</script>

<style>

</style>