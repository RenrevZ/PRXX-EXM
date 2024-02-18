<template>
    <form @submit.prevent="submitData"  class="max-w-sm mx-auto my-24">

        <div class="mb-5">
            <InputLabel for="Product Name" value="Product Name" />
            <TextInput
                    id="password"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="inputs.productName"
                    required
                    autocomplete="current-password"
                    placeholder="Product Name"
                />
            <p v-for="error of productValidation.productName.$errors" :key="error.$uid" class="text-rose-400">
                {{ error.$property }} {{ error.$message }}
            </p>
        </div>
        <div class="mb-5">
            <InputLabel for="Categories" value="Categories" />
            <TextInput
                    id="password"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="inputs.categories"
                    required
                    autocomplete="current-password"
                    placeholder="Categories"
                />
            <p v-for="error of productValidation.categories.$errors" :key="error.$uid" class="text-rose-400">
                {{ error.$property }} {{ error.$message }}
            </p>
        </div>
        <div class="mb-5">
            <InputLabel for="description" value="Description" />

                <textarea v-model="inputs.description" id="message" rows="4" 
                        class="resize-none border-sky-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" 
                        placeholder="Write product Description..."></textarea>

            <p v-for="error of productValidation.description.$errors" :key="error.$uid" class="text-rose-400">
                {{ error.$property }} {{ error.$message }}
            </p>
        </div>
    </form>
</template>

<script setup>
    import { defineProps } from 'vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';

    defineProps({
        'inputs': {
            type: Object
        },
        'productValidation': {
            type : Object
        }
    })
</script>

<style>

</style>