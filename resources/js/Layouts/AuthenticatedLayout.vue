<script setup>
import Sidebar from "@/Components/Sidebar.vue";
import { initFlowbite } from 'flowbite'
import { onMounted, defineProps } from "vue";

const prop = defineProps({
    paramsID : {
      type:String,
      required: false
    }
})

onMounted(() => initFlowbite())

</script>

<template>
  <Sidebar :paramsID="paramsID"/>

  <div class="p-4 sm:ml-64">
    <slot />
  </div>
</template>
