<template>
     <div class="flex flex-col items-center justify-center max-w-lg mx-auto my-24 h-80">
                <p v-if="uploadMessage !== ''" class="text-rose-400">{{ uploadMessage }}</p>

                <InputLabel for="date and time" value="Choose date and time" />
                <input type="datetime-local" 
                       class="border-sky-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-600 mt-5"
                       v-model="dateAndTime">
     </div>
</template>

<script setup>
    import InputLabel from '@/Components/InputLabel.vue';
    import { defineComponent } from 'vue';


    defineComponent({
        uploadMessage : String,
        dateAndTime : String
    })
</script>

<style>

</style>