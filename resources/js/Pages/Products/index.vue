<template>
<AuthenticatedLayout>
<div class="grid grid-cols-2 gap-x-10">
   <div class="left">
      
      <Search  @submitInputedData="submitInputedData"/>

   </div>
 

   <div class="flex justify-end">
        <Dropdown :categories="categories" @getCategory="getCategory"/>

         <Link  href="/products/create" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
            Create
         </Link>
   </div>
     
</div>

<!-- ALERT MESSAGE SUCCESS -->
<AlertMessage v-if="message.success !== ''" :successMessage="true" :message="message.success"/>

<!-- ALERT MESSAGE ERROR -->
<AlertMessage v-if="message.error !== ''" :errorMessage="true" :message="message.error"/>

<!-- TABLE -->
<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
    <table class="w-full text-sm text-center rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Product name
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Description
                </th>
                <th scope="col" class="px-6 py-3">
                    Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Time
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody v-if="Array.isArray(products) && products.length > 0">
            <tr v-for="(product,index) in products" :key="product.id" :class="index % 2 === 0 && 'odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700'">
                <td>{{ product.name }}</td>
                <td>{{ product.category }}</td>
                <td>{{ product.description }}</td>
                <td>{{ product.date }}</td>
                <td>{{ product.time }}</td>
                <td class="flex justify-around px-6 py-4">
                    
                    <Link class="font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer" 
                          :href="`/products/edit/${product.id}`" 
                          preserve-scroll >
                        Edit
                    </Link>

                    <!-- DELETE BTN -->
                    <span @click="() => openDeleteModal(product.id)"
                          class="font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer">
                          Delete
                   </span>

                    <!-- DELETE MODAL -->
                    <DeleteModal :showDeleteModal="showDeleteModal"
                                 @closeDeleteModal="closeDeleteModal" 
                                 @close="!showDeleteModal"
                                 @deleteProduct="deleteProduct"/>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td colspan="6" class="text-2xl text-center p-10">
                    No data has been found
                </td>
            </tr>
        </tbody>
    </table>
    </div>

   <Pagination :currentPage="currentPage" :totalPages="totalPages" @goToPage="goToPage"/>
</AuthenticatedLayout>

</template>

<script setup>
import { computed, onMounted, ref,watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { useProductStore }  from '@/store/productStore'
import { storeToRefs } from 'pinia';
import Search from '@/Components/Search.vue'
import Dropdown from '@/Components/Dropdown.vue';
import DeleteModal from '@/Components/DeleteModal.vue';
import AlertMessage from '@/Components/AlertMessage.vue';
import { Link } from '@inertiajs/vue3';
import Cookies from 'js-cookie';


console.log('token:',Cookies.get('token'))

// STORE STATES
const { products,totalPages,currentPage,categories} = storeToRefs(useProductStore())

// STORE ACTIONS
const {loadProduct,goToPage,getSingleCategory,getAllCategory,searchProduct,RemoveProduct,message : productMessage} = useProductStore()

const message = computed(() => productMessage)

const getCategory = async (category) => {
    await getSingleCategory(category)
}


// SEACH INPUT LOGIC
const submitInputedData = async (data) => {
    try{
        await searchProduct(data)
    }catch(error){
        console.log(error.message)
    }   
}

// DLETE MODAL LOGIC
const showDeleteModal = ref(false)
const currentProductID = ref(null)
const openDeleteModal = productId => { 
    currentProductID.value = productId
    showDeleteModal.value = !showDeleteModal.value
}
const closeDeleteModal = () => showDeleteModal.value = !showDeleteModal.value

// SUBMIT DELETE PRODUCT
const deleteProduct = async () => {
    await RemoveProduct(currentProductID.value)
    closeDeleteModal()
}

watch(
  () => message.value.success,
  (newSuccessMessage, oldSuccessMessage) => {
    console.log('watch Triggered')
   

    if (newSuccessMessage !== oldSuccessMessage) {
      console.log('success Triggered')
      setTimeout(() => {
        message.value.success = ''
      }, 5000);
    }
  }
);

watch(
  () => message.value.error,
  (newSuccessMessage, oldSuccessMessage) => {
    console.log('watch Triggered')
   

    if (newSuccessMessage !== oldSuccessMessage) {
      console.log('success Triggered')
      setTimeout(() => {
        message.value.error = ''
      }, 5000);
    }
  }
);



onMounted(async () => {
   await loadProduct()
   await getAllCategory()
})

</script>
