<template>
   <button id="dropdownDefaultButton" 
                 data-dropdown-toggle="dropdown"  
                 type="button"
                 class="text-blue-700 
                        hover:text-white
                        flex
                        items-center
                        justify-between
                        text-center
                        border 
                        border-blue-700 
                        hover:bg-blue-800 
                        focus:ring-2 
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
                        dark:focus:ring-blue-800">
                        Categories
            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
         </button>

         <!-- Dropdown menu -->
         <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 h-52 shadow-lg overflow-hidden cursor-pointer hover:overflow-auto dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
               <li v-for="category in categories" :key="category">
                    <span @click="getCategory(category)" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        {{ category}}
                    </span>
               </li>
            </ul>
         </div>
</template>

<script setup>
    import { defineProps,defineEmits } from 'vue';
    defineProps({
        categories : Object
    })

    const emit = defineEmits(['getCategory'])

    const getCategory = category => {
        emit('getCategory',category)
    } 
</script>

<style>

</style>