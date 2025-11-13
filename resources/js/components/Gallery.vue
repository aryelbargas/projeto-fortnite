<template>
    <div class="bg-gray-800">
        <div class="mx-auto max-w-7xl pb-10">
            <div class="flex items-center justify-center py-4 md:py-8 flex-wrap">
                <button type="button" class="text-blue-700 hover:text-white border border-blue-600 bg-white hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:bg-gray-900 dark:focus:ring-blue-800">All categories</button>
                <button type="button" class="text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800">Shoes</button>
                <button type="button" class="text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800">Bags</button>
                <button type="button" class="text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800">Electronics</button>
                <button type="button" class="text-gray-900 border border-white hover:border-gray-200 dark:border-gray-900 dark:bg-gray-900 dark:hover:border-gray-700 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-base font-medium px-5 py-2.5 text-center me-3 mb-3 dark:text-white dark:focus:ring-gray-800">Gaming</button>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                <div v-for="cosmetic in cosmetics">
                    <Card :name="cosmetic.name" :description="cosmetic.description" :price="cosmetic.price" :finalPrice="cosmetic.final_price" :image="cosmetic.image"/>
                </div>
            </div>
        </div>
    </div>
    <div>
        <Pagination :pages="pages" :from="from" :to="to" :total="total" @pageChanged="fetchCosmetics"/>
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import Card from '../components/Card.vue'
    import Pagination from '../components/Pagination.vue'
</script>
<script>
    export default {
        data() {
            return { 
                cosmetics: [],
                pages: [],
                from: 0,
                to: 0,
                total: 0 
            }
        },
        created() {
           this.fetchCosmetics(1);
        },
        methods: {
            fetchCosmetics(page) {this.axios.get("http://localhost:8000/api/cosmetics?page=" + page).then((response) => {
                    this.cosmetics = response.data.data;
                    this.pages = response.data.links;
                    this.from = response.data.from;
                    this.to = response.data.to;
                    this.total = response.data.total;
                     window.scrollTo({
                        top: 0,
                        behavior: "smooth"
                    });
                });
            }
        }
    }
</script>