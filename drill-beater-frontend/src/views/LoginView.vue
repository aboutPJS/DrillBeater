<template>
  <div class="pt-16">
    <h1 class="text-3xl font-semibold mb-4">{{ signedUp ? 'Log in' : 'Create User' }}</h1>
    <form v-if="!signedUp" action="#" @submit.prevent="createUser">
      <div class="overflow-hidden shadow sm:rounded-md max-w-sm mx-auto text-left">
        <div class="bg-white px-4 py-5 sm:p-6">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
              Name
            </label>
            <input v-model="userData.name"
                   class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                   id="name" type="text" placeholder="Hans">
          </div>
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="mail">
              Mail
            </label>
            <input v-model="userData.email"
                   class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                   id="mail" type="text" placeholder="hans@web.de">
          </div>
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
              Password
            </label>
            <input v-model="userData.password"
                   class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                   id="password" type="text">
          </div>

          <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
            <button
                type="submit"
                @submit.prevent="createUser"
                class="inline-flex justify-center rounded-md border border-transparent bg-black py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-600">
              Create User

            </button>
          </div>
        </div>
      </div>
    </form>
    <form v-else action="#" @submit.prevent="handleLogin">
      <div class="overflow-hidden shadow sm:rounded-md max-w-sm mx-auto text-left">
        <div class="bg-white px-4 py-5 sm:p-6">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="mail">
              Mail
            </label>
            <input v-model="userData.email"
                   class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                   id="mail" type="text" placeholder="hans@web.de">
          </div>
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
              Password
            </label>
            <input v-model="userData.password"
                   class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                   id="password" type="text">
          </div>
          <div class="bg-gray-50 px-4 py-3 text-right sm:px-6 flex justify-between">
            <button
                type="submit"
                @submit.prevent="handleLogin"
                class="inline-flex justify-center rounded-md border border-transparent bg-black py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-600">
              Login
            </button>

            <button
                type="submit"
                @click="signedUp = !signedUp"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
              Create Account
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>

</template>


<script setup>
import {onMounted, reactive, ref} from "vue";
import {useRouter} from "vue-router";
import {vMaska} from 'maska'
import {useMutation} from '@tanstack/vue-query'
import {errorHandling, loginCall, verifyCall} from "@/helpers/ApiCalls.ts";

const signedUp = ref(true)

const userData = reactive({
  name: '',
  email: '',
  password: ''
})

const router = useRouter()

onMounted(() => {
  if (localStorage.getItem('token')) {
    reroute()
  }
})

const postUser = useMutation({
  mutationFn: loginCall,
  onError: errorHandling,
})

const verify = useMutation({
  mutationFn: verifyCall,
  onError: errorHandling
})


const createUser = () => {
  postUser.mutateAsync(
      {
        name: userData.name,
        email: userData.email,
        password: userData.password,
      }
  ).then(() => {
    signedUp.value = true;
  });
};

const handleLogin = () => {

  verify.mutateAsync({
    email: userData.email,
    password: userData.password,
  }).then((data) => {
    localStorage.setItem('token', data)
    reroute()
  });
};

const reroute = () => router.push({
  name: 'home'
})

</script>
