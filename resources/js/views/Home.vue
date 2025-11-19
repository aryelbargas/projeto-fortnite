<script setup>
    import { ref } from 'vue'
    import Header from '../components/Header.vue'
    import Footer from '../components/Footer.vue'
    import Gallery from '../components/Gallery.vue'
    import Pagination from '../components/Pagination.vue'

    const count = ref(0)
</script>

<template>
    <Header/>
    <div class="flex items-center justify-center py-4 md:py-8 flex-wrap">
        <h1 class="text-center text-2xl text-white">Bem-vindo á Loja de Cosméticos Fortnite!</h1>
    </div>
    <Gallery 
        :cosmetics="cosmetics"
    />
    <div>
        <Pagination :pages="pages" :from="from" :to="to" :total="total" @pageChanged="fetchCosmetics"/>
    </div>
    <Footer/>
</template>
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
            fetchCosmetics(page) {this.axios.get("/api/cosmetics?page=" + page).then((response) => {
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