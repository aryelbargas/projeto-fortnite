<template>
    <div class="bg-gray-800">
        <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <img class="mx-auto h-10 w-auto" src="https://cms-assets.unrealengine.com/AVzjeqAbLRKi3W5jq0CAvz/cmh5593q16fl807o62o6ern9j" alt="Your Company" />
                <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Cadastre sua conta</h2>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form @submit.prevent="createUser" class="space-y-6" action="#" method="POST">
                    <div>
                        <label for="email" class="block text-sm/6 font-medium text-gray-100">Nome</label>
                        <div class="mt-2">
                            <input v-model="name" type="text" name="name" id="name" required class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm/6 font-medium text-gray-100">Email</label>
                        <div class="mt-2">
                            <input v-model="email" type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm/6 font-medium text-gray-100">Crie uma senha</label>
                        </div>
                        <div class="mt-2">
                            <input v-model="password" type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Cadastrar</button>
                    </div>
                </form>

                <p class="mt-10 text-center text-sm/6 text-gray-400">
                    Já tem conta?
                    {{ ' ' }}
                    <a href="c" class="font-semibold text-indigo-400 hover:text-indigo-300">Entre na sua conta</a>
                </p>
                <p class="mt-10 text-center text-sm/6">
                    <a href="/" class="font-semibold text-indigo-300 hover:text-indigo-300 text-center">< Voltar</a>
                </p>
            </div>
        </div>
    </div>
</template>
<script setup>
    import { ref } from 'vue'
    import VueCookie from "vue-cookie";
    import {useToast} from 'vue-toast-notification';
    import 'vue-toast-notification/dist/theme-sugar.css';
</script>
<script>
    export default {
        data() {
            return { 
                name: "",
                email: "",
                password: "",
                error: null
            }
        },
        methods: {
            createUser() {
                var data = {
                    name: this.name,
                    email: this.email,
                    password: this.password
                };

                this.axios.post("/api/user", data)
                .then((response) => {
                    this.error = null;

                    VueCookie.set("token", response.data.token_data.access_token);
                    VueCookie.set("name", response.data.user.name);
                    VueCookie.set("email",  response.data.user.email);

                    this.$router.push({ path: '/' })
                })
                .catch((error) => {
                    this.error = "Erro ao criar usuário.";
                    useToast().error(this.error);
                });
            }
        }
    }
</script>
