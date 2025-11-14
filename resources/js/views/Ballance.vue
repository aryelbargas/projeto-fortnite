<script setup>
  import { ref } from 'vue'
  import Header from '../components/Header.vue'
  import Footer from '../components/Footer.vue'
  import Pagination from '../components/Pagination.vue'
  import TableBallance from "../components/TableBallance.vue";

  const count = ref(0)
</script>

<template>
  <Header/>
  <TableBallance :registers="registers"/>
  <div>
      <Pagination :pages="pages" :from="from" :to="to" :total="total" @pageChanged="fetchBallance"/>
  </div>
  <Footer/>
</template>
<script>
    export default {
        data() {
            return {
                registers: [],
                pages: [],
                from: 0,
                to: 0,
                total: 0
            }
        },
        created() {
            this.fetchBallance(1);
        },
        methods: {
            fetchBallance(page) {this.axios.get("/api/user/ballance?page=" + page).then((response) => {
                    this.registers = response.data.data;
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