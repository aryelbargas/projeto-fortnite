<template>
    <div class="bg-gray-800">
        <div class="mx-auto max-w-7xl pb-10">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                <div v-for="cosmetic in cosmetics">
                    <Card :id="cosmetic.id" :name="cosmetic.name" :description="cosmetic.description" :price="cosmetic.price" :finalPrice="cosmetic.final_price" :image="cosmetic.image" :owned="cosmetic.owned"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import Card from '../components/Card.vue'
    defineProps({
        cosmetics: Array
    })
</script>