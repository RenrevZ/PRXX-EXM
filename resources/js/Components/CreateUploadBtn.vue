<template>
  <div class="flex flex-col items-center justify-center max-w-lg mx-auto my-24">
        <p v-if="uploadMessage !== ''" class="text-rose-400">{{ uploadMessage }}</p>

        <div v-if="currentPhoto.photos && currentPhoto.photos.length > 0" class="flex flex-col justify-center items-center">
            <h1 class="text-lg text-slate-500">
                Product {{ currentPhoto.name }} Current Photos
            </h1>

            <div class="grid grid-cols-5 gap-4 mb-10">
                <div v-for="(photo, index) in currentPhoto.photos" 
                    :key="index" 
                    class="flex justify-around items-center w-full">
            
                    <div class="h-50 w-80 object-fill">
                        <img :src="`/images/${photo.images_path}`" 
                        alt="Preview" 
                        class="rounded-xl"/>
                        </div>
                </div>  
            </div>

            <h1 class="text-lg text-slate-500">
                Or upload new photos
            </h1>
        </div>
        <div v-if="currentPhoto.photos && currentPhoto.photos.length === 0">
            <h1 class="text-lg text-slate-500">
                Product {{ currentPhoto.name }} has no uploaded photos yet
            </h1>
        </div>

        <div v-if="photos !== ''" class="grid grid-cols-5 gap-4 mb-10">
            <div v-for="(photo, index) in photos" 
             :key="index" 
             class="flex justify-around items-center w-full">

             <div class="h-50 w-80 object-fill">
                 <img :src="photo.preview" 
                   alt="Preview" 
                   class="rounded-xl"/>
                 </div>
             </div>
        </div>
        
       
        <input @change="handleFileChange" 
               class="block 
                      w-full 
                      text-sm 
                      text-gray-900 
                      border 
                      border-gray-300 
                      rounded-lg 
                      cursor-pointer 
                      bg-gray-50 
                      dark:text-gray-400 
                      focus:outline-none 
                      dark:bg-gray-700 
                      dark:border-gray-600 
                      dark:placeholder-gray-400" 
                id="multiple_files" 
                type="file" 
                multiple>
    </div> 
</template>

<script setup>  
    import { defineProps } from 'vue';

    
   defineProps({
        uploadMessage : String,
        photos : Array,
        handleFileChange : Function,
        currentPhoto : {
            type:Array,
            default : ''
        }
    })
</script>

<style>

</style>