<template>
  <div>
    <h1 class="text-3xl font-semibold mb-4">{{ signedUp ? 'Log in' : 'Create User' }}</h1>
    <form v-if="!signedUp" action="#" @submit.prevent="createUser">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input v-model="userData.name"
               class="form-control"
               id="name" type="text" placeholder="Peter Glücklich"
               required
        >
      </div>
      <div class="mb-3">
        <label for="mail" class="form-label">Mail</label>
        <input v-model="userData.email"
               class="form-control"
               id="mail" type="text" placeholder="peter@glücklich.de"
               required
        >
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input
            v-model="userData.password"
            type="password"
            class="form-control"
            id="password"
            required
        >
      </div>
      <button
          type="submit"
          @submit.prevent="createUser"
          class="btn btn-primary">
        Create User
      </button>
    </form>
    <form v-else action="#" @submit.prevent="handleLogin">
      <div class="mb-3">
        <label for="mail" class="form-label">Mail</label>
        <input v-model="userData.email"
               class="form-control"
               id="mail" type="text"
               placeholder="peter@glücklich.de"
               required
        >
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input
            v-model="userData.password"
            type="password"
            class="form-control"
            id="password"
            required
        >
      </div>

      <p class="text-sm mt-3 text-gray-600">
        <a @click="signedUp = !signedUp" class="underline cursor-pointer">Sign up</a>
      </p>

      <button
          type="submit"
          @submit.prevent="handleLogin"
          class="btn btn-primary">
        Login
      </button>

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
  onSuccess: (data) => {
    signedUp.value = true;
  }
})

const verify = useMutation({
  mutationFn: verifyCall,
  onError: errorHandling,
  onSuccess: (data) => {
    localStorage.setItem('token', data)
    reroute()
  }
})

const createUser = () => {
  postUser.mutateAsync(
      {
        name: userData.name,
        email: userData.email,
        password: userData.password,
      }
  );
}

const handleLogin = () => {
  verify.mutateAsync({
    email: userData.email,
    password: userData.password,
  });
}

const reroute = () => router.push({
  name: 'home'
})

</script>
