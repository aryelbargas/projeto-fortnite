<script setup>
import { ref } from 'vue'
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
import Gallery from '../components/Gallery.vue'

const count = ref(0)
</script>

<template>
  <Header/>
  <Gallery/>
  <Footer/>
</template>