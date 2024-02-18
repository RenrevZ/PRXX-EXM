<template>
    <AuthenticatedLayout>
        
        <div class="h-screen">

    
        <!-- TITLE -->
        <h1 class="text-3xl py-10 text center w-full text-sky-600">Create Product</h1>

        <Stepper :steps="steps"/>

        <div class="steps-items">
            <div v-if="steps === 1" class="step1">
                <transition name="slide-right" mode="out-in">

                    <CreateForm :inputs="inputs" :productValidation="productValidation"/>

                </transition>
            </div>

            <div v-if="steps === 2" class="step2">
                <transition name="slide-right" mode="out-in">

                    <CreateUploadBtn :uploadMessage="uploadMessage" 
                                    :photos="photos" 
                                    :handleFileChange="handleFileChange"/>
                </transition>
            </div>

            <div v-if="steps === 3" class="step3">
            
                <div class="flex flex-col items-center justify-center max-w-lg mx-auto my-24">
                    <p v-if="uploadMessage !== ''" class="text-rose-400">{{ uploadMessage }}</p>

                    <InputLabel for="date and time" value="Choose date and time" />
                    <input type="datetime-local" 
                        class="border-sky-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-600 mt-5"
                        v-model="dateAndTime">
                </div>
            </div>
        </div>
    

        <div :class="`flex ${steps > 1 ? 'justify-between' : 'justify-end'}  items-end`">
            <PrimaryButton v-if="steps > 1" @click="handlePrevious" class="ms-4 w-52">
                    Previous
            </PrimaryButton>

            <PrimaryButton v-if="steps < 3 " @click="handleNext" class="ms-4 w-52">
                    Next
            </PrimaryButton>
            <PrimaryButton v-else @click="SubmitAllForms" class="ms-4 w-52">
                    Submit
            </PrimaryButton>
        </div>
    </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { reactive,ref,onMounted, watch ,computed } from 'vue';
import { initFlowbite } from 'flowbite'
import Stepper from '@/Components/Stepper.vue';
import validateProduct from '@/validations/CreateProductValidation'
import validatePhotos from '@/validations/ProductPhotosValidation'
import { useProductStore } from '@/store/productStore';
import { router } from '@inertiajs/vue3';
import CreateForm from '@/Components/CreateForm.vue';
import CreateUploadBtn from '@/Components/CreateUploadBtn.vue';


const steps = ref(1)

// PRODUCT INFO RULES AND INPUTS
const inputs = reactive({
    productName : '',
    categories:'',
    description:''
})

// PRODUCT VALIDATION
const productValidation = validateProduct(inputs)


const handlePrevious = () => {
    if(steps !== 1) steps.value--
}


const handleNext = async () => {
    switch(steps.value){
        case 1 : 
            const isProductValid = await productValidation.value.$validate();
            isProductValid && steps.value++
            break;
        case 2 : 
            // Validate the photos array
            const validation = validatePhotos(photos.value);
            const isPhotosEmpty = photos.value.length
            if(validation.valid && isPhotosEmpty > 0) return steps.value++
            else uploadMessage.value = 'Please provide atleast one photo'
        default : 
             steps.value
    }
}

// PHOTOS
const photos = ref([]);
const uploadMessage = ref('')
const handleFileChange = async (event) => {
  const selectedFiles = event.target.files;
  const filePromises = [];

  // Clear previous photos
  photos.value = [];

  for (let i = 0; i < selectedFiles.length; i++) {
    const file = selectedFiles[i];
    const reader = new FileReader();

    const filePromise = new Promise((resolve) => {
      reader.onload = (e) => {
        photos.value.push({
          file: file,
          preview: e.target.result,
        });
        resolve();
      };
    });

    filePromises.push(filePromise);
    reader.readAsDataURL(file);
  }

  // Wait for all FileReader.onload callbacks to finish
  await Promise.all(filePromises);

  // Validate the photos array
  const validation = validatePhotos(photos.value);

  if (!validation.valid) {
    // Handle the validation error, e.g., display an error message to the user
    uploadMessage.value = validation.message
    // Clear photos array to prevent displaying invalid previews
    photos.value = [];
    event.target.value = '';
  }
};


const dateAndTime = ref('')
const formattedDateAndTime = computed(() => {
    // Convert to Date object
    const selectedDate = new Date(dateAndTime.value);

    // Get hours, minutes, and AM/PM
    const hours = selectedDate.getHours() % 12 || 12;
    const minutes = selectedDate.getMinutes();
    const amPm = selectedDate.getHours() < 12 ? 'AM' : 'PM';

    // Format the date component
    const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
    const formattedDate = selectedDate.toLocaleDateString('en-CA', options);

    // Format the time component
    const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: true };
    const formattedTime = selectedDate.toLocaleTimeString('en-US', timeOptions);

    // Combine the formatted date and time components
    return `${formattedDate} ${formattedTime}`;
});

// SUBMIT ALL DATA
const { CreateProduct }  = useProductStore()

const SubmitAllForms = async () =>{
    if(dateAndTime.value === ''){
        uploadMessage.value = 'date and time is required'
    }else{
        const getOnlyFiles = photos.value.map(image => image.file)
        const [date, time] = formattedDateAndTime.value.split(' ');
        const formData =  {
            productName : inputs.productName,
            categories: inputs.categories,
            description:inputs.description,
            date : date,
            time : time,
            images : getOnlyFiles
        }
    
        try {
           CreateProduct(formData)
        } catch (error) {
            uploadMessage.value = 'there was an error in sending'
        }finally{
            router.visit('/products')
        }
    }
}

watch(uploadMessage,(newVal,oldVal) => {
  if(newVal !== ''){
    console.log('triggered')
    setTimeout(() => {
          // After 3 seconds, set uploadMessage back to an empty string
          uploadMessage.value = '';
    }, 3000);
  }
})


onMounted(() => {
   initFlowbite()
})
</script>

<style scoped>
.slide-right-enter-active, .slide-right-leave-active {
  transition: opacity 0.5s, transform 0.5s;
}

.slide-right-enter, .slide-right-leave-to /* .slide-right-leave-active in <2.1.8 */ {
  opacity: 0;
  transform: translateX(20px); /* Adjust this value to control the slide distance */
}
</style>