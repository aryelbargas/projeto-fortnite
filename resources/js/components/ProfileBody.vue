<template>
    <div class="mx-auto max-w-7xl items-center p-6 lg:px-8">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl/7 font-bold text-white sm:truncate sm:text-3xl sm:tracking-tight">Olá, {{name}}</h2>
                <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                    <div class="mt-2 flex items-center text-lg text-gray-400">
                        <AtSymbolIcon class="mr-1.5 size-5 shrink-0 text-gray-500" aria-hidden="true" />
                        {{ email }}
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-400">
                        <a href="/ballance" class="hover:underline text-sky-500 text-lg">
                            V{{ vbucks }} (Ver extrato)
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <span class="sm:ml-3">
                    <button @click="logout" type="button" class="inline-flex items-center rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                    <ArrowLeftEndOnRectangleIcon class="mr-1.5 -ml-0.5 size-5" aria-hidden="true" />
                    Sair
                    </button>
                </span>
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8">

        <h1 class="text-center text-2xl text-white my-4">Meus Cosméticos</h1>
        <Gallery :cosmetics="cosmetics"/>
        <Pagination :pages="pages" :from="from" :to="to" :total="total" @pageChanged="fetchMyCosmetics"/>
    </div>
</template>

<script setup>
    import VueCookie from "vue-cookie";
    import { ArrowLeftEndOnRectangleIcon, AtSymbolIcon } from '@heroicons/vue/24/outline';
    import Gallery from "./Gallery.vue";
    import Pagination from '../components/Pagination.vue';
</script>
<script>
    export default {
        data() {
            return { 
                name: null,
                email: null,
                cosmetics: [],
                pages: [],
                from: 0,
                to: 0,
                total: 0,
                vbucks: 0,
            }
        },
        created(){
            this.name = VueCookie.get("name");
            this.email = VueCookie.get("email");
            
            this.fetchMyCosmetics(1);
            this.getMyVBucks();
        },
        methods: {
            logout() {
                VueCookie.delete("name");
                VueCookie.delete("email");
                VueCookie.delete("token");

                this.$router.push({ path: '/' })
            },
            getMyVBucks() {
                this.axios.get("/api/user/my-vbucks").then((response) => {
                    this.vbucks = response.data;
                });
            },
            fetchMyCosmetics(page) {
                this.axios.get("/api/cosmetics/my?page=" + page).then((response) => {
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