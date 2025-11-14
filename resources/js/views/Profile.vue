<script setup>
    import { ref } from 'vue'
    import Header from '../components/Header.vue'
    import Footer from '../components/Footer.vue'
    import ProfileBody from '../components/ProfileBody.vue'

    const count = ref(0)
</script>

<template>
    <Header/>
    <ProfileBody/>
    <Footer/>
</template>
