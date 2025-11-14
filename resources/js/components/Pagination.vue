<template>
    <div class="flex items-center justify-between border-t border-white/10 px-8 py-8 sm:px-6 bg-gray-800">
        <div class="flex flex-1 justify-between sm:hidden">
        <a href="#" class="relative inline-flex items-center rounded-md border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium text-gray-200 hover:bg-white/10">Anterior</a>
        <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium text-gray-200 hover:bg-white/10">Próximo</a>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-300">
                Mostrando
                <span class="font-medium">{{from}}</span>
                a
                <span class="font-medium">{{to}}</span>
                de
                <span class="font-medium">{{total}}</span>
                resultados
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md" aria-label="Pagination">
                    <div @click="previousPage" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 inset-ring inset-ring-gray-700 hover:bg-white/5 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Anterior</span>
                        <ChevronLeftIcon class="size-5" aria-hidden="true" />
                    </div>
                    <div  @click="goToPage(page.page)" :class="page.page == currentPage ? selectedNumberClasses : unselectedNumberClasses" v-for="page in removeNotNumberPages()" >{{page.label}}</div>
                    <div @click="nextPage" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 inset-ring inset-ring-gray-700 hover:bg-white/5 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Próximo</span>
                        <ChevronRightIcon class="size-5" aria-hidden="true" />
                    </div>
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid'
    
    defineProps({
        pages: Array,
        from: Number,
        to: Number,
        total: Number 
    })
</script>
<script>
    export default {
        data() {
            return { 
                currentPage: 1,
                selectedNumberClasses: "relative z-10 inline-flex items-center bg-indigo-500 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500",
                unselectedNumberClasses: "relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-200 inset-ring inset-ring-gray-700 hover:bg-white/5 focus:z-20 focus:outline-offset-0"    
            }
        },
        methods: {
            nextPage() {
                if(this.currentPage < this.removeNotNumberPages().length) {
                    this.currentPage++;
                }
                this.$emit('pageChanged', this.currentPage);
            },
            previousPage() {
                if(this.currentPage > 1) {
                    this.currentPage--;
                }
                this.$emit('pageChanged', this.currentPage);
            },  
            goToPage(page) {
                if(page == null) {
                    return;
                }

                this.currentPage = page;
                this.$emit('pageChanged', this.currentPage);
            },
            removeNotNumberPages() {
                return this.pages.filter(((page) => !isNaN(page.label) || page.label == "..." ));
            }
        }
    }
</script>