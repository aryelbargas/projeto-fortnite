<template>
    <div class="bg-white border border-gray-900 rounded-lg shadow-sm dark:bg-gray-900 dark:border-gray-900 hover:border-gray-500">
        <a href="#">
            <img class="w-full rounded-t-lg" :src="image" alt="product image" />
        </a>
        <div class="p-5">
            <a href="#">
                <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ name }}</h5>
            </a>
            <div class="flex items-center mt-2.5 mb-5">                                                                                         
                <span  class="text-blue-100 text-l font-thin truncate">{{description}}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-3xl font-bold text-gray-900 dark:text-white">{{finalPrice}}</span>
                <a v-if="finalPrice != null" href="#" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add to cart</a>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    defineProps({
        name: String,
        description: String,
        price: String,
        finalPrice: String,
        image: String
    })
</script>